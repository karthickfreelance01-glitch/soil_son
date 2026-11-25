@php
$role = Auth::user()->role ?? '';
@endphp
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo d-flex align-items-center justify-content-between">
        <a href="{{ url('dashboard') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('assets/uploads/sswf/favicon-256.png') }}" alt="Logo" height="55" class="me-2">
           <h6> SOIL SONS REHABILITATION CENTRE </h6>
        </a>
        <button class="sidenav-toggle-btn btn border-0 p-0" id="toggle_btn">
            <i class="fa-solid fa-bars"></i>
        </button>
        <button class="sidebar-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="sidebar-inner" data-simplebar>
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <!-- ================= MAIN ================= -->
                <li class="menu-title"><span>Main Menu</span></li>
                @if($role == 'admin')
                <li>
                    <a href="{{ url('dashboard') }}">
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- ================= MASTERS ================= -->
                <li class="menu-title"><span>Masters</span></li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-database"></i>
                        <span>Masters</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('expenses/view') }}"><i class="fa-solid fa-money-bill-wave"></i> Expense</a></li>
                        <li><a href="{{ url('staff/view') }}"><i class="fa-solid fa-users"></i> Staff</a></li>
                         <li><a href="{{ url('vendors') }}"><i class="fa-solid fa-users"></i> Vendors</a></li>
                        <li><a href="{{ url('medicine-categories') }}"><i class="fa-solid fa-capsules"></i> Medicine Categories</a></li>
                    </ul>
                </li>

                <!-- ================= PATIENT ================= -->
                <li class="menu-title"><span>Patient</span></li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-hospital-user"></i>
                        <span>Patient Registration</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('patients/create') }}"><i class="fa-solid fa-user-plus"></i> Create Patient</a></li>
                        <li><a href="{{ url('patients') }}"><i class="fa-solid fa-eye"></i> View Patients</a></li>
                        <li><a href="{{ url('patients/discharge/index') }}"><i class="fa-solid fa-bed-pulse"></i> Discharged Patients</a></li>
                        <li><a href="{{ url('followups') }}"><i class="fa-solid fa-bed-pulse"></i> Follow up Patients</a></li>
                    </ul>
                </li>

                <!-- ================= BILLING ================= -->
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>Patient Billing</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('patient/billing') }}"><i class="fa-solid fa-plus"></i> Create Bill</a></li>
                        <li><a href="{{ url('patient/billing/reports') }}"><i class="fa-solid fa-clipboard-list"></i> View Bills</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url('patient_bills_report') }}">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Monthly Patient Bill</span>
                    </a>
                </li>

                <!-- ================= DISCHARGE ================= -->
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-person-walking-arrow-right"></i>
                        <span>Discharge</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('discharge') }}"><i class="fa-solid fa-plus"></i> Create Discharge</a></li>
                        <li><a href="{{ url('patients/discharge/index') }}"><i class="fa-solid fa-clipboard-list"></i> View Discharge</a></li>
                    </ul>
                </li>

                <!-- ================= NOTES ================= -->
                <li class="menu-title"><span>Notes</span></li>
                <li>
                    <a href="{{ url('doctor_notes') }}">
                        <i class="fa-solid fa-notes-medical"></i>
                        <span>Doctor Notes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('counsellor-notes') }}">
                        <i class="fa-solid fa-notes-medical"></i>
                        <span>Counsellor Notes</span>
                    </a>
                </li>
  <li>
    <a href="{{ url('nurse_notes') }}">
        <i class="fa-solid fa-notes-medical"></i>
        <span>Nurse Notes</span>
    </a>
</li>

                <!-- ================= DOCUMENT REPORTS ================= -->
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-file-medical"></i>
                        <span>Patient Doc Reports</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('reports/create') }}"><i class="fa-solid fa-file-circle-plus"></i> Add Reports</a></li>
                        <li><a href="{{ url('reports') }}"><i class="fa-solid fa-eye"></i> View Reports</a></li>
                    </ul>
                </li>
                <li class="menu-title"><span>Medicine</span></li>
                <li><a href="{{ url('medicine/create') }}"><i class="fa-solid fa-pills"></i> Create Medicine </a></li>
                <li><a href="{{ url('medicine-issues/create') }}"><i class="fa-solid fa-pills"></i> Create Medicine Issue</a></li>
                <li><a href="{{ url('medicine-issues') }}"><i class="fa-solid fa-eye"></i> View Medicine Issue</a></li>
                <li><a href="{{ url('stock') }}"><i class="fa-solid fa-boxes-stacked"></i> Stock</a></li>
                <li><a href="{{ url('medicine-issues/reports') }}"><i class="fa-solid fa-file-lines"></i> Patients Medicine Reports</a></li>
                <!-- ================= EXPENSES ================= -->
                <li class="menu-title"><span>Expenses</span></li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-wallet"></i>
                        <span>Expenses</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('expenses/create') }}"><i class="fa-solid fa-plus"></i> Create Expense</a></li>
                        <li><a href="{{ url('expenses/index') }}"><i class="fa-solid fa-eye"></i> View Expenses</a></li>
                    </ul>
                </li>

                <!-- ================= REPORTS ================= -->
                <li class="menu-title"><span>Reports</span></li>
                <li><a href="{{ url('expenses/reports') }}"><i class="fa-solid fa-chart-line"></i> Expense Reports</a></li>
                <li><a href="{{ url('income/reports') }}"><i class="fa-solid fa-chart-line"></i> Income Reports</a></li>
                <li><a href="{{ url('doctor-notes-reports') }}"><i class="fa-solid fa-notes-medical"></i> Doctor Notes Reports</a></li>
                
                <!-- ================= REGISTERS ================= -->
                <li class="menu-title"><span>Registers</span></li>
                <li><a href="{{ url('escape_view') }}"><i class="fa-solid fa-person-running"></i> Escape</a></li>
                <li><a href="{{ url('death') }}"><i class="fa-solid fa-skull-crossbones"></i> Death</a></li>
                <li><a href="{{ url('injuries') }}"><i class="fa-solid fa-hand-holding-medical"></i> Injury</a></li>
                <li><a href="{{ url('hearings') }}"><i class="fa-solid fa-file-signature"></i> FIR / CSR</a></li>
                <li><a href="{{ url('equipments') }}"><i class="fa-solid fa-stethoscope"></i> Medical Equipment</a></li>
                <li><a href="{{ url('dangerously-ill') }}"><i class="fa-solid fa-triangle-exclamation"></i> Danger Illness</a></li>

                <!-- ================= ATTENDANCE ================= -->
                <li class="menu-title"><span>Attendance</span></li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-user-check"></i>
                        <span>Staff Attendance</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('attendance') }}"><i class="fa-solid fa-calendar-plus"></i> Mark Attendance</a></li>
                        <li><a href="{{ url('attendance/today') }}"><i class="fa-solid fa-eye"></i> Today Report</a></li>
                        <li><a href="{{ url('attendance/date-report') }}"><i class="fa-solid fa-calendar-day"></i> Attendance Report</a></li>
                        <li><a href="{{ url('attendance/mark-date') }}"><i class="fa-solid fa-calendar-plus"></i> Mark by Date</a></li>
                    </ul>
                </li>
                 <li>
                    <a href="{{ url('attendance_salary_report') }}">
                        <i class="fa-solid fa-wallet"></i>
                        <span>Salary</span>
                    </a>
                </li>
                 <li>
                    <a href="{{ url('internships') }}">
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Letter head</span>
                    </a>
                </li>
                @endif

<!-- ================= STAFF LIMITED ACCESS ================= -->

@if($role == 'staff')
  <li>
                    <a href="{{ url('dashboard') }}">
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- ================= MASTERS ================= -->
                <!--<li class="menu-title"><span>Masters</span></li>-->
                <!--<li class="submenu">-->
                <!--    <a href="javascript:void(0);">-->
                <!--        <i class="fa-solid fa-database"></i>-->
                <!--        <span>Masters</span>-->
                <!--        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>-->
                <!--    </a>-->
                <!--    <ul>-->
                <!--        <li><a href="{{ url('expenses/view') }}"><i class="fa-solid fa-money-bill-wave"></i> Expense</a></li>-->
                <!--        <li><a href="{{ url('staff/view') }}"><i class="fa-solid fa-users"></i> Staff</a></li>-->
                <!--         <li><a href="{{ url('vendors') }}"><i class="fa-solid fa-users"></i> Vendors</a></li>-->
                <!--        <li><a href="{{ url('medicine-categories') }}"><i class="fa-solid fa-capsules"></i> Medicine Categories</a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!-- ================= PATIENT ================= -->
                <li class="menu-title"><span>Patient</span></li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-hospital-user"></i>
                        <span>Patient Registration</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('patients/create') }}"><i class="fa-solid fa-user-plus"></i> Create Patient</a></li>
                        <li><a href="{{ url('patients') }}"><i class="fa-solid fa-eye"></i> View Patients</a></li>
                        <li><a href="{{ url('patients/discharge/index') }}"><i class="fa-solid fa-bed-pulse"></i> Discharged Patients</a></li>
                        <li><a href="{{ url('followups') }}"><i class="fa-solid fa-bed-pulse"></i> Follow up Patients</a></li>
                    </ul>
                </li>

                <!-- ================= BILLING ================= -->
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>Patient Billing</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('patient/billing') }}"><i class="fa-solid fa-plus"></i> Create Bill</a></li>
                        <!--<li><a href="{{ url('patient/billing/reports') }}"><i class="fa-solid fa-clipboard-list"></i> View Bills</a></li>-->
                    </ul>
                </li>

                <li>
                    <a href="{{ url('patient_bills_report') }}">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Monthly Patient Bill</span>
                    </a>
                </li>

                <!-- ================= DISCHARGE ================= -->
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-person-walking-arrow-right"></i>
                        <span>Discharge</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('discharge') }}"><i class="fa-solid fa-plus"></i> Create Discharge</a></li>
                        <li><a href="{{ url('patients/discharge/index') }}"><i class="fa-solid fa-clipboard-list"></i> View Discharge</a></li>
                    </ul>
                </li>

                <!-- ================= NOTES ================= -->
                <li class="menu-title"><span>Notes</span></li>
                <li>
                    <a href="{{ url('doctor_notes') }}">
                        <i class="fa-solid fa-notes-medical"></i>
                        <span>Doctor Notes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('counsellor-notes') }}">
                        <i class="fa-solid fa-notes-medical"></i>
                        <span>Counsellor Notes</span>
                    </a>
                </li>
                <li>
    <a href="{{ url('nurse_notes') }}">
        <i class="fa-solid fa-notes-medical"></i>
        <span>Nurse Notes</span>
    </a>
</li>

                <!-- ================= DOCUMENT REPORTS ================= -->
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-file-medical"></i>
                        <span>Patient Doc Reports</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('reports/create') }}"><i class="fa-solid fa-file-circle-plus"></i> Add Reports</a></li>
                        <li><a href="{{ url('reports') }}"><i class="fa-solid fa-eye"></i> View Reports</a></li>
                    </ul>
                </li>
                <li class="menu-title"><span>Medicine</span></li>
                <li><a href="{{ url('medicine/create') }}"><i class="fa-solid fa-pills"></i> Create Medicine </a></li>
                <li><a href="{{ url('medicine-issues/create') }}"><i class="fa-solid fa-pills"></i> Create Medicine Issue</a></li>
                <li><a href="{{ url('medicine-issues') }}"><i class="fa-solid fa-eye"></i> View Medicine Issue</a></li>
                <li><a href="{{ url('stock') }}"><i class="fa-solid fa-boxes-stacked"></i> Stock</a></li>
                <li><a href="{{ url('medicine-issues/reports') }}"><i class="fa-solid fa-file-lines"></i> Patients Medicine Reports</a></li>
                <!-- ================= EXPENSES ================= -->
                <li class="menu-title"><span>Expenses</span></li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-wallet"></i>
                        <span>Expenses</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('expenses/create') }}"><i class="fa-solid fa-plus"></i> Create Expense</a></li>
                        <li><a href="{{ url('expenses/index') }}"><i class="fa-solid fa-eye"></i> View Expenses</a></li>
                    </ul>
                </li>

                <!-- ================= REPORTS ================= -->
                <li class="menu-title"><span>Reports</span></li>
                <!--<li><a href="{{ url('expenses/reports') }}"><i class="fa-solid fa-chart-line"></i> Expense Reports</a></li>-->
                <!--<li><a href="{{ url('income/reports') }}"><i class="fa-solid fa-chart-line"></i> Income Reports</a></li>-->
                <li><a href="{{ url('doctor-notes-reports') }}"><i class="fa-solid fa-notes-medical"></i> Doctor Notes Reports</a></li>
                
                <!-- ================= REGISTERS ================= -->
                <li class="menu-title"><span>Registers</span></li>
                <li><a href="{{ url('escape_view') }}"><i class="fa-solid fa-person-running"></i> Escape</a></li>
                <li><a href="{{ url('death') }}"><i class="fa-solid fa-skull-crossbones"></i> Death</a></li>
                <li><a href="{{ url('injuries') }}"><i class="fa-solid fa-hand-holding-medical"></i> Injury</a></li>
                <li><a href="{{ url('hearings') }}"><i class="fa-solid fa-file-signature"></i> FIR / CSR</a></li>
                <li><a href="{{ url('equipments') }}"><i class="fa-solid fa-stethoscope"></i> Medical Equipment</a></li>
                <li><a href="{{ url('dangerously-ill') }}"><i class="fa-solid fa-triangle-exclamation"></i> Danger Illness</a></li>

                <!-- ================= ATTENDANCE ================= -->
                <li class="menu-title"><span>Attendance</span></li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-user-check"></i>
                        <span>Staff Attendance</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ url('attendance') }}"><i class="fa-solid fa-calendar-plus"></i> Mark Attendance</a></li>
                        <li><a href="{{ url('attendance/today') }}"><i class="fa-solid fa-eye"></i> Today Report</a></li>
                        <li><a href="{{ url('attendance/date-report') }}"><i class="fa-solid fa-calendar-day"></i> Attendance Report</a></li>
                        <li><a href="{{ url('attendance/mark-date') }}"><i class="fa-solid fa-calendar-plus"></i> Mark by Date</a></li>
                    </ul>
                </li>
                 <li>
                    <a href="{{ url('attendance_salary_report') }}">
                        <i class="fa-solid fa-wallet"></i>
                        <span>Salary</span>
                    </a>
                </li>
                 <li>
                    <a href="{{ url('internships') }}">
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Letter head </span>
                    </a>
                </li>
                @endif
                


                <!-- ================= WEBSITE (soil sons website) ================= -->
                @if(in_array($role, ['admin', 'staff']))
                <li class="menu-title"><span>Website</span></li>
                <li>
                    <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-globe"></i><span>Website Dashboard</span></a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        <span>Website Enquiries</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin.enquiries.index') }}"><i class="fa-solid fa-list"></i> All Enquiries</a></li>
                        <li><a href="{{ route('admin.enquiries.index', ['status' => 'new']) }}"><i class="fa-solid fa-bell"></i> New</a></li>
                        <li><a href="{{ route('admin.enquiries.index', ['source' => 'sidebar']) }}"><i class="fa-solid fa-table-columns"></i> Side Enquiries</a></li>
                        <li><a href="{{ route('admin.enquiries.index', ['source' => 'contact']) }}"><i class="fa-solid fa-address-card"></i> Contact Page</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="fa-solid fa-display"></i>
                        <span>Website Content</span>
                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                    </a>
                    <ul>
                        @if($role == 'admin')<li><a href="{{ route('admin.services.index') }}"><i class="fa-solid fa-hand-holding-heart"></i> Services</a></li>@endif
                        <li><a href="{{ route('admin.gallery.index') }}"><i class="fa-solid fa-images"></i> Gallery</a></li>
                        @if($role == 'admin')<li><a href="{{ route('admin.seo.index') }}"><i class="fa-solid fa-magnifying-glass-chart"></i> SEO</a></li>@endif
                    </ul>
                </li>
                @if($role == 'admin')
                <li>
                    <a href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users-gear"></i><span>Login Users</span></a>
                </li>
                @endif
                <li>
                    <a href="{{ url('/') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i><span>View Website</span></a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
