<header class="navbar-header">
    <div class="page-container topbar-menu d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.history.back();" title="Back">
                <i class="fa fa-arrow-left"></i>
            </button>
            <a id="mobile_btn" class="mobile-btn" href="#sidebar"><i class="fa-solid fa-bars fs-24"></i></a>
            <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn2"><i class="ti ti-arrow-right"></i></button>
            <span class="d-none d-md-inline text-muted ms-2" id="currentDateTime"></span>
        </div>

        <div class="d-flex align-items-center gap-3">
            @php $newCount = \App\Models\Enquiry::where('status', 'new')->count(); @endphp
            <a href="{{ route('admin.enquiries.index', ['status' => 'new']) }}" class="btn btn-light position-relative rounded-circle vv-bell" title="New enquiries">
                <i class="fa-regular fa-bell"></i>
                @if($newCount)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $newCount > 99 ? '99+' : $newCount }}</span>@endif
            </a>
            <a href="{{ url('/') }}" target="_blank" class="btn btn-light rounded-circle" title="View website"><i class="fa-solid fa-globe"></i></a>

            <div class="dropdown profile-dropdown">
                <a href="javascript:void(0);" class="profile-trigger d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="vv-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="d-none d-md-block text-start lh-sm">
                        <span class="fw-semibold d-block text-dark">{{ auth()->user()->name }}</span>
                        <small class="text-muted text-capitalize">{{ auth()->user()->role }}</small>
                    </span>
                    <span class="settings-icon"><i class="fa-solid fa-gear"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2" style="min-width:230px">
                    <div class="px-3 py-2 border-bottom">
                        <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">Role: {{ ucfirst(auth()->user()->role ?? 'User') }}</small>
                    </div>
                    <a href="javascript:void(0);" class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fa-solid fa-key me-2 text-primary"></i> Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void(0);" class="dropdown-item text-danger fw-semibold" id="logoutBtn">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf</form>
</header>

<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header">
                <h5 class="fw-bold text-primary mb-0"><i class="fa-solid fa-key me-2"></i> Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="changePasswordForm">
                <div class="modal-body">
                    @foreach (['current_password' => 'Current Password', 'new_password' => 'New Password', 'new_password_confirmation' => 'Confirm Password'] as $field => $label)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ $label }}</label>
                            <div class="input-group">
                                <input type="password" name="{{ $field }}" class="form-control password-field" required minlength="{{ $field === 'current_password' ? 1 : 6 }}">
                                <span class="input-group-text toggle-password" role="button"><i class="fa-solid fa-eye"></i></span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                        <span class="btn-text">Update Password</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function tick() {
        const el = document.getElementById('currentDateTime');
        if (el) el.innerText = new Date().toLocaleString('en-IN', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    }
    tick(); setInterval(tick, 30000);

    document.getElementById('logoutBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure you want to log out?', text: 'You will need to log in again to continue.',
            icon: 'warning', showCancelButton: true, confirmButtonColor: '#1a28aa', cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log out'
        }).then(r => { if (r.isConfirmed) document.getElementById('logoutForm').submit(); });
    });

    document.querySelectorAll('.toggle-password').forEach(t => t.addEventListener('click', function () {
        const input = this.previousElementSibling, icon = this.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye'); icon.classList.toggle('fa-eye-slash');
    }));

    const form = document.getElementById('changePasswordForm');
    const btn = document.getElementById('changePasswordBtn');
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        btn.disabled = true; btn.querySelector('.spinner-border').classList.remove('d-none');
        fetch(@json(route('admin.change-password')), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
            body: new FormData(form)
        }).then(r => r.json()).then(d => {
            if (d.status) {
                Swal.fire('Success', d.message, 'success'); form.reset();
                bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
            } else {
                Swal.fire('Error', d.message || Object.values(d.errors || {}).flat().join('\n'), 'error');
            }
        }).catch(() => Swal.fire('Error', 'Something went wrong', 'error'))
          .finally(() => { btn.disabled = false; btn.querySelector('.spinner-border').classList.add('d-none'); });
    });
});
</script>
@endpush
