<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Job Fair System</title>
    <link rel="icon" href="<?= base_url('logo/jobfairsystem_icon.ico') ?>">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }
        .login-header {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: #fff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 2rem 1.5rem;
            text-align: center;
        }
        .btn-primary {
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card login-card shadow-sm">
                <!-- Card Header -->
                <div class="login-header">
                    <img src="<?= base_url('logo/jobfairsystem_logo.png') ?>" 
                        alt="e-JobFair Portal Logo" 
                        class="img-fluid" 
                        style="max-height: 80px; width: auto;filter: drop-shadow(-1px 2px 1px rgba(255, 255, 255, 1));"><br>
                    <p class="mb-0 text-white md">Sign in to manage your account</p>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4 p-md-5">

                    <!-- Flash Messages (CodeIgniter 4 Session Alerts) -->
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form action="<?= base_url('login') ?>" method="post">
                        <?= csrf_field() ?>

                        <!-- Email / Username Input -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="email" name="username" placeholder="name@example.com" required autofocus>
                            <label for="email"><i class="bi bi-person me-1"></i> Username</label>
                        </div>

                        <!-- Password Input -->
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password"><i class="bi bi-lock me-1"></i> Password</label>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4 small">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label text-secondary" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <a href="<?= base_url('forgot-password') ?>" class="text-decoration-none">Forgot password?</a>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fs-6">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Card Footer -->
                <div class="card-footer bg-light text-center py-3 border-0 rounded-bottom">
                    <p class="small text-muted mb-0">Don't have an account? <a href="<?= base_url('register') ?>" class="fw-semibold text-decoration-none">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>