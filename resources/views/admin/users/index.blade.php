@extends('admin.layout')
@section('title', 'Admin & Staff')
@section('subtitle', 'Who can log in to this panel')
@section('breadcrumb', 'Admin & Staff')
@section('actions')
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" id="addUserBtn"><i class="fa-solid fa-plus me-1"></i> Add User</button>
@endsection

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-6"><div class="card h-100"><div class="card-body small">
        <h6 class="fw-bold"><span class="badge bg-primary me-1">Admin</span> full access</h6>
        Dashboard, enquiries (including delete &amp; export), services, gallery, SEO and user accounts.
    </div></div></div>
    <div class="col-md-6"><div class="card h-100"><div class="card-body small">
        <h6 class="fw-bold"><span class="badge bg-info me-1">Staff</span> day-to-day work</h6>
        Dashboard, view and follow up enquiries (status &amp; notes), export, and manage the gallery.
    </div></div></div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table align-middle js-datatable">
            <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Created</th><th class="text-end">Action</th></tr></thead>
            <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold"><span class="vv-avatar me-2" style="width:32px;height:32px;font-size:14px">{{ strtoupper(substr($u->name, 0, 1)) }}</span>{{ $u->name }} @if($u->id === auth()->id())<small class="text-muted">(you)</small>@endif</td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge bg-{{ $u->isAdmin() ? 'primary' : 'info' }}">{{ ucfirst($u->role) }}</span></td>
                    <td><span class="badge bg-{{ $u->isActive() ? 'success' : 'secondary' }}">{{ $u->isActive() ? 'Active' : 'Inactive' }}</span></td>
                    <td class="small">{{ $u->created_at ? \Illuminate\Support\Carbon::parse($u->created_at)->format('d M Y') : '—' }}</td>
                    <td class="text-end text-nowrap">
                        <button class="btn btn-sm btn-light js-edit-user" data-bs-toggle="modal" data-bs-target="#userModal"
                            data-url="{{ route('admin.users.update', $u) }}" data-name="{{ $u->name }}" data-email="{{ $u->email }}"
                            data-role="{{ $u->role }}" data-active="{{ $u->isActive() ? 1 : 0 }}"><i class="fa-solid fa-pen"></i></button>
                        @if($u->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline js-confirm-delete" data-title="Delete {{ $u->name }}?">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 rounded-4" method="POST" id="userForm" action="{{ route('admin.users.store') }}">
            @csrf
            <input type="hidden" name="_method" id="uMethod" value="POST">
            <div class="modal-header"><h5 class="fw-bold mb-0" id="uTitle">Add User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-2"><label class="form-label fw-semibold">Name *</label><input type="text" name="name" id="uName" class="form-control" required></div>
                <div class="mb-2"><label class="form-label fw-semibold">Email (login) *</label><input type="email" name="email" id="uEmail" class="form-control" required></div>
                <div class="row g-2 mb-2">
                    <div class="col-12"><label class="form-label fw-semibold">Role *</label>
                        <select name="role" id="uRole" class="form-select">@foreach(\App\Models\User::ROLES as $k => $v)<option value="{{ $k }}" @selected($k === 'staff')>{{ $v }}</option>@endforeach</select></div>
                </div>
                <div class="mb-2"><label class="form-label fw-semibold">Password <span id="uPwHint" class="text-muted fw-normal">*</span></label><input type="password" name="password" id="uPw" class="form-control" minlength="6" required></div>
                <div class="form-check form-switch d-none" id="uActiveWrap"><input class="form-check-input" type="checkbox" name="status" value="1" id="uActive"><label class="form-check-label" for="uActive">Active (can log in)</label></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary">Save</button></div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#addUserBtn').on('click', function () {
    $('#userForm').attr('action', @json(route('admin.users.store')))[0].reset();
    $('#uMethod').val('POST'); $('#uTitle').text('Add User'); $('#uPw').prop('required', true); $('#uPwHint').text('*');
    $('#uActiveWrap').addClass('d-none');
});
$(document).on('click', '.js-edit-user', function () {
    const d = $(this).data();
    $('#userForm').attr('action', d.url); $('#uMethod').val('PUT'); $('#uTitle').text('Edit ' + d.name);
    $('#uName').val(d.name); $('#uEmail').val(d.email); $('#uRole').val(d.role);
    $('#uPw').val('').prop('required', false); $('#uPwHint').text('(leave empty to keep current)');
    $('#uActive').prop('checked', d.active == 1); $('#uActiveWrap').removeClass('d-none');
});
</script>
@endpush
