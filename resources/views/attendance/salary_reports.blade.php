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
    <h4>Staff Attendance Salary Report</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Salary Report</li>
    </ol>
</div>

<!-- Filters -->
<form method="GET" class="g-3 mb-3">
<div class="card">
<div class="card-body row">

    <div class="col-md-2">
        <input type="date" name="from_date" class="form-control" value="{{ $from ?? '' }}">
    </div>

    <div class="col-md-2">
        <input type="date" name="to_date" class="form-control" value="{{ $to ?? '' }}">
    </div>

   

    <div class="col-md-2 d-flex gap-2">
        <button class="btn btn-primary flex-grow-1">Filter</button>
        <a href="{{ url('attendance_salary_report') }}" class="btn btn-secondary flex-grow-1">Reset</a>
    </div>

</div>
</div>
</form>

@if($staff->isEmpty())
<div class="alert alert-info">
    Please select a staff or date range to view salary report.
</div>
@else

<!-- Report Table -->
<div class="card shadow-lg">
<div class="card-body table-responsive">

<table id="salaryTable" class="table table-bordered table-striped text-center">

<thead class="table-light">
<tr>
    <th>Staff Name</th>
    <th>Present</th>
    <th>Half Day</th>
    <th>Leave</th>
    <th>Worked Days</th>
    <th>Salary</th>
</tr>
</thead>

<tbody>

@foreach($staff as $st)

@php
$present = 0;
$halfday = 0;
$leave = 0;

foreach($dates as $date){
    $status = $attendanceRecords[$st->id][$date]->status ?? '';

    if($status == 'Present') $present++;
    elseif($status == 'Half Day') $halfday++;
    elseif($status == 'Absent' || $status == 'Leave') $leave++;
}

$workedDays = $present + ($halfday * 0.5);
$perDaySalary = $st->salary / 30;
$salary = $workedDays * $perDaySalary;
@endphp

<tr>
    <td class="fw-bold">{{ $st->staff_name }}</td>

    <td class="text-success fw-bold">{{ $present }}</td>

    <td class="text-primary fw-bold">{{ $halfday }}</td>

    <td class="text-danger fw-bold">{{ $leave }}</td>

    <td class="fw-bold">{{ $workedDays }}</td>

    <td class="fw-bold text-success">
        ₹ {{ number_format($salary,2) }}
    </td>
</tr>

@endforeach

</tbody>
</table>

</div>
</div>

@endif

</div>
</div>
</div>
</div>

<!-- DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#salaryTable').DataTable({
        pageLength: 10,
        lengthMenu: [5,10,25,50,100],
        order: []
    });
});
</script>

@endsection
