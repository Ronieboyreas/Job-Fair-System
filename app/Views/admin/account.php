<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User Accounts - Admin</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom Sidebar CSS -->
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css') ?>">
</head>
<body class="bg-light">

    <!-- Include Reusable Sidebar -->
    <?= $this->include('layouts/sidebar') ?>

    <main class="content-wrapper">
        <div class="container-fluid p-4">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Accounts</h2>
                </div>
                <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 shadow-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#addAccountModal">
                    <i class="bi bi-person-plus-fill fs-6"></i>
                    <span>Add Account</span>
                </button>
            </div>
            <hr>
            
            <!-- Flash Notifications -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-octagon-fill me-2"></i>Please resolve the following errors:</div>
                    <ul class="mb-0 ps-4">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Table Card -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light border-bottom">
                                <tr>
                                    <th class="ps-4 py-3">#ID</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Email Address</th>
                                    <th class="py-3">Role</th>
                                    <th class="py-3">Address</th>
                                    <th class="py-3">Assignment</th>
                                    <th class="text-end pe-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users) && is_array($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-secondary">#<?= esc($user['id']) ?></td>
                                            <td>
                                                <div class="fw-semibold text-dark"><?= esc($user['display_name'] ?? 'N/A') ?></div>
                                            </td>
                                            <td class="text-secondary"><?= esc($user['email']) ?></td>
                                            <td>
                                                <?php 
                                                    $roleClass = match($user['role'] ?? 'User') {
                                                        'Administrator' => 'bg-danger text-danger',
                                                        'User' => 'bg-info text-info',
                                                        'Staff' => 'bg-secondary text-secondary'
                                                    };
                                                ?>
                                                <span class="badge <?= $roleClass ?> bg-opacity-10 px-2 py-1 fs-7 fw-semibold">
                                                    <?= esc($user['role'] ?? 'User') ?>
                                                </span>
                                            </td>
                                            <td class="text-muted fs-7">
                                                <?= esc($user['address'] ?? 'N/A') ?>
                                            </td>
                                            <td class="text-muted fs-7">
                                                <?= esc($user['assignment'] ?? 'N/A') ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <!-- View Button -->
                                                <button class="btn btn-sm btn-outline-primary me-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewModal<?= $user['id'] ?>"
                                                        title="View User Details">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>

                                                <!-- Edit Button -->
                                                <button class="btn btn-sm btn-outline-warning me-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editModal<?= $user['id'] ?>"
                                                        title="Edit User">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal<?= $user['id'] ?>"
                                                        title="Delete User">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- VIEW USER MODAL -->
                                        <div class="modal fade" id="viewModal<?= $user['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header border-0 bg-light py-3">
                                                        <h5 class="modal-title fw-bold">User Information</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="mb-3">
                                                            <label class="text-muted small text-uppercase fw-semibold d-block mb-1">User ID</label>
                                                            <p class="fw-bold text-dark mb-0">#<?= esc($user['id']) ?></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="text-muted small text-uppercase fw-semibold d-block mb-1">Full Name</label>
                                                            <p class="fw-bold text-dark mb-0"><?= esc($user['display_name'] ?? 'N/A') ?></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="text-muted small text-uppercase fw-semibold d-block mb-1">Email Address</label>
                                                            <p class="fw-bold text-dark mb-0"><?= esc($user['email']) ?></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="text-muted small text-uppercase fw-semibold d-block mb-1">Role</label>
                                                            <p class="mb-0">
                                                                <span class="badge bg-primary px-2 py-1"><?= esc($user['role'] ?? 'User') ?></span>
                                                            </p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="text-muted small text-uppercase fw-semibold d-block mb-1">Address</label>
                                                            <p class="fw-bold text-dark mb-0"><?= esc($user['address'] ?? 'N/A') ?></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="text-muted small text-uppercase fw-semibold d-block mb-1">Assignment</label>
                                                            <p class="fw-bold text-dark mb-0"><?= esc($user['assignment'] ?? 'N/A') ?></p>
                                                        </div>
                                                        <div>
                                                            <label class="text-muted small text-uppercase fw-semibold d-block mb-1">Registration Date</label>
                                                            <p class="fw-bold text-dark mb-0"><?= esc($user['created_at'] ?? 'N/A') ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 bg-light py-2">
                                                        <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ADD USER MODAL -->
                                        <div class="modal fade" id="addAccountModal" tabindex="-1" aria-hidden="true">
                                            
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <form action="<?= base_url('account/store') ?>" method="POST">
                                                        <?= csrf_field() ?>
                                                        
                                                        <div class="modal-header border-0 bg-light py-3">
                                                            <h5 class="modal-title fw-bold">
                                                                <i class="bi bi-person-plus me-2 text-primary"></i>Add New Account
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-4">
                                                            <div class="row g-3">
                                                                <!-- Column 1: Full Name -->
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-secondary">Full Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="display_name" class="form-control" placeholder="Name" value="<?= old('display_name') ?>" required>
                                                                </div>

                                                                <!-- Column 2: Email Address -->
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-secondary">Email Address <span class="text-danger">*</span></label>
                                                                    <input type="email" name="email" class="form-control" placeholder="example@example.com" value="<?= old('email') ?>" required>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-semibold text-secondary">Address</label>
                                                                    <input type="text" name="address" class="form-control" placeholder="Street, City, Province" value="<?= old('address') ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-secondary">Account Role <span class="text-danger">*</span></label>
                                                                    <select name="role" class="form-select" required>
                                                                        <option value="User" <?= old('role') === 'User' ? 'selected' : '' ?>>User</option>
                                                                        <option value="Staff" <?= old('role') === 'Staff' ? 'selected' : '' ?>>Staff</option>
                                                                        <option value="Administrator" <?= old('role') === 'Administrator' ? 'selected' : '' ?>>Administrator</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Column 2: Assignment -->
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-secondary">Assignment</label>
                                                                    <input type="text" name="assignment" class="form-control" placeholder="e.g. Field Office / PESO Office" value="<?= old('assignment') ?>">
                                                                </div>
                                                                <!-- Column 2: Username -->
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-secondary">Username <span class="text-danger">*</span></label>
                                                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                                                </div>
                                                                <!-- Full Width / Single Column: Password -->
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-secondary">Password <span class="text-danger">*</span></label>
                                                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer border-0 bg-light py-3">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary px-4">Create Account</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- EDIT USER MODAL -->
                                        <div class="modal fade" id="editModal<?= $user['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <form action="<?= base_url('account/update/' . $user['id']) ?>" method="POST">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-header border-0 bg-light py-3">
                                                            <h5 class="modal-title fw-bold">Edit Account #<?= $user['id'] ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-secondary">Full Name</label>
                                                                <input type="text" name="display_name" class="form-control" value="<?= esc($user['display_name'] ?? '') ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-secondary">Email Address</label>
                                                                <input type="email" name="email" class="form-control" value="<?= esc($user['email'] ?? '') ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-secondary">Account Role</label>
                                                                <select name="role" class="form-select">
                                                                    <option value="User" <?= ($user['role'] ?? '') === 'User' ? 'selected' : '' ?>>User</option>
                                                                    <option value="Staff" <?= ($user['role'] ?? '') === 'Staff' ? 'selected' : '' ?>>Staff</option>
                                                                    <option value="Administrator" <?= ($user['role'] ?? '') === 'Administrator' ? 'selected' : '' ?>>Administrator</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-secondary">Address</label>
                                                                <input type="text" name="address" class="form-control" value="<?= esc($user['address'] ?? '') ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-secondary">Assignment</label>
                                                                <input type="text" name="assignment" class="form-control" value="<?= esc($user['assignment'] ?? '') ?>">
                                                            </div>
                                                            <div class="mb-0">
                                                                <label class="form-label fw-semibold text-secondary">New Password</label>
                                                                <input type="password" name="password" class="form-control" placeholder="••••••••">
                                                                <div class="form-text">Leave blank if you do not wish to change the password.</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 bg-light py-3">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- DELETE CONFIRMATION MODAL -->
                                        <div class="modal fade" id="deleteModal<?= $user['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header border-0 bg-light py-3">
                                                        <h5 class="modal-title fw-bold text-danger">Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-center">
                                                        <i class="bi bi-exclamation-circle text-danger display-4 d-block mb-3"></i>
                                                        <h5 class="fw-bold mb-2">Are you sure?</h5>
                                                        <p class="text-muted mb-0">You are about to delete user account <strong><?= esc($user['display_name'] ?? $user['email']) ?></strong>. This action cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer border-0 bg-light justify-content-center py-3">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                                        <a href="<?= base_url('account/delete/' . $user['id']) ?>" class="btn btn-danger px-4">Delete Account</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="bi bi-people fs-2 d-block mb-2 text-secondary"></i>
                                            No user accounts found in the database.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Sidebar Script -->
    <script src="<?= base_url('js/sidebar.js') ?>"></script>
</body>
</html>