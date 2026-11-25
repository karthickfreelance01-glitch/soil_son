<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') | {{ config('site.name') }} Admin</title>

    <link rel="shortcut icon" href="{{ asset('assets/uploads/sswf/favicon-256.png') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/simplebar/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/sswf-admin.css') }}?v=1">
    @stack('styles')
</head>
<body>
<div id="pageLoader"></div>

<div class="main-wrapper">
    @include('admin.partials.header')
    @include('admin.partials.sidebar')

    <div class="page-wrapper">
        <div class="content pb-4 container-fluid">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 vv-page-head">
                <div>
                    <h3 class="fw-bold mb-1">@yield('title', 'Dashboard')</h3>
                    @hasSection('subtitle')<small class="text-muted">@yield('subtitle')</small>@endif
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @yield('actions')
                    <ol class="breadcrumb m-0 bg-transparent p-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        @hasSection('breadcrumb')<li class="breadcrumb-item active">@yield('breadcrumb')</li>@endif
                    </ol>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>
                    @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
        <div class="vv-admin-footer text-center text-muted small py-3">
            &copy; {{ date('Y') }} {{ config('site.name') }} &middot;
            <a href="{{ url('/') }}" target="_blank">View website <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i></a>
        </div>
    </div>
</div>

<script src="{{ asset('admin-assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin-assets/js/script.js') }}"></script>
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json' } });

    const vvToast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
    @if (session('success')) vvToast.fire({ icon: 'success', title: @json(session('success')) }); @endif
    @if (session('error'))   vvToast.fire({ icon: 'error',   title: @json(session('error')) }); @endif

    // Confirm before any delete form is submitted
    $(document).on('submit', 'form.js-confirm-delete', function (e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: $(form).data('title') || 'Delete this item?',
            text: 'This cannot be undone.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#2f47e0', cancelButtonColor: '#6c757d', confirmButtonText: 'Yes, delete'
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });

    // Default DataTable setup
    $('.js-datatable').each(function () {
        $(this).DataTable({ pageLength: 25, order: [], language: { search: '', searchPlaceholder: 'Search...' } });
    });

    // Highlight the current menu item and open its submenu
    (function () {
        const here = window.location.href.split(/[?#]/)[0].replace(/\/$/, '');
        $('#sidebar-menu a[href]').each(function () {
            const href = this.href.replace(/\/$/, '');
            if (href && (here === href || (href.length > 30 && here.indexOf(href + '/') === 0))) {
                $(this).addClass('active');
                $(this).closest('li.submenu').addClass('vv-open').children('a').addClass('subdrop');
                $(this).closest('ul').show();
            }
        });
    })();
</script>
@stack('scripts')
</body>
</html>
