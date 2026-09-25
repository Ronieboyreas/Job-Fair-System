<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Fair System - Dashboard</title>
    <link rel="icon" href="<?= base_url('logo/jobfairsystem_icon.ico') ?>">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="<?= base_url('css/sidebar.css') ?>">
</head>
<body>
    <?= $this->include('layouts/sidebar') ?>
    <!-- Main Content Area -->
    <main class="content-wrapper">
        <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Validation Alerts -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-primary text-white p-4 rounded-top-3">
                        <h4 class="mb-1 fw-bold">Job Fair Activity Application</h4>
                        <p class="mb-0 text-white-50 small">Fill out the required information below to register for the upcoming Job Fair.</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="<?= site_url('user/apply/store') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="row g-3">
                                <!-- Full Name -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="full_name" 
                                           class="form-control" 
                                           placeholder="e.g. Juan Cruz" 
                                           value="<?= old('full_name', $user['display_name'] ?? '') ?>" 
                                           required>
                                </div>

                                <!-- Email Address -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           name="email" 
                                           class="form-control" 
                                           placeholder="e.g. juan@gmail.com" 
                                           value="<?= old('email', $user['email'] ?? '') ?>" 
                                           required>
                                </div>

                                <!-- Contact Number -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="contact_number" 
                                           class="form-control" 
                                           placeholder="09123456789" 
                                           maxlength="11" 
                                           value="<?= old('contact_number', $user['contact_number'] ?? '') ?>" 
                                           required>
                                    <div class="form-text">Must be 11 digits starting with 09.</div>
                                </div>

                                <!-- Educational Attainment -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Educational Attainment <span class="text-danger">*</span></label>
                                    <select name="educational_attainment" class="form-select" required>
                                        <option value="" disabled <?= old('educational_attainment') ? '' : 'selected' ?>>Select Level</option>
                                        <option value="High School Graduate" <?= old('educational_attainment') === 'High School Graduate' ? 'selected' : '' ?>>High School Graduate</option>
                                        <option value="Senior High School Graduate" <?= old('educational_attainment') === 'Senior High School Graduate' ? 'selected' : '' ?>>Senior High School Graduate</option>
                                        <option value="College Undergraduate" <?= old('educational_attainment') === 'College Undergraduate' ? 'selected' : '' ?>>College Undergraduate</option>
                                        <option value="College Graduate" <?= old('educational_attainment') === 'College Graduate' ? 'selected' : '' ?>>College Graduate</option>
                                        <option value="Master's / Doctorate Degree" <?= old('educational_attainment') === "Master's / Doctorate Degree" ? 'selected' : '' ?>>Master's / Doctorate Degree</option>
                                    </select>
                                </div>

                                <!-- Preferred Occupation -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Preferred Occupation / Position <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="preferred_occupation" 
                                           class="form-control" 
                                           placeholder="e.g. Software Developer, Administrative Assistant, IT Support" 
                                           value="<?= old('preferred_occupation') ?>" 
                                           required>
                                </div>

                                <!-- Complete Address -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Complete Address <span class="text-danger">*</span></label>
                                    <textarea name="address" 
                                              rows="3" 
                                              class="form-control" 
                                              placeholder="Street, Barangay, City/Municipality, Province" 
                                              required><?= old('address', $user['address'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?= site_url('user/dashboard') ?>" class="btn btn-light border">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                     Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="<?= base_url('js/sidebar.js') ?>"></script>
        <script src="<?= base_url('js/user_application.js') ?>"></script>
</body>
</html>