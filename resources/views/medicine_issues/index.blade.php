@extends('layout.admin')

@section('content')
<div class="main-wrapper">
    @include('include.header')
    @include('include.sidebar')

    <div class="page-wrapper">
        <div class="content pb-0">
            <div class="container-fluid">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold"><i class="fas fa-file-medical-alt me-2 text-primary"></i>View Medicine Issues</h4>
                    <a href="{{ url('medicine-issues/create') }}" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus-circle me-1"></i> Add Issue
                    </a>
                </div>

                <div class="alert bg-white shadow-sm border-start border-danger border-4 d-flex justify-content-between align-items-center rounded-3 mb-4">
                    <h5 class="mb-0 fw-bold text-dark">Overall Pending Amount</h5>
                    <h4 class="mb-0 fw-bold text-danger">₹ <span id="overallPending">0.00</span></h4>
                </div>

                <div class="card shadow-lg rounded-4 border-0">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table id="medicineTable" class="table table-hover align-middle w-100">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Bill ID</th>
                                        <th>Patient Name</th>
                                        <th>Period (From-To)</th>
                                        <th>Medicine Details</th>
                                        <th>Total (₹)</th>
                                        <th>Pending (₹)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($issues as $index => $issue)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center fw-bold text-dark">{{ $issue->bill_id }}</td>
                                        <td>
                                            <span class="fw-bold text-primary">{{ $issue->patient_name }}</span>
                                        </td>
                                        <td class="text-center small fw-bold">
                                            {{ \Carbon\Carbon::parse($issue->from_date)->format('d-m-Y') }} <br> to <br>
                                            {{ \Carbon\Carbon::parse($issue->to_date)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            @php
                                                $drugs = explode(', ', $issue->drugs);
                                                $counts = explode(', ', $issue->drug_counts);
                                            @endphp
                                            <ul class="list-unstyled mb-0 small">
                                                @foreach($drugs as $key => $d)
                                                    <li><i class="fas fa-check-circle text-success me-1"></i> {{ $d }} ({{ $counts[$key] ?? 0 }})</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="text-end fw-bold text-dark">{{ number_format($issue->final_amount, 2) }}</td>
                                        <td class="text-end">
                                            <span class="badge {{ $issue->pending_payment > 0 ? 'bg-danger' : 'bg-success' }} px-3 py-2">
                                                {{ number_format($issue->pending_payment, 2) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group gap-1">
                                                @if($issue->pending_payment > 0)
                                                <button class="btn btn-sm btn-outline-success nextPaymentBtn" 
                                                        data-bill-id="{{ $issue->bill_id }}" 
                                                        data-pending="{{ $issue->pending_payment }}" title="Add Payment">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                @endif
                                                
                                                <a href="{{ route('medicine-issues.view', $issue->bill_id) }}" 
                                                   class="btn btn-sm btn-outline-info" target="_blank" title="Print">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                <a href="{{ url('medicine-issues/'.$issue->bill_id.'/edit') }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form id="delete-form-{{ $issue->bill_id }}" action="{{ url('medicine-issues/delete/'.$issue->bill_id) }}" method="POST" class="d-inline">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ $issue->bill_id }}')" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // DataTable Init
    var table = $('#medicineTable').DataTable({
        pageLength: 10,
        order: [[1, 'desc']], // Order by Bill ID
        dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 text-end'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row mt-3'<'col-sm-5'i><'col-sm-7 text-end'p>>",
    });

    // Dynamic Pending Calculation (Calculates only from visible/filtered rows)
    function updatePendingTotal() {
        let total = 0;
        table.rows({ search: 'applied' }).data().each(function(value, index) {
            // value[6] is the Pending column. We need to strip HTML and commas.
            let rawValue = $(value[6]).text().replace(/,/g, '');
            total += parseFloat(rawValue) || 0;
        });
        $('#overallPending').text(total.toLocaleString('en-IN', { minimumFractionDigits: 2 }));
    }

    // Update on load and every table draw (search/paginate)
    table.on('draw', updatePendingTotal);
    updatePendingTotal();

    // ... (Keep your existing SweetAlert and AJAX logic here) ...
});

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// 1. GLOBAL SCOPE: onclick functions need to be here
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the bill and return items to stock!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}

// 2. JQUERY SCOPE: DataTable and calculation logic here
$(document).ready(function() {
    var table = $('#medicineTable').DataTable({
        pageLength: 10,
        order: [[1, 'desc']],
        dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 text-end'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row mt-3'<'col-sm-5'i><'col-sm-7 text-end'p>>",
    });

    function updatePendingTotal() {
        let total = 0;
        table.rows({ search: 'applied' }).data().each(function(value, index) {
            let rawValue = $(value[6]).text().replace(/,/g, '');
            total += parseFloat(rawValue) || 0;
        });
        $('#overallPending').text(total.toLocaleString('en-IN', { minimumFractionDigits: 2 }));
    }

    table.on('draw', updatePendingTotal);
    updatePendingTotal();
});
</script>
@endsection