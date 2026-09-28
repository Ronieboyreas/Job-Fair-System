<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Fair Clearance Application Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('logo/jobfairsystem_icon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css') ?>">
    <style>
        .header-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.04);
        }
        .user-dropdown-btn:hover {
            background-color: #f8f9fa;
        }
        .form-section-header {
            background-color: #2b3035;
            color: #ffffff;
            font-weight: 700;
            padding: 6px 12px;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        .form-label-sm {
            font-size: 0.825rem;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
        }
        .bg-evaluation {
            background-color: #f8f9fa;
            border: 1px dashed #ced4da;
        }
    </style>
</head>
<body class="bg-light">
    <?= $this->include('layouts/sidebar') ?>
        <main class="content-wrapper">
            <?= $this->include('layouts/header') ?>
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <!-- Back Action -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php if (session()->get('role') === 'Administrator'): ?>
                            <a href="<?= base_url('applications') ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Back to Applications
                            </a>
                            <?php endif; ?>
                            <?php if (session()->get('role') === 'User' || session()->get('role') === 'Staff'): ?>
                            <a href="<?= site_url('user/dashboard') ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Back to Dashboard
                            </a>
                            <?php endif; ?>
                            <span class="badge bg-secondary">Form No. JF Clearance Application Form No. 001</span>
                        </div>

                        <!-- Form Card Container -->
                        <div class="card border-0 shadow-sm rounded-3">
                            
                            <!-- Official Header -->
                            <div class="card-header bg-white border-bottom p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center text-md-start mb-2 mb-md-0">
                                        <i class="bi bi-building-add display-5"></i>
                                    </div>
                                    <div class="col-md-8 text-center">
                                        <!--<h5 class="fw-bold mb-0 text-uppercase">Department of Labor and Employment</h5>-->
                                        <h4 class="fw-extrabold text-primary mb-0">JOB FAIR CLEARANCE APPLICATION FORM</h4>
                                        <p class="small text-muted mb-0">Fill out the required inputs with an asterisk (<i class="text-danger fw-bold">*</i>) sign</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">

                                <!-- Validation Alerts -->
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Please complete all required fields correctly:</strong>
                                        <ul class="mb-0 mt-2 small">
                                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                <li><?= esc($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>

                                <!-- Added enctype="multipart/form-data" for handling uploads -->
                                <form action="<?= base_url('applications/store') ?>" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>

                                    <!-- I. ORGANIZER / SPONSOR INFORMATION -->
                                    <div class="form-section-header rounded-1 mb-3">
                                        I. ORGANIZER / SPONSOR INFORMATION
                                    </div>

                                    <!-- 1. Name of Organization -->
                                    <div class="mb-3">
                                        <label class="form-label form-label-sm">1. Name / Organization <span class="text-danger fw-bold">*</span></label>
                                        <input type="text" name="organization_name" class="form-control" placeholder="Enter Full Name of Agency / Company / LGU" value="<?= old('organization_name') ?>" required>
                                    </div>

                                    <!-- 2. Contact / Focal Person -->
                                    <div class="mb-3">
                                        <label class="form-label form-label-sm">2. Contact / Focal Person <span class="text-danger fw-bold">*</span></label>
                                        <input type="text" name="focal_person" class="form-control mb-2" placeholder="Full Name of Designated Contact Person" value="<?= esc(session()->get('display_name')) ?>" required>
                                        
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-envelope"></i><label class="ms-2 small">E-Mail Address</label></div>
                                                    <input type="email" name="email" class="form-control" placeholder="example@email.com" value="<?= esc(session()->get('email'))?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-telephone"></i><label class="ms-2 small">Cellphone Number</label></div>
                                                    <input type="text" name="mobile_number" class="form-control" placeholder="09XXXXXXXXX" maxlength="11" value="<?= esc(session()->get('contact_number'))?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 3. Business Address -->
                                    <div class="mb-3">
                                        <label class="form-label form-label-sm">3. Business Address <span class="text-danger fw-bold">*</span></label>
                                        <textarea name="business_address" class="form-control" rows="2" placeholder="Street, Barangay, Municipality/City, Province" required><?= old('business_address') ?></textarea>
                                    </div>

                                    <!-- 4. Type of Business -->
                                    <div class="mb-3">
                                        <label class="form-label form-label-sm d-block">4. Type of Business <span class="text-danger fw-bold">*</span></label>
                                        <div class="d-flex flex-wrap gap-4 pt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_of_business" id="typeGov" value="National Government" <?= old('type_of_business') == 'National Government' ? 'checked' : '' ?> required>
                                                <label class="form-check-label" for="typeGov">National Government</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_of_business" id="typeLGU" value="Local Government Unit" <?= old('type_of_business') == 'Local Government Unit' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="typeLGU">Local Government Unit</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_of_business" id="typeSchool" value="School Based Institution" <?= old('type_of_business') == 'School Based Institution' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="typeSchool">School Based Institution</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_of_business" id="typePrivate" value="Private Entity" <?= old('type_of_business') == 'Private Entity' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="typePrivate">Private Entity / Agency</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 5. Nature of Business -->
                                    <div class="mb-4">
                                        <label class="form-label form-label-sm">5. Nature of Business <span class="text-danger fw-bold">*</span></label>
                                        <input type="text" name="nature_of_business" class="form-control" placeholder="e.g., Education, Recruitment Agency, Local Government Services" value="<?= old('nature_of_business') ?>" required>
                                    </div>


                                    <!-- II. PLANNED JOB FAIR EVENT -->
                                    <div class="form-section-header rounded-1 mb-3">
                                        II. PLANNED JOB FAIR EVENT
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <!-- 6. Type of Job Fair -->
                                        <div class="col-md-6">
                                            <label class="form-label form-label-sm d-block">6. Type of Job Fair <span class="text-danger fw-bold">*</span></label>
                                            <div class="d-flex gap-3 pt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="type_of_jobfair" id="jfLocal" value="Local" <?= old('type_of_jobfair') == 'Local' ? 'checked' : '' ?> required>
                                                    <label class="form-check-label" for="jfLocal">Local</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="type_of_jobfair" id="jfOverseas" value="Overseas" <?= old('type_of_jobfair') == 'Overseas' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="jfOverseas">Overseas</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="type_of_jobfair" id="jfBoth" value="Both" <?= old('type_of_jobfair') == 'Both' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="jfBoth">Both</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 7. Proposed Date -->
                                        <div class="col-md-6">
                                            <label class="form-label form-label-sm">7. Proposed Date <span class="text-danger fw-bold">*</span></label>
                                            <input type="date" name="proposed_date" class="form-control" value="<?= old('proposed_date') ?>" required>
                                        </div>
                                    </div>

                                    <!-- 8. Proposed Job Fair Site / Location Address -->
                                    <div class="mb-4">
                                        <label class="form-label form-label-sm">8. Proposed Job Fair Site / Location Address <span class="text-danger fw-bold">*</span></label>
                                        <textarea name="proposed_address" class="form-control" rows="2" placeholder="Full venue address" required></textarea>
                                    </div>


                                    <!-- III. PESO REVIEW AND ENDORSEMENT -->
                                    <div class="form-section-header rounded-1 mb-3">
                                        III. PESO REVIEW AND ENDORSEMENT
                                    </div>

                                    <p class="small text-muted mb-3">
                                        9. We have received, recorded, and reviewed the submitted Job Fair Application Form and have verified that the applicant has complied with all the requirements set by the Department of Labor and Employment with regard to the conduct of Job Fair with the submission of the following:
                                    </p>

                                    <!-- Document Checkboxes & Upload Inputs -->
                                    <div class="bg-light p-3 rounded-2 border mb-3">
                                        
                                        <!-- Additional Attachment Field -->
                                        <div class="mt-3">
                                            <label class="form-label form-label-sm mb-1 text-primary">
                                                <i class="bi bi-paperclip me-1"></i> Additional Attachment / Supporting Documents (Optional)
                                            </label>
                                            <div class="ms-4">
                                        <span class="form-text text-danger form-label-sm mb-1"><br>
                                            1. Navigate to this <a href="#">link.</a> <br>
                                            2. Create a folder and name the folder based on the Title of the JobFair. <br>
                                            3. Upload your pdf/jpg files containing the attachments for the job fair application. <br>
                                            4. Copy the link of your file/folder. <br>
                                            5. Paste the link in the input box below. <br>
                                        </span>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                            <input type="url" class="form-control" id="document_link" name="document_link" placeholder="https://drive.google.com/...">
                                        </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label form-label-sm">PESO Manager Name</label>
                                            <input type="text" name="peso_manager" class="form-control form-control-sm" placeholder="Endorsing PESO Manager" value="<?= old('peso_manager') ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label form-label-sm">PESO Office</label>
                                            <input type="text" name="peso_office" class="form-control form-control-sm" placeholder="e.g. PESO Tacloban / PESO Palo" value="<?= old('peso_office') ?>">
                                        </div>
                                    </div>


                                    <!-- IV. FIELD / DISTRICT EVALUATION AND APPROVAL (FOR OFFICE USE) -->
                                    <div class="form-section-header rounded-1 mb-3 bg-secondary">
                                        IV. FIELD / DISTRICT EVALUATION AND APPROVAL <span class="fw-normal text-white-50">(For DOLE Office Use Only)</span>
                                    </div>

                                    <div class="bg-evaluation p-3 rounded-2 mb-4">
                                        <p class="small fw-semibold text-muted mb-2">10. DOLE Office Evaluation Status:</p>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="evalComplied" disabled>
                                            <label class="form-check-label small text-muted" for="evalComplied">
                                                The applicant has complied with all the requirements set under Department Order No. ______
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="evalFailed" disabled>
                                            <label class="form-check-label small text-muted" for="evalFailed">
                                                The applicant failed to comply with the requirements set under Department Order No. ______
                                            </label>
                                        </div>
                                        <div class="border-top pt-2 mt-2">
                                            <span class="badge bg-warning text-dark">Pending Office Review</span>
                                            <small class="text-muted d-block mt-1">Note: DOLE Field Officers act on applications within five (5) working days upon receipt.</small>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="d-flex justify-content-end gap-2">
                                        <?php if (session()->get('role') === 'Administrator'): ?>
                                            <a href="<?= site_url('applications') ?>" class="btn btn-light border px-4">Cancel</a>
                                        <?php elseif (in_array(session()->get('role'), ['User', 'Staff'])): ?>
                                            <a href="<?= site_url('user/dashboard') ?>" class="btn btn-light border px-4">Cancel</a>
                                        <?php else: ?>
                                            <a href="<?= site_url('/') ?>" class="btn btn-light border px-4">Cancel</a>
                                        <?php endif; ?>

                                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                                            Submit Clearance Application
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="<?= base_url('js/sidebar.js') ?>"></script>
<script src="<?= base_url('js/user_dashboard.js') ?>"></script>
</body>
</html>