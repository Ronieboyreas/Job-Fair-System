<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Fair System | Account Settings</title>
    <link rel="icon" href="<?= base_url('logo/jobfairsystem_icon.ico') ?>">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/navbar_header.css') ?>">

    <style>
        :root {
            --bs-body-bg: #f8f9fa;
        }
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .avatar-lg {
            width: 72px;
            height: 72px;
            font-size: 1.75rem;
        }
        .form-control:focus, .input-group-text:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .input-group-text {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        .section-title {
            font-size: 1.05rem;
            letter-spacing: 0.3px;
        }
    </style>
</head>
<body class="bg-light">

<?= $this->include('layouts/sidebar') ?>

<main class="content-wrapper">
    <?= $this->include('layouts/header') ?>

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">

                <!-- Flash Notifications -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                            <div><?= session()->getFlashdata('success') ?></div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                            <div><?= session()->getFlashdata('error') ?></div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-octagon-fill fs-5 me-2 mt-1"></i>
                            <ul class="mb-0 ps-2">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Account Overview Banner -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-sm-row align-items-center gap-3 text-center text-sm-start">
                            <div class="avatar-lg bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                <?= strtoupper(substr(session()->get('display_name') ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="fw-bold mb-1"><?= esc(session()->get('display_name') ?? 'User') ?></h4>
                                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start gap-2">
                                    <span class="badge bg-light text-secondary border fw-normal">
                                        <i class="bi bi-at me-1"></i><?= esc(session()->get('username') ?? 'username') ?>
                                    </span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fw-medium px-2 py-1">
                                        <i class="bi bi-shield-check me-1"></i>Active Account
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Profile Information Card -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <h6 class="card-title fw-bold text-dark mb-0 section-title">
                                    <i class="bi bi-person-gear text-primary me-2"></i>Profile Information
                                </h6>
                                <span class="text-muted small">Personal Details</span>
                            </div>
                            <div class="card-body p-4">
                                <form action="<?= base_url('account_settings/update-profile') ?>" method="post">
                                    <?= csrf_field() ?>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-secondary">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" name="display_name" 
                                                value="<?= esc(session()->get('display_name') ?? '') ?>" required placeholder="John Doe">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-secondary">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-at"></i></span>
                                            <input type="text" class="form-control" name="username" 
                                                value="<?= esc(session()->get('username') ?? '') ?>" required placeholder="johndoe">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-secondary">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control" name="email" 
                                                value="<?= esc(session()->get('email') ?? '') ?>" required placeholder="john@example.com">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label small fw-semibold text-secondary">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="tel" class="form-control" name="contact_number" 
                                                value="<?= esc(session()->get('contact_number') ?? '') ?>" placeholder="+63 900 000 0000">
                                        </div>
                                    </div>

                                    <hr class="my-4 text-secondary opacity-25">

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary fw-medium px-4 d-inline-flex align-items-center gap-2">
                                            <i class="bi bi-check2-circle"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security / Change Password Card -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <h6 class="card-title fw-bold text-dark mb-0 section-title">
                                    <i class="bi bi-shield-lock text-danger me-2"></i>Security Settings
                                </h6>
                                <span class="text-muted small">Authentication</span>
                            </div>
                            <div class="card-body p-4">
                                <form action="<?= base_url('account_settings/change-password') ?>" method="post">
                                    <?= csrf_field() ?>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-secondary">Current Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required placeholder="••••••••">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-secondary">New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8" placeholder="••••••••">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text text-muted small">Minimum 8 characters long.</div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label small fw-semibold text-secondary">Confirm New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="8" placeholder="••••••••">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <hr class="my-4 text-secondary opacity-25">

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-danger fw-medium px-4 d-inline-flex align-items-center gap-2">
                                            <i class="bi bi-arrow-repeat"></i> Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('js/navbar_header.js') ?>"></script>
<script src="<?= base_url('js/sidebar.js') ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            });
        });
    });
</script>
</body>
</html>