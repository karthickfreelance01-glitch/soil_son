<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineIssueController extends Controller
{
    // Show all medicine issues
public function index()
{
    $issues = DB::table('medicine_bill')
        ->join('patients', 'medicine_bill.patient_id', '=', 'patients.id')
        ->leftJoin('medicine_issues', 'medicine_bill.bill_id', '=', 'medicine_issues.bill_id')
        ->leftJoin('medicines', 'medicine_issues.drug_id', '=', 'medicines.id')
        ->select(
            'medicine_bill.bill_id',
            'patients.name as patient_name',
            // Use COALESCE to provide a fallback date if it's empty in DB
            DB::raw('COALESCE(medicine_bill.from_date, medicine_bill.issue_date) as from_date'),
            DB::raw('COALESCE(medicine_bill.to_date, medicine_bill.issue_date) as to_date'),
            DB::raw('GROUP_CONCAT(medicines.drug_name SEPARATOR ", ") as drugs'),
            DB::raw('GROUP_CONCAT(medicine_issues.drug_count SEPARATOR ", ") as drug_counts'),
            DB::raw('GROUP_CONCAT(medicine_issues.price SEPARATOR ", ") as prices'),
            DB::raw('MAX(medicine_bill.final_amount) as final_amount'),
            DB::raw('MAX(medicine_bill.pending_payment) as pending_payment'),
            DB::raw('MAX(medicine_bill.issue_date) as issue_date'),
            DB::raw('MAX(medicine_bill.issue_time) as issue_time')
        )
        // Grouping must include all non-aggregated columns
        ->groupBy(
            'medicine_bill.bill_id', 
            'patients.name', 
            'medicine_bill.from_date', 
            'medicine_bill.to_date',
            'medicine_bill.issue_date'
        )
        ->orderBy('medicine_bill.issue_date', 'desc')
        ->get();

    return view('medicine_issues.index', compact('issues'));
}



   public function show($bill_id)
{
    // Fetch the main bill
    $bill = DB::table('medicine_bill')
        ->join('patients', 'medicine_bill.patient_id', '=', 'patients.id')
        ->select(
            'medicine_bill.*',
            'patients.name',
            'patients.ip_number'
        )
        ->where('medicine_bill.bill_id', $bill_id)
        ->first();

    if (!$bill) {
        return redirect()->back()->with('error', 'Bill not found');
    }

    // Fetch medicines for this bill
    $medicines = DB::table('medicine_issues')
        ->join('medicines', 'medicine_issues.drug_id', '=', 'medicines.id')
        ->select(
            'medicines.drug_name',
            'medicine_issues.drug_count',
            'medicine_issues.price'
        )
        ->where('medicine_issues.bill_id', $bill_id)
        ->get();

    // Calculate total
    $totalAmount = $medicines->sum(function($item) {
        return $item->price * $item->drug_count;
    });

    return view('medicine_issues.bill_view', compact('bill', 'medicines', 'totalAmount'));
}

    // Show form to create new issue
    public function create()
    {
        // Fetch patients
        $patients = DB::table('patients')->select('id', 'name', 'date_of_admission','ip_number')->get();

        // Fetch drugs with current stock > 0
        $drugs = DB::table('medicines')
            ->leftJoin('medicine_issues', 'medicines.id', '=', 'medicine_issues.drug_id')
            ->select(
                'medicines.id',
                'medicines.drug_name',
                'medicines.selling_price',
                'medicines.stock',
                DB::raw('IFNULL(SUM(medicine_issues.drug_count), 0) as issued_count')
            )
            ->groupBy('medicines.id', 'medicines.drug_name', 'medicines.stock',
            'medicines.selling_price')
            ->get()
            ->map(function($item) {
                $item->current_stock = $item->stock - $item->issued_count;
                return $item;
            });
            


        return view('medicine_issues.create', compact('patients', 'drugs'));
    }

    // Store medicine issue
//  public function store(Request $request)
// {
//     // Validate input
//     $request->validate([
//         'patient_id' => 'required|exists:patients,id',
//         'drugs.*.id' => 'required|exists:medicines,id',
//         'drugs.*.count' => 'required|integer|min:1',
//         'issue_time' => 'required',
//         'issue_date' => 'required|date',
//     ]);

//     // Insert each drug as a separate row
//     foreach ($request->drugs as $drug) {
//         DB::table('medicine_issues')->insert([
//             'patient_id' => $request->patient_id,
//             'drug_id'    => $drug['id'],
//             'drug_count' => $drug['count'],
//             'issue_time' => $request->issue_time,
//             'issue_date' => $request->issue_date,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);
//     }

//     return redirect('medicine-issues')->with('success', 'Medicine issued successfully!');
// }

   public function store(Request $request)
{
    
    $request->validate([
        'patient_id' => 'required',
        
        'drugs' => 'required|array|min:1',
        'drugs.*.id' => 'required',
        'drugs.*.count' => 'required|numeric|min:1',
        'hospital_account_id' => 'required',
        'payment_mode' => 'required',
    ]);

    // 2. ✅ Database Transaction Start
    DB::beginTransaction();

    try {
        // Unique Bill ID generation
        $billId = 'BILL' . date('YmdHis');

        // 3. ✅ Totals Calculation logic
        $overallTotal = 0;
        foreach ($request->drugs as $drug) {
            $linePrice = $drug['price'] ?? 0;
            $lineCount = $drug['count'] ?? 0;
            $lineTotal = $linePrice * $lineCount;
            $overallTotal += $lineTotal;
        }

        $finalAmount = round($overallTotal);
        $roundOff = $finalAmount - $overallTotal;
        $initialPayment = $request->initial_payment ?? 0;
        $pendingPayment = $finalAmount - $initialPayment;

        // 4. ✅ Insert into 'medicine_issues' table (Looping through drugs)
        foreach ($request->drugs as $drug) {
            DB::table('medicine_issues')->insert([
                'bill_id'    => $billId,
                'patient_id' => $request->patient_id,
                'drug_id'    => $drug['id'],
                'drug_count' => $drug['count'],
                'complaints' => $drug['complaints'] ?? null,
                'price'      => $drug['price'] ?? 0,
                'line_total' => ($drug['price'] ?? 0) * ($drug['count'] ?? 0),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // (Optional) Inga stock minus panna logic venum na add panniko
            // DB::table('drugs')->where('id', $drug['id'])->decrement('current_stock', $drug['count']);
        }

        // 5. ✅ Insert into 'medicine_bill' table with From & To Dates
        DB::table('medicine_bill')->insert([
            'bill_id'          => $billId,
            'hospital_account' => $request->hospital_account_id,
            'patient_id'       => $request->patient_id,
            'overall_total'    => $overallTotal,
            'round_off'        => $roundOff,
            'final_amount'     => $finalAmount,
            'payment_mode'     => $request->payment_mode,
            'initial_payment'  => $initialPayment,
            'pending_payment'  => $pendingPayment,
            'from_date'        => $request->from_date, // New Field
            'to_date'          => $request->to_date,   // New Field
            'issue_time'       => $request->issue_time,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        // Ellam correct-ah iruntha save pannu
        DB::commit();

        return redirect('medicine-issues')->with('success', "Bill ($billId) generated successfully from $request->from_date to $request->to_date!");

    } catch (\Exception $e) {
        // Error vantha logic-ah cancel pannu
        DB::rollback();
        Log::error("Medicine Issue Error: " . $e->getMessage());

        return back()->with('error', 'Something went wrong! ' . $e->getMessage())->withInput();
    }
}

     public function discharge($id)
    {
        $issues = DB::table('medicine_bill')
            ->join('patients', 'medicine_bill.patient_id', '=', 'patients.id')
            ->leftJoin('medicine_issues', 'medicine_bill.bill_id', '=', 'medicine_issues.bill_id')
            ->leftJoin('medicines', 'medicine_issues.drug_id', '=', 'medicines.id')
            ->select(
                'medicine_bill.id',
                'medicine_bill.bill_id',
                'patients.name as patient_name',
                'medicine_bill.overall_total',
                'medicine_bill.payment_mode',
                'medicine_bill.issue_date',
                'medicine_bill.issue_time',
                DB::raw('GROUP_CONCAT(medicines.drug_name SEPARATOR ", ") as drugs'),
                DB::raw('GROUP_CONCAT(medicine_issues.drug_count SEPARATOR ", ") as drug_counts'),
                DB::raw('GROUP_CONCAT(medicine_issues.price SEPARATOR ", ") as prices')
            )
            ->groupBy(
                'medicine_bill.id',
                'medicine_bill.bill_id',
                'patients.name',
                'medicine_bill.overall_total',
                'medicine_bill.payment_mode',
                'medicine_bill.issue_date',
                'medicine_bill.issue_time'
            )
            ->orderByDesc('medicine_bill.id')
            ->get();

        return view('medicine_issues.index', compact('issues'));
    }

    // Show edit form
   public function edit($bill_id)
    {
        // Fetch the main bill
        $bill = DB::table('medicine_bill')
            ->where('bill_id', $bill_id)
            ->first();

        if (!$bill) {
            return redirect()->back()->with('error', 'Bill not found');
        }

        // Fetch patient info
        $patient = DB::table('patients')->where('id', $bill->patient_id)->first();

        // Fetch all patients for dropdown
        $patients = DB::table('patients')->select('id', 'name', 'date_of_admission')->get();

        // Fetch all medicines with current stock
        $drugs = DB::table('medicines')
            ->leftJoin('medicine_issues', 'medicines.id', '=', 'medicine_issues.drug_id')
            ->select(
                'medicines.id',
                'medicines.drug_name',
                'medicines.selling_price',
                'medicines.stock',
                DB::raw('IFNULL(SUM(medicine_issues.drug_count), 0) as issued_count')
            )
            ->groupBy('medicines.id', 'medicines.drug_name', 'medicines.stock', 'medicines.selling_price')
            ->get()
            ->map(function($item) {
                $item->current_stock = $item->stock - $item->issued_count;
                return $item;
            });

        // Fetch issued medicines for this bill
        $issuedDrugs = DB::table('medicine_issues')
            ->where('bill_id', $bill_id)
            ->get();

        return view('medicine_issues.edit', compact('bill', 'patient', 'patients', 'drugs', 'issuedDrugs'));
    }
    // Update medicine issue
   public function update(Request $request, $bill_id)
{
    // 1. Debugging: See if the data even reaches here
    // dd($request->all()); 

   

    try {
        DB::transaction(function () use ($request, $bill_id) {
            $overallTotal = 0;
            foreach ($request->drugs as $drug) {
                $overallTotal += ($drug['count'] * ($drug['price'] ?? 0));
            }

            $finalAmount = round($overallTotal);
            $roundOff = $finalAmount - $overallTotal;
            $initialPayment = $request->initial_payment ?? 0;
            $pendingPayment = $finalAmount - $initialPayment;

            // Update Main Bill
            $updated = DB::table('medicine_bill')
                ->where('bill_id', $bill_id)
                ->update([
                    'patient_id'      => $request->patient_id,
                    'from_date'       => $request->from_date,
                    'to_date'         => $request->to_date,
                    'overall_total'   => $overallTotal,
                    'round_off'       => $roundOff,
                    'final_amount'    => $finalAmount,
                    'payment_mode'    => $request->payment_mode,
                    'initial_payment' => $initialPayment,
                    'pending_payment' => $pendingPayment,
                    'issue_date'      => $request->issue_date,
                    'issue_time'      => $request->issue_time,
                    'updated_at'      => now(),
                ]);

            // Sync Drugs
            DB::table('medicine_issues')->where('bill_id', $bill_id)->delete();

            $insertData = [];
            foreach ($request->drugs as $drug) {
                if (!empty($drug['id'])) {
                    $insertData[] = [
                        'bill_id'    => $bill_id,
                        'patient_id' => $request->patient_id,
                        'drug_id'    => $drug['id'],
                        'drug_count' => $drug['count'],
                        'price'      => $drug['price'] ?? 0,
                        'line_total' => ($drug['count'] * ($drug['price'] ?? 0)),
                        'issue_date' => $request->issue_date,
                        'issue_time' => $request->issue_time,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            DB::table('medicine_issues')->insert($insertData);
        });

        return redirect('medicine-issues')->with('success', 'Updated Successfully!');

    } catch (\Exception $e) {
        // This will stop the page and show you EXACTLY what went wrong
        dd($e->getMessage());
    }
}


    // Delete medicine issue
  public function destroy($bill_id)
{
    try {
        DB::transaction(function () use ($bill_id) {
            // 1. Get issued drugs to put stock back
            $items = DB::table('medicine_issues')->where('bill_id', $bill_id)->get();

            foreach ($items as $item) {
                DB::table('medicines')
                    ->where('id', $item->drug_id)
                    ->increment('stock', $item->drug_count); // Use 'stock' or 'current_stock' based on your table
            }

            // 2. Delete child records (Medicine Issues)
            DB::table('medicine_issues')->where('bill_id', $bill_id)->delete();

            // 3. Delete parent record (The Bill)
            DB::table('medicine_bill')->where('bill_id', $bill_id)->delete();
        });

        return redirect('medicine-issues')->with('success', 'Bill deleted and stock updated successfully!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Delete failed: ' . $e->getMessage());
    }
}


    // Fetch patient details by ID (for AJAX)
    public function getPatient($id)
    {
        $patient = DB::table('patients')->where('id', $id)->first();
        return response()->json($patient);
    }

    public function stock()
    {
        $medicines = DB::table('medicines')
            ->leftJoin('medicine_issues', 'medicines.id', '=', 'medicine_issues.drug_id')
            ->select(
                'medicines.id',
                'medicines.drug_name',
                'medicines.category_id',
                'medicines.manufactured_date',
                'medicines.expiry_date',
                'medicines.price',
                'medicines.selling_price',
                'medicines.stock',
                DB::raw('IFNULL(SUM(medicine_issues.drug_count), 0) as issued_count')
            )
            ->groupBy(
                'medicines.id',
                'medicines.drug_name',
                'medicines.category_id',
                'medicines.manufactured_date',
                'medicines.expiry_date',
                'medicines.price',
                'medicines.selling_price',
                'medicines.stock'
            )
            ->get();

        return view('medicine_issues.stock', compact('medicines'));
    }

    // Show report filter form
public function report(Request $request)
{
    $patients = DB::table('patients')->select('id', 'name')->get();

    $query = DB::table('medicine_bill')
        ->join('patients', 'medicine_bill.patient_id', '=', 'patients.id')
        ->leftJoin('medicine_issues', 'medicine_bill.bill_id', '=', 'medicine_issues.bill_id')
        ->leftJoin('medicines', 'medicine_issues.drug_id', '=', 'medicines.id')
        ->select(
            'patients.ip_number as patient_ip_number',
            'patients.name as patient_name',
            'patients.age',
            'patients.date_of_admission',
            'medicines.drug_name',
            'medicine_bill.from_date',
            'medicine_bill.to_date',
            'medicine_issues.drug_count',
            'medicine_issues.complaints',
            'medicine_bill.issue_time'
        );

    // Filter Logic
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('medicine_bill.from_date', [$request->start_date, $request->end_date]);
    }
    if ($request->filled('patient_id')) {
        $query->where('patients.id', $request->patient_id);
    }

    $issues = $query->orderBy('medicine_bill.from_date', 'desc')->get();

    // NEW GROUPING: Group by Patient Name, then by Medicine Details
    $groupedByPatient = $issues->groupBy('patient_name')->map(function ($patientRows) {
        return $patientRows->groupBy(function ($item) {
            return $item->from_date . '|' . $item->drug_name;
        })->map(function ($rows) {
            $first = $rows->first();
            return (object)[
                'ip_number'     => $first->patient_ip_number,
                'age'        => $first->age,
                'doa'        => $first->date_of_admission,
                'start'      => $first->from_date ? \Carbon\Carbon::parse($first->from_date)->format('d-m-Y') : 'N/A',
                'end'        => $first->to_date ? \Carbon\Carbon::parse($first->to_date)->format('d-m-Y') : 'N/A',
                'drug_name'  => $first->drug_name,
                'complaints' => $first->complaints,
                'mor' => $rows->filter(fn($r) => stripos($r->issue_time, 'Morning') !== false)->sum('drug_count'),
                'at'  => $rows->filter(fn($r) => stripos($r->issue_time, 'Afternoon') !== false)->sum('drug_count'),
                'eve' => $rows->filter(fn($r) => (stripos($r->issue_time, 'Night') !== false || stripos($r->issue_time, 'Evening') !== false))->sum('drug_count'),
            ];
        });
    });

    return view('medicine_issues.report', compact('patients', 'issues', 'groupedByPatient'));
}

    public function addNextPayment(Request $request)
{
   

    // Fetch bill details
    $bill = DB::table('medicine_bill')->where('bill_id', $request->bill_id)->first();

    if (!$bill) {
        return response()->json(['message' => 'Bill not found!'], 404);
    }

    if ($bill->pending_payment <= 0) {
        return response()->json(['message' => 'No pending amount to pay!'], 400);
    }

    // Insert next payment into medicine_payments table
    DB::table('medicine_bill')->insert([
        'bill_id' => $request->bill_id,
        'patient_id' => $bill->patient_id, // store patient_id
        'initial_payment' => $request->next_payment_amount,
        'issue_date' => $request->next_payment_date,
        'payment_mode' => $request->payment_mode,
        'hospital_account' => $request->hospital_account,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Update pending payment in medicine_bill table
    $newPending = $bill->pending_payment - $request->next_payment_amount;
    DB::table('medicine_bill')->where('bill_id', $request->bill_id)
        ->update(['pending_payment' => $newPending]);

    return response()->json(['message' => 'Next payment added successfully!']);
}


public function getPayments($bill_id)
{
    // Get all bill entries for this bill_id
    $bills = DB::table('medicine_bill')
        ->where('bill_id', $bill_id)
        ->orderBy('id', 'asc') // ensures payments are in chronological order
        ->get();

    if ($bills->isEmpty()) {
        return response()->json(['message' => 'Bill not found'], 404);
    }

    // Build payments array
    $payments = [];
    foreach ($bills as $bill) {
        $payments[] = [
            'payment_date' => \Carbon\Carbon::parse($bill->issue_date)->format('d-m-Y'),
            'amount' => $bill->initial_payment ?? 0, // or whichever column stores the payment
            'payment_mode' => ucfirst($bill->payment_mode),
            'hospital_account' => DB::table('payment_categories')->where('id', $bill->hospital_account)->value('payment_category') ?? 'N/A',
        ];
    }

    // Use the first row for main bill info
    $mainBill = $bills->first();

    return response()->json([
        'issue_date' => \Carbon\Carbon::parse($mainBill->issue_date)->format('d-m-Y'),
        'payment_mode' => ucfirst($mainBill->payment_mode),
        'hospital_account' => DB::table('payment_categories')->where('id', $mainBill->hospital_account)->value('payment_category') ?? 'N/A',
        'total_amount' => $mainBill->overall_total,
        'pending_amount' => $mainBill->pending_payment,
        'payments' => $payments
    ]);
}



}
