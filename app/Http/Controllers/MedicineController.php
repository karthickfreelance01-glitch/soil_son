<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{
       
    public function index()
    {
        $medicines = DB::table('medicines')
            ->join('medicine_categories', 'medicines.category_id', '=', 'medicine_categories.id')
            ->join('vendors', 'medicines.vendor_id', '=', 'vendors.id') // join vendors
            ->select(
                'medicines.*',
                'medicine_categories.medicine_category',
                'vendors.vendor_name' // select vendor name
            )
            ->get();

        return view('medicine.index', compact('medicines'));
    }


    public function create()
    {
        $categories = DB::table('medicine_categories')->pluck('medicine_category', 'id');
        $vendors = DB::table('vendors')->pluck('vendor_name', 'id'); // fetch vendor names
        return view('medicine.create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|integer',
            'drug_name.*' => 'required|string',
            'category_id.*' => 'required|integer',
            'manufactured_date.*' => 'required|date',
            'expiry_date.*' => 'required|date',
            'price.*' => 'required|numeric',
            'stock.*' => 'required|integer',
        ]);

        $count = count($request->drug_name);

        for ($i = 0; $i < $count; $i++) {
            DB::table('medicines')->insert([
                'vendor_id' => $request->vendor_id,
                'drug_name' => $request->drug_name[$i],
                'category_id' => $request->category_id[$i],
                'manufactured_date' => $request->manufactured_date[$i],
                'expiry_date' => $request->expiry_date[$i],
                'price' => $request->price[$i],
                'selling_price' => $request->price[$i] * 1.25,
                'stock' => $request->stock[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('medicine.index')->with('success', 'All medicines added successfully.');
    }


    public function edit($id)
    {
        $medicine = DB::table('medicines')->where('id', $id)->first();
        $categories = DB::table('medicine_categories')->pluck('medicine_category', 'id');
        return view('medicine.edit', compact('medicine', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'drug_name' => 'required|string',
            'category_id' => 'required|exists:medicine_categories,id',
            'manufactured_date' => 'required|date',
            'expiry_date' => 'required|date|after:manufactured_date',
            'price' => 'required|numeric|min:0',
        ]);

        DB::table('medicines')->where('id', $id)->update([
            'drug_name' => $request->drug_name,
            'category_id' => $request->category_id,
            'manufactured_date' => $request->manufactured_date,
            'expiry_date' => $request->expiry_date,
            'price' => $request->price,
            'selling_price' => $request->price * 1.25,
            'updated_at' => now(),
        ]);

        return redirect()->route('medicine.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('medicines')->where('id', $id)->delete();
        return back()->with('success', 'Medicine deleted successfully.');
    }

    // Stock re-entry
    public function stockEdit($id)
    {
        $medicine = DB::table('medicines')
            ->leftJoin('medicine_issues', 'medicines.id', '=', 'medicine_issues.drug_id')
            ->select(
                'medicines.id',
                'medicines.drug_name',
                'medicines.stock',
                DB::raw('IFNULL(SUM(medicine_issues.drug_count), 0) as issued_count')
            )
            ->where('medicines.id', $id)
            ->groupBy('medicines.id', 'medicines.drug_name', 'medicines.stock')
            ->first();

        // Calculate current stock
        $medicine->current_stock = $medicine->stock - $medicine->issued_count;

        return view('medicine.stock', compact('medicine'));
    }

    public function stockUpdate(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:1',
        ]);

        $currentStock = DB::table('medicines')->where('id', $id)->value('stock');

        DB::table('medicines')->where('id', $id)->update([
            'stock' => $currentStock + $request->stock,
            'updated_at' => now(),
        ]);

        return redirect()->route('medicine.index')->with('success', 'Stock updated successfully.');
    }
}
