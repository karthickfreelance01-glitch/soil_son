@extends('layout.admin')

@section('content')
<div class="main-wrapper">
    @include('include.header')
    @include('include.sidebar')

    <div class="page-wrapper">
        <div class="content pb-0">
            <div class="container-fluid">

                <!-- Header -->
                <div class="d-flex justify-content-between mb-3">
                    <h4>Counsellor Notes Reports</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Counsellor Notes</li>
                    </ol>
                </div>

                <!-- ================= FILTER SECTION ================= -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('counsellornotes.index') }}">
                            <div class="row g-3 align-items-end">

                                <!-- Patient -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Patient</label>
                                    <select name="patient_id" class="form-select select-search">
                                        <option value="">All Patients</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Counsellor -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Counsellor</label>
                                    <select name="staff_id" class="form-select select-search">
                                        <option value="">All Counsellors</option>
                                        @foreach($staffs as $staff)
                                            <option value="{{ $staff->id }}"
                                                {{ request('staff_id') == $staff->id ? 'selected' : '' }}>
                                                {{ $staff->staff_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Buttons -->
                                <div class="col-md-4 d-flex gap-2">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('counsellornotes.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-rotate-left"></i> Reset
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- ================= FILTER SECTION END ================= -->

                <!-- ================= TABLE ================= -->
                <div class="card shadow-lg">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Counsellor Notes List</h4>
                        <a href="{{ route('counsellornotes.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus-circle"></i> Add New
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="counsellorNotesTable" class="table table-bordered table-striped text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.no</th>
                                        <th>Patient</th>
                                        <th>Date</th>
                                        <th>Counsellor</th>
                                        <th>Problem</th>
                                        <th>Counselling</th>
                                        <th>Remarks</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctorNotes as $index => $note)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $note->patient_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($note->note_date)->format('d-m-Y') }}</td>
                                        <td>{{ $note->staff_name }}</td>
                                        <td>{{ Str::limit($note->assess_problem, 30) }}</td>
                                        <td>{{ Str::limit($note->counselling_given, 30) }}</td>
                                        <td>{{ Str::limit($note->remarks, 30) }}</td>
                                        <td class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-info btn-sm view-note-btn" data-note='@json($note)'>
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <a href="{{ route('counsellornotes.edit', $note->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('counsellornotes.destroy', $note->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Delete this note?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ================= TABLE END ================= -->

            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="viewNoteModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-gradient text-white">
                <h5 class="modal-title">Counsellor Note Details</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent"></div>
        </div>
    </div>
</div>

<!-- ================= SCRIPTS ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    // DataTable
    $('#counsellorNotesTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 20, 50],
        columnDefs: [{ orderable: false, targets: 7 }]
    });

    // ✅ Select2 Searchable Dropdown
    $('.select-search').select2({
        placeholder: "Select option",
        allowClear: true,
        width: '100%'
    });

    // View Modal
    $('.view-note-btn').click(function () {
        let note = $(this).data('note');
        $('#modalContent').html(`
            <p><strong>Patient:</strong> ${note.patient_name}</p>
            <p><strong>Date:</strong> ${note.note_date}</p>
            <p><strong>Problem:</strong> ${note.assess_problem}</p>
            <p><strong>Counselling:</strong> ${note.counselling_given}</p>
            <p><strong>Remarks:</strong> ${note.remarks}</p>
        `);
        $('#viewNoteModal').modal('show');
    });
});
</script>

<style>
.bg-gradient {
    background: linear-gradient(90deg,#4e73df,#1cc88a);
}
.select2-container .select2-selection--single {
    height: 38px;
}
.select2-selection__rendered {
    line-height: 36px !important;
}
.select2-selection__arrow {
    height: 36px !important;
}
</style>
@endsection
