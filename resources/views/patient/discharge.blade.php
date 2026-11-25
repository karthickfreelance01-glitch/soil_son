@php use Carbon\Carbon; @endphp

@extends('layout.admin')

@section('content')
<div class="main-wrapper">
@include('include.header')
@include('include.sidebar')

<div class="page-wrapper">
<div class="content pb-0">

<form id="dischargeForm" method="POST" action="{{ route('patient.discharge.confirm') }}">
@csrf
<input type="hidden" name="patient_id" value="{{ $patient->id }}">
<input type="hidden" id="final_amount_input" name="final_amount" value="{{ $totalPending }}">

<div class="card shadow-lg border-0 p-5 mt-4 mb-5 rounded-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold text-primary mb-1">PATIENT DISCHARGE BILL</h2>
            <p class="text-muted">Final Billing & Discharge Summary</p>
        </div>
        <div>
            <a href="{{ route('patient.discharge.pdf', $patient->id) }}" target="_blank"
               class="btn btn-outline-danger">
               <i class="fas fa-file-pdf me-2"></i>Download PDF
            </a>
        </div>
    </div>

    <hr>

    <!-- Patient Info -->
    <div class="row mb-4">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr><th>Patient Name:</th><td>{{ $patient->name }}</td></tr>
                <tr><th>IP Number:</th><td>{{ $patient->ip_number }}</td></tr>
                <tr><th>Gender:</th><td>{{ $patient->gender }}</td></tr>
                <tr><th>Contact:</th><td>{{ $patient->contact_number }}</td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th>Admission Date:</th>
                    <td id="admission_date" data-iso="{{ $admissionDate->format('Y-m-d') }}">
                        {{ $admissionDate->format('d-m-Y') }}
                    </td>
                </tr>
                <!--<tr>-->
                <!--    <th>Discharge Date:</th>-->
                <!--    <td>-->
                <!--        <input type="date" name="discharge_date" id="discharge_date"-->
                <!--               value="{{ $dischargeDate->format('Y-m-d') }}" class="form-control" required>-->
                <!--    </td>-->
                <!--</tr>-->
                <tr>
    <th>Discharge Date:</th>
    <td>
        <input type="date" name="discharge_date" id="discharge_date"
               value="{{ $dischargeDate->format('Y-m-d') }}" class="form-control" required
               onchange="window.location.href = '{{ url('patients/discharge/'.$patient->id) }}?discharge_date=' + this.value">
    </td>
</tr>
                <tr><th>Months Stayed:</th><td><span id="months_stayed">{{ $monthsStayed }}</span> month(s)</td></tr>
                <tr><th>Extra Days:</th><td><span id="extra_days">{{ $extraDays }}</span> day(s)</td></tr>
            </table>
        </div>
    </div>

    <hr>

    <!-- Stay Details -->
    <h5 class="fw-bold text-primary mt-3 mb-2">STAY (MONTHLY) DETAILS</h5>
    <table class="table table-bordered align-middle" id="stay_table">
        <thead class="table-primary text-center">
            <tr><th>S.No</th><th>Category</th><th>Period</th><th class="text-end">Total (₹)</th></tr>
        </thead>
        <tbody>
            @foreach($filledBills as $i => $b)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $b['category'] }}</td>
                <td>{{ $b['period'] }}</td>
                <td class="text-end">₹ {{ number_format($b['total_amount'],2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- All Billings -->
    <h5 class="fw-bold text-primary mt-4 mb-2">CATEGORY-WISE BILL SUMMARY</h5>
    <table class="table table-bordered align-middle">
        <thead class="table-secondary text-center">
            <tr>
                <th>Category</th>
                <th class="text-end">Total (₹)</th>
                <th class="text-end">Received (₹)</th>
                <th class="text-end">Pending (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allBillings as $bill)
            <tr>
                <td>{{ ucfirst($bill->category) }}</td>
                <td class="text-end">{{ number_format($bill->total_amount, 2) }}</td>
                <td class="text-end">{{ number_format($bill->total_received, 2) }}</td>
                <td class="text-end text-danger fw-semibold">{{ number_format($bill->total_pending, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="row mt-4">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr><th>Total Amount</th><td class="text-end">₹ <span id="total_amount">{{ number_format($totalAmount,2) }}</span></td></tr>
                <tr><th>Total Received</th><td class="text-end">₹ <span id="total_received">{{ number_format($totalReceived,2) }}</span></td></tr>
                <tr><th>Total Pending</th><td class="text-end text-danger fw-bold">₹ <span id="pending_amount">{{ number_format($totalPending,2) }}</span></td></tr>
                <tr class="table-success"><th>Discount (₹)</th><td><input type="number" id="discount" class="form-control text-end" value="0" min="0"></td></tr>
                <tr class="table-success"><th>Final Amount to Pay</th><td><input type="number" id="final_amount_box" class="form-control text-end fw-bold fs-5" value="{{ number_format($totalPending,2,'.','') }}" readonly></td></tr>
                <tr class="table-success align-middle"> <th class="fw-bold">Payment Mode</th> <td>
                    <select name="payment_mode" id="payment_mode" class="form-select fw-bold fs-5" required>
                                            <option value="" disabled selected>-- Select Payment Mode --</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Card">Card</option>
                                            <option value="UPI">UPI</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </td>
                                </tr>
                <tr class="table-success align-middle"> <th class="fw-bold">Account Type</th> 
                <td>
                    <select name="account_type" id="" class="form-select fw-bold fs-5" required>
                        <option value="">-- Select Account type --</option>
                        <option value="Cash">Cash</option>
                        <option value="Savings-SBI">Savings SBI</option>
                        <option value="Savings_TMB">Savings TMB</option>
                        <option value="Current account">Current account</option>
                        <option value="Others">Others</option>
                    </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    

    <!-- Notes -->
    <div class="mt-4">
        <label class="fw-bold text-primary">Discharge Advice / Notes</label>
        <textarea name="discharge_advice" id="discharge_advice" class="form-control" rows="4" placeholder="Enter discharge notes..."></textarea>
    </div>

    <div class="text-center mt-4">
        <button type="button" id="confirmBtn" class="btn btn-success btn-lg px-5">
            <i class="fas fa-check-circle me-2"></i>Confirm Discharge
        </button>
    </div>
</div>
</form>
</div>
</div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const admissionIso = document.getElementById('admission_date').dataset.iso;
    const dischargeInput = document.getElementById('discharge_date');
    const monthsEl = document.getElementById('months_stayed');
    const daysEl = document.getElementById('extra_days');
    const discountInput = document.getElementById('discount');
    const totalAmountEl = document.getElementById('total_amount');
    const pendingEl = document.getElementById('pending_amount');
    const finalBox = document.getElementById('final_amount_box');
    const finalHidden = document.getElementById('final_amount_input');

    const totalReceived = parseFloat({{ $totalReceived ?? 0 }});
    const baseTotal = parseFloat({{ $totalAmount ?? 0 }});
    const monthlyRate = parseFloat({{ $monthlyRate ?? 0 }});
    const oldExtraDays = parseFloat({{ $extraDays ?? 0 }});

    function formatCurrency(amount) {
        return parseFloat(amount).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function calculateStay(admission, discharge) {
        const a = new Date(admission);
        const d = new Date(discharge);
        if (isNaN(a) || isNaN(d) || d < a) return { months: 0, days: 0 };

        let months = 0;
        let temp = new Date(a);
        while (true) {
            let next = new Date(temp);
            next.setMonth(next.getMonth() + 1);
            if (next <= d) {
                months++;
                temp = next;
            } else break;
        }
        const days = Math.floor((d - temp) / (1000 * 60 * 60 * 24));
        return { months, days };
    }

    function recalc() {
        const dischargeDate = dischargeInput.value;
        if (!dischargeDate) return;

        const { months, days } = calculateStay(admissionIso, dischargeDate);
        monthsEl.textContent = months;
        daysEl.textContent = days;

        let totalWithExtra = baseTotal;
        if (days !== oldExtraDays && monthlyRate > 0) {
            const extraCharge = (monthlyRate / 30) * days;
            const oldExtraCharge = (monthlyRate / 30) * oldExtraDays;
            totalWithExtra = baseTotal - oldExtraCharge + extraCharge;
        }

        const pending = Math.max(totalWithExtra - totalReceived, 0);
        const discount = parseFloat(discountInput.value) || 0;
        const final = Math.max(pending - discount, 0);

        totalAmountEl.textContent = formatCurrency(totalWithExtra);
        pendingEl.textContent = formatCurrency(pending);
        finalBox.value = final.toFixed(2);
        finalHidden.value = final.toFixed(2);
    }

    dischargeInput.addEventListener('change', recalc);
    dischargeInput.addEventListener('input', recalc);
    discountInput.addEventListener('input', recalc);
    recalc();

    // ✅ Fixed Submit
    document.getElementById('confirmBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Confirm Discharge?',
            text: 'Finalize discharge and save billing details?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Confirm',
            confirmButtonColor: '#28a745'
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('dischargeForm').submit(); // ✅ works now
            }
        });
    });
});
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#discharge_advice')).catch(err => console.error(err));
</script>
@endsection
