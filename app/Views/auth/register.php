<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - e-JobFair Portal</title>
    <link rel="icon" href="<?= base_url('logo/jobfairsystem_icon.ico') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">

</head>
<body class="bg-light py-4">

<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">
            
            <div class="card shadow-sm border-0 rounded-4 p-2 p-sm-3">
                <div class="text-center pt-3 pb-2">
                    <a href="<?= base_url('/') ?>">
                        <img src="<?= base_url('logo/jobfairsystem_logo.png') ?>" alt="e-JobFair Portal Logo" class="brand-logo img-fluid mb-2" style="max-height: 60px;">
                    </a>
                    <h4 class="fw-bold text-dark mb-1">Create an Account</h4>
                    <p class="text-muted small mb-0">Fill in your details to register for the e-JobFair Portal</p>
                </div>

                <div class="card-body px-4">

                    <!-- Flash Message Errors -->
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show small rounded-3 py-2 px-3 mb-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Please fix the following issues:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                            <button type="button" class="btn-close small p-2" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show small rounded-3 py-2 px-3 mb-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close small p-2" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('register') ?>" method="post" autocomplete="off">
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <!-- Display Name Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="display_name" id="display_name" placeholder="Full Name" required>
                                    <label for="display_name"><i class="bi bi-person me-1"></i> Name</label>
                                </div>
                            </div>

                            <!-- Username Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                    <label for="username"><i class="bi bi-at me-1"></i> Username</label>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
                                    <label for="email"><i class="bi bi-envelope me-1"></i> Email Address</label>
                                </div>
                            </div>
                            <!-- Password Field -->
                            <div class="col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="number" class="form-control" name="contact_number" id="password" placeholder="Contact Number" required>
                                    <label for="password"><i class="bi bi-lock me-1"></i> Contact Number</label>
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                    <label for="password"><i class="bi bi-lock me-1"></i> Password</label>
                                </div>
                            </div>

                            <!-- Role -->
                            <input type="hidden" class="form-control" name="role" id="password" placeholder="Role" value="User">

                            <!-- Assignment / Office Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="assignment" id="assignment" placeholder="Assignment/Office">
                                    <label for="assignment"><i class="bi bi-building me-1"></i> Assignment / Office</label>
                                </div>
                            </div>

                            <!-- Address Field -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                                    <label for="address"><i class="bi bi-geo-alt me-1"></i> Address</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm fw-bold">
                                Register Account
                            </button>
                        </div>
                    </form>

                </div>

                <div class="card-footer bg-white border-0 text-center py-3">
                    <p class="mb-0 text-muted small">Already have an account? <a href="<?= base_url('login') ?>" class="fw-bold text-primary text-decoration-none">Login here</a></p>
                    <p class="mb-0 text-muted small">or</p>    
                    <p class="mb-0 text-muted small">Back to <a href="<?= base_url('index') ?>" class="fw-bold text-primary text-decoration-none">Home</a></p>
                </div>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>