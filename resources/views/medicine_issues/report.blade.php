@extends('layout.admin')

@section('content')
<div class="main-wrapper">
    @include('include.header')
    @include('include.sidebar')

    <div class="page-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0 rounded-4 p-4 mt-3">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold text-primary mb-0"><i class="fas fa-file-medical me-2"></i> Patient Medicine Reports</h4>
                        <span class="badge bg-primary px-3 py-2">Total Patients: {{ count($groupedByPatient) }}</span>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" class="row g-3 mb-5 p-3 bg-light rounded shadow-sm border">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Select Patient</label>
                            <select name="patient_id" id="patient_id" class="form-select select2">
                                <option value="">All Patients</option>
                                @foreach($patients as $p)
                                    <option value="{{ $p->id }}" {{ request('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">From Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">To Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filter</button>
                            <a href="{{ url()->current() }}" class="btn btn-secondary"><i class="fas fa-undo"></i></a>
                        </div>
                    </form>

                    <!-- Separate Tables for Each Patient -->
                    @forelse($groupedByPatient as $patientName => $medicines)
                        <div class="patient-block mb-5 p-3 border rounded-3 shadow-sm bg-white">
                            @php $info = $medicines->first(); @endphp
                            
                            <!-- Patient Header Info -->
                            <div class="row align-items-center mb-3  
                            rounded-2 p-2 g-0">
                                <div class="col-md-4 ps-2">
                                    <h5 class="mb-0 fw-bold text-uppercase"><i class="fas fa-user-circle me-2"></i>{{ $patientName }}</h5>
                                </div>
                                <div class="col-md-8 text-end pe-2 small text-dark">
                                    <span class="me-3"><strong>REG:</strong> {{ $info->ip_number }}</span>
                                    <span class="me-3"><strong>AGE:</strong> {{ $info->age }}</span>
                                    <span><strong>DOA:</strong> {{ \Carbon\Carbon::parse($info->doa)->format('d-m-Y') }}</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle w-100 medicineTable">
                                    <thead class="table-primary text-center">
                                        <tr>
                                            <th width="5%">S.No</th>
                                            <th width="15%">Duration</th>
                                            <th width="30%">Medicine Name</th>
                                            <th>Complaints</th>
                                            <th width="7%">MOR</th>
                                            <th width="7%">AFT</th>
                                            <th width="7%">EVE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($medicines as $index => $row)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="small fw-bold text-muted">{{ $row->start }} <br>to<br> {{ $row->end }}</td>
                                            <td class="text-start">
                                                <div class="fw-bold text-primary">{{ $row->drug_name }}</div>
                                                <!-- Quantity total-a inge oru chinna badge-a kaatalam -->
                                                <small class="badge rounded-pill bg-secondary mt-1"> {{ $row->mor + $row->at + $row->eve > 0 ? $row->mor ?: ($row->at ?: $row->eve) : 0 }} Qty</small>
                                            </td>
                                            <td class="text-start small">{{ $row->complaints ?? '-' }}</td>
                                            
                                            <!-- Morning -->
                                            <td>
                                                @if($row->mor > 0)
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fas fa-sun text-warning mb-1"></i>
                                                        
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                    
                                            <!-- Afternoon -->
                                            <td>
                                                @if($row->at > 0)
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fas fa-cloud-sun text-info mb-1"></i>
                                                        
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                    
                                            <!-- Evening/Night -->
                                            <td>
                                                @if($row->eve > 0)
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fas fa-moon text-primary mb-1"></i>
                                                        
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                      
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles and Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2({ width: '100%' });

    // Initialize DataTable for each patient table
    $('.medicineTable').each(function() {
        var patientName = $(this).closest('.patient-block').find('h5').text().trim();
        
        $(this).DataTable({
            dom: '<"d-flex justify-content-end mb-2"B>rt',
            buttons: [
                { 
                    extend: 'excelHtml5', 
                    className: 'btn btn-sm btn-outline-success mx-1', 
                    title: 'Medicine Report - ' + patientName 
                },
                { 
                    extend: 'print', 
                    className: 'btn btn-sm btn-outline-dark mx-1',
                    title: 'Medicine Report: ' + patientName
                }
            ],
            paging: false,
            info: false,
            ordering: false
        });
    });
});
</script>

<style>
    .patient-block { border-left: 5px solid #0d6efd !important; }
    .table thead th { vertical-align: middle; }
    .badge { min-width: 30px; }
</style>
@endsection