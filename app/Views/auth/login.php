<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - e-JobFair Portal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
            
            <div class="card login-card p-2 p-sm-3">
                
                <!-- Logo & Brand Header -->
                <div class="brand-header">
                    <img src="<?= base_url('logo/jobfairsystem_logo.png') ?>" alt="e-JobFair Portal Logo" class="brand-logo img-fluid">
                    <h5 class="fw-bold text-dark mb-1">Welcome Back</h5>
                    <p class="text-muted small mb-0">Sign in to your e-JobFair account</p>
                </div>

                <div class="card-body pt-2 px-4 pb-4">

                    <!-- Flash Message Notifications -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show small rounded-3 py-2 px-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close small p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show small rounded-3 py-2 px-3" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i><?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close small p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('login') ?>" method="POST" autocomplete="off">
                        <?= csrf_field() ?>

                        <!-- Username Field -->
                        <div class="form-floating mb-3">
                            <input type="text" 
                                   name="username" 
                                   id="username" 
                                   class="form-control" 
                                   placeholder="Username" 
                                   value="<?= old('username') ?>" 
                                   required 
                                   autofocus>
                            <label for="username"><i class="bi bi-person me-1"></i> Username</label>
                        </div>

                        <!-- Password Field with Toggle -->
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control" 
                                   placeholder="Password" 
                                   required>
                            <label for="password"><i class="bi bi-lock me-1"></i> Password</label>
                            
                            <button type="button" class="password-toggle-btn" id="togglePasswordBtn" title="Toggle password visibility">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>

                        <!-- Remember Me / Extra links (Optional) -->
                        <div class="d-flex justify-content-between align-items-center mb-4 small">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                <label class="form-check-label text-muted" for="rememberMe">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-submit w-100 shadow-sm mb-3">
                            Sign In <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </form>

                </div>

                <!-- Footer info -->
                <div class="card-footer bg-white border-0 text-center py-3">
                    <small class="text-muted" style="font-size: 0.75rem;">
                        &copy; <?= date('Y') ?> e-JobFair Portal. All rights reserved.
                    </small>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Password Visibility Toggle Script
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                toggleIcon.classList.toggle('bi-eye', !isPassword);
                toggleIcon.classList.toggle('bi-eye-slash', isPassword);
            });
        }
    });
</script>

</body>
</html>