@php use Carbon\Carbon; @endphp
@extends('layout.admin')
@section('content')

<div class="main-wrapper">
    @include('include.header')
    @include('include.sidebar')

    <div class="page-wrapper">
        <div class="content">
            <div class="container-fluid">

                <div class="card shadow-sm border-0 rounded-4 p-3">
                    
                    <!-- Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary fw-bold">Patient Income Reports</h4>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" id="filterForm" class="row g-3 mt-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">From Date</label>
                            <input type="date" name="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">To Date</label>
                            <input type="date" name="to_date" class="form-control"
                                value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <a href="{{ url('income/reports') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </form>

                    <!-- Summary (Removed Pending) -->
                    <div id="printArea">
                    <div class="mt-4 mb-3 p-3 bg-light rounded-3 border">
                        <h5 class="fw-bold mb-2">Overall Summary</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Total Billed:</strong>
                                <span class="text-primary">₹{{ number_format($totalMonthly, 2) }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Total Received:</strong>
                                <span class="text-success">₹{{ number_format($totalReceived, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="billingTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>IP No</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Admission Date</th>
                                        <th>Total Billed</th>
                                        <th>Total Received</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($reports as $r)
                                    <tr>
                                        <td>{{ $r->ip_number }}</td>
                                        <td>{{ $r->name }}</td>
                                        <td>{{ $r->contact_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($r->date_of_admission)->format('d-m-Y') }}</td>
                                        <td>₹{{ number_format($r->total_billed, 2) }}</td>
                                        <td class="text-success">₹{{ number_format($r->total_paid, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="text-center mt-4">
    <button type="button" class="btn btn-success" onclick="printIncomeReport()">
        <i class="fa fa-print"></i> Print Report
    </button>
</div>
</div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>


<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
function printIncomeReport() {

    let fromDate = document.querySelector('[name="from_date"]').value || "All";
    let toDate = document.querySelector('[name="to_date"]').value || "All";

    let content = document.getElementById("printArea").innerHTML;

    let win = window.open("", "", "width=1000,height=700");

    win.document.write(`
    <html>
    <head>
        <title>Patient Income Report</title>

        <style>

            body{
                font-family:Arial,sans-serif;
                padding:20px;
            }

            h2{
                text-align:center;
                margin-bottom:20px;
            }

            table{
                width:100%;
                border-collapse:collapse;
                margin-top:20px;
            }

            table,th,td{
                border:1px solid #000;
            }

            th,td{
                padding:8px;
                text-align:left;
            }

            .header{
                margin-bottom:20px;
            }

            .header p{
                margin:5px 0;
            }

        </style>

    </head>

    <body>

        <h2>Patient Income Report</h2>

        <div class="header">
            <p><strong>From Date :</strong> ${fromDate}</p>
            <p><strong>To Date :</strong> ${toDate}</p>
        </div>

        ${content}

    </body>
    </html>
    `);

    win.document.close();
    win.focus();
    win.print();
    win.close();
}
$(document).ready(function(){
    $('#billingTable').DataTable({
        dom: "<'row mb-3'<'col-sm-6'f><'col-sm-6 text-end'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
             buttons: ['copy', 'csv', 'excel', 'pdf'],
        // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        order: [[3, 'desc']],
        pageLength: 10
    });
});
</script>

@endsection
