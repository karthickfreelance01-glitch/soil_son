<header class="navbar-header">
    <div class="page-container topbar-menu d-flex justify-content-between align-items-center">

        <!-- LEFT -->
        <div class="d-flex align-items-center gap-2">
            <button type="button"
                    class="btn btn-outline-secondary btn-sm"
                    onclick="window.history.back();">
                <i class="fa fa-arrow-left"></i>
            </button>

            <a href="{{ url('dashboard') }}" class="logo">
                <span class="logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/uploads/sswf/favicon-256.png') }}" alt="logo">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/uploads/sswf/favicon-256.png') }}" alt="logo">
                    </span>
                </span>
                <span class="logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/uploads/sswf/favicon-256.png') }}" alt="logo">
                    </span>
                </span>
            </a>

            <a id="mobile_btn" class="mobile-btn" href="#sidebar">
                <i class="fa-solid fa-bars fs-24"></i>
            </a>

            <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn2">
                <i class="ti ti-arrow-right"></i>
            </button>
        </div>

        <!-- RIGHT -->
        <div class="d-flex align-items-center gap-3">

          
            <!-- USER DROPDOWN -->
            <div class="dropdown profile-dropdown">

                <a href="javascript:void(0);"
                   class="profile-trigger"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">

                   <img src="{{ asset('assets/uploads/sswf/favicon-256.png') }}"
                         class="rounded-circle border"
                         width="55"
                         height="55"
                         alt="user">

                    <!-- SMALL SETTINGS ICON -->
                    <span class="settings-icon">
                        <i class="fa-solid fa-gear"></i>
                    </span>
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2"
                     style="min-width:230px">

                    <div class="px-3 py-2 border-bottom">
                        <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">
                            Role: {{ auth()->user()->role ?? 'User' }}
                        </small>
                    </div>

                    <a href="javascript:void(0);"
                       class="dropdown-item py-2"
                       data-bs-toggle="modal"
                       data-bs-target="#changePasswordModal">
                        <i class="fa-solid fa-key me-2 text-primary"></i>
                        Change Password
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="javascript:void(0);"
                       class="dropdown-item text-danger fw-semibold"
                       id="logoutBtn">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                        Logout
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- LOGOUT FORM -->
    <form id="logoutForm" action="{{ url('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
</header>
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header">
                <h5 class="fw-bold text-primary">
                    <i class="fa-solid fa-key me-2"></i> Change Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="changePasswordForm">
                @csrf
                <div class="modal-body">

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Password</label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="form-control password-field" required>
                            <span class="input-group-text toggle-password">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">New Password</label>
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control password-field" required>
                            <span class="input-group-text toggle-password">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="new_password_confirmation" class="form-control password-field" required>
                            <span class="input-group-text toggle-password">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary"
                            id="changePasswordBtn">
                        <span class="btn-text">Update Password</span>
                        <span class="spinner-border spinner-border-sm d-none"
                              role="status"
                              aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutForm = document.getElementById('logoutForm');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure you want to log out?',
                text: 'You will need to log in again to continue.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log out',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    logoutForm.submit();
                }
            });
        });
    }
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {

    /* ------------------ SHOW / HIDE PASSWORD ------------------ */
    document.querySelectorAll(".toggle-password").forEach(toggle => {
        toggle.addEventListener("click", function () {
            const input = this.previousElementSibling;
            const icon = this.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        });
    });

    /* ------------------ CHANGE PASSWORD ------------------ */
    const form = document.getElementById("changePasswordForm");
    const submitBtn = document.getElementById("changePasswordBtn");
    const spinner = submitBtn.querySelector(".spinner-border");
    const btnText = submitBtn.querySelector(".btn-text");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        // Disable button + show loading
        submitBtn.disabled = true;
        spinner.classList.remove("d-none");
        btnText.textContent = "Updating...";

        fetch("{{ url('change-password') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: new FormData(form)
        })
        .then(res => res.json())
        .then(data => {

            if (data.status) {
                Swal.fire("Success", data.message, "success");

                form.reset();
                document.querySelectorAll(".password-field").forEach(i => i.type = "password");
                document.querySelectorAll(".toggle-password i")
                    .forEach(i => i.className = "fa-solid fa-eye");

                bootstrap.Modal.getInstance(
                    document.getElementById("changePasswordModal")
                ).hide();
            } else {
                Swal.fire("Error", data.message, "error");
            }

        })
        .catch(() => {
            Swal.fire("Error", "Something went wrong", "error");
        })
        .finally(() => {
            // Re-enable button
            submitBtn.disabled = false;
            spinner.classList.add("d-none");
            btnText.textContent = "Update Password";
        });
    });

});
</script>

<style>
    .profile-trigger {
    position: relative;
    display: inline-block;
}

.settings-icon {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 18px;
    height: 18px;
    background: #ffffff;
    border-radius: 50%;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    color: #0d6efd;
    cursor: pointer;
}

</style>
