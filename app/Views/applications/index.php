<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Fair System | Applications</title>
    <link rel="icon" href="<?= base_url('logo/jobfairsystem_icon.ico') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css') ?>">
    <script src="<?= base_url('js/sidebar.js') ?>"></script>
    <style>
        .header-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.04);
        }
        .user-dropdown-btn:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-light">
    <?= $this->include('layouts/sidebar') ?>
    <main class="content-wrapper">
        <?= $this->include('layouts/header') ?>
        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Job Fair Activity Applications</h2>
                    <p class="text-muted mb-0">Manage and monitor submitted job fair activity applications.</p>
                </div>
                <a href="<?= base_url('user/application') ?>">
                    <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal">
                        <i class="bi bi-plus-lg"></i> New Application
                    </button>
                </a>
            </div>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="card shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="applicationsTable" class="table table-hover align-middle mb-0 border border-1">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="px-3">ID</th>
                                    <th scope="col">Job Fair Type</th>
                                    <th scope="col">Proposed Date</th>
                                    <th scope="col">Proposed Address</th>
                                    <th scope="col">Document</th>
                                    <th scope="col">Submitted By</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($applications) && is_array($applications)): ?>
                                    <?php foreach ($applications as $app): ?>
                                        <tr>
                                            <td class="px-3 fw-bold">#<?= esc($app['id']) ?></td>
                                            <td><?= esc($app['jobfair_type'] ?? 'N/A') ?></td>
                                            <td>
                                                <i class="bi text-secondary me-1"></i>
                                                <?= esc($app['proposed_date'] ?? 'N/A') ?>
                                            </td>
                                            <td><?= esc($app['proposed_address'] ?? 'N/A') ?></td>
                                            <td>
                                                <?php if (!empty($app['document_link'])): ?>
                                                    <a href="<?= esc($app['document_link']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-paperclip me-1"></i> View Doc
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">No file</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-semibold text-dark"><?= esc($app['display_name'] ?? 'Unknown User') ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <?php 
                                                    $status = strtolower($app['status'] ?? 'pending');
                                                    $badgeClass = match($status) {
                                                        'approved' => 'bg-success',
                                                        'rejected' => 'bg-danger',
                                                        'under review' => 'bg-info text-dark',
                                                        default => 'bg-warning text-dark'
                                                    };
                                                ?>
                                                <span class="badge <?= $badgeClass ?> text-capitalize px-2 py-1">
                                                    <?= esc($app['status'] ?? 'Pending') ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewModal<?= $app['id'] ?>" title="View Details">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $app['id'] ?>" title="Edit Application">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $app['id'] ?>" title="Delete Application">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="viewModal<?= $app['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title fw-bold">
                                                            <i class="bi bi-info-circle me-2"></i>Application Details #<?= esc($app['id']) ?>
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        
                                                        <!-- Section I: Organizer / Sponsor Information -->
                                                        <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">I. ORGANIZER / SPONSOR INFORMATION</h6>
                                                        <div class="row g-3 mb-4">
                                                            <div class="col-md-6">
                                                                <strong>Name / Organization:</strong>
                                                                <div><?= esc($app['organization_name'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Contact / Focal Person:</strong>
                                                                <div><?= esc($app['display_name'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Cellphone Number:</strong>
                                                                <div><?= esc($app['contact_number'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>E-Mail Address:</strong>
                                                                <div><?= esc($app['email'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Business Address:</strong>
                                                                <div><?= esc($app['business_address'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Type of Business:</strong>
                                                                <div><?= esc($app['business_type'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Nature of Business:</strong>
                                                                <div><?= esc($app['business_nature'] ?? 'N/A') ?></div>
                                                            </div>
                                                        </div>

                                                        <!-- Section II: Planned Job Fair Event -->
                                                        <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">II. PLANNED JOB FAIR EVENT</h6>
                                                        <div class="row g-3 mb-4">
                                                            <div class="col-md-6">
                                                                <strong>Type of Job Fair:</strong>
                                                                <div><?= esc($app['jobfair_type'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Proposed Date:</strong>
                                                                <div><?= esc($app['proposed_date'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Proposed Job Fair Site / Location Address:</strong>
                                                                <div><?= esc($app['proposed_address'] ?? 'N/A') ?></div>
                                                            </div>
                                                        </div>

                                                        <!-- Section III & IV: Review, Evaluation & Status -->
                                                        <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">III. EVALUATION & STATUS</h6>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <strong>Clearance Date Issued:</strong>
                                                                <div><?= esc($app['clearance_date_issued'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Application Date Received:</strong>
                                                                <div><?= esc($app['application_date_recieve'] ?? 'N/A') ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Submitted By:</strong>
                                                                <div><span class="fw-bold text-primary"><?= esc($app['display_name'] ?? 'N/A') ?></span></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Current Status:</strong>
                                                                <div><span class="badge <?= $badgeClass ?>"><?= esc($app['status'] ?? 'N/A') ?></span></div>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <strong>Document Link / Attachments:</strong>
                                                                <div>
                                                                    <?php if (!empty($app['document_link'])): ?>
                                                                        <a href="<?= esc($app['document_link']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                                            <i class="bi bi-file-earmark-text me-1"></i> Open Document <i class="bi bi-box-arrow-up-right ms-1"></i>
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">None</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="editModal<?= $app['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning text-dark">
                                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Application #<?= esc($app['id']) ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="<?= base_url('applications/update/' . $app['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-body p-4">
                                                            <div class="row g-3">
                                                                
                                                                <!-- Section: Organization Details -->
                                                                <div class="col-12">
                                                                    <h6 class="fw-bold text-primary border-bottom pb-2"><i class="bi bi-building me-2"></i>Organization Information</h6>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Organization / Business Name</label>
                                                                    <input type="text" class="form-control" name="organization_name" value="<?= esc($app['organization_name'] ?? '') ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Business Address</label>
                                                                    <input type="text" class="form-control" name="business_address" value="<?= esc($app['business_address'] ?? '') ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Type of Business</label>
                                                                    <input type="text" class="form-control" name="type_of_business" value="<?= esc($app['type_of_business'] ?? '') ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Nature of Business</label>
                                                                    <input type="text" class="form-control" name="nature_of_business" value="<?= esc($app['nature_of_business'] ?? '') ?>">
                                                                </div>

                                                                <!-- Section: Job Fair Details -->
                                                                <div class="col-12 mt-4">
                                                                    <h6 class="fw-bold text-primary border-bottom pb-2"><i class="bi bi-calendar-event me-2"></i>Job Fair Details</h6>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Job Fair Type</label>
                                                                    <select class="form-select" name="jobfair_type" required>
                                                                        <option value="LOCAL" <?= ($app['jobfair_type'] ?? '') === 'LOCAL' ? 'selected' : '' ?>>LOCAL</option>
                                                                        <option value="OVERSEAS" <?= ($app['jobfair_type'] ?? '') === 'OVERSEAS' ? 'selected' : '' ?>>OVERSEAS</option>
                                                                        <option value="BOTH" <?= ($app['jobfair_type'] ?? '') === 'BOTH' ? 'selected' : '' ?>>BOTH</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Proposed Date</label>
                                                                    <input type="date" class="form-control" name="proposed_date" value="<?= esc($app['proposed_date'] ?? '') ?>" required>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-bold">Proposed Venue / Address</label>
                                                                    <input type="text" class="form-control" name="proposed_address" value="<?= esc($app['proposed_address'] ?? '') ?>" required>
                                                                </div>

                                                                <!-- Section: PESO Office Information -->
                                                                <div class="col-12 mt-4">
                                                                    <h6 class="fw-bold text-primary border-bottom pb-2"><i class="bi bi-person-badge me-2"></i>PESO Information</h6>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">PESO Manager</label>
                                                                    <input type="text" class="form-control" name="peso_manager" value="<?= esc($app['peso_manager'] ?? '') ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">PESO Office</label>
                                                                    <input type="text" class="form-control" name="peso_office" value="<?= esc($app['peso_office'] ?? '') ?>">
                                                                </div>

                                                                <!-- Section: Status & Processing -->
                                                                <div class="col-12 mt-4">
                                                                    <h6 class="fw-bold text-primary border-bottom pb-2"><i class="bi bi-file-earmark-check me-2"></i>Application Processing</h6>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Application Date Received</label>
                                                                    <input type="date" class="form-control" name="application_date_recieve" value="<?= esc($app['application_date_recieve'] ?? '') ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Clearance Date Issued</label>
                                                                    <input type="date" class="form-control" name="clearance_date_issued" value="<?= esc($app['clearance_date_issued'] ?? '') ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Status</label>
                                                                    <select class="form-select" name="status" required>
                                                                        <option value="Pending" <?= ($app['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                                        <option value="Under Review" <?= ($app['status'] ?? '') === 'Under Review' ? 'selected' : '' ?>>Under Review</option>
                                                                        <option value="Approved" <?= ($app['status'] ?? '') === 'Approved' ? 'selected' : '' ?>>Approved</option>
                                                                        <option value="Rejected" <?= ($app['status'] ?? '') === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Document Link</label>
                                                                    <input type="url" class="form-control" name="document_link" value="<?= esc($app['document_link'] ?? '') ?>" placeholder="https://">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-warning fw-bold">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="deleteModal<?= $app['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title fw-bold"><i class="bi bi-trash-fill me-2"></i>Delete Application</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-center">
                                                        <i class="bi bi-exclamation-circle text-danger display-4 d-block mb-3"></i>
                                                        <p class="mb-0">Are you sure you want to delete Application <strong>#<?= esc($app['id']) ?></strong> for <strong><?= esc($app['jobfair_type']) ?></strong>?</p>
                                                        <small class="text-muted">This action cannot be undone.</small>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <a href="<?= base_url('applications/delete/' . $app['id']) ?>" class="btn btn-danger">Yes, Delete Application</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                            No applications found in the database.
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

    <div class="modal fade" id="createApplicationModal" tabindex="-1" aria-labelledby="createApplicationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold" id="createApplicationModalLabel">
                        <i class="bi bi-file-earmark-plus me-2"></i>Submit Job Fair Activity Application
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="<?= base_url('applications/store') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            
                            <!-- Job Fair Type -->
                            <div class="col-md-6">
                                <label for="jobfair_type" class="form-label fw-bold">Job Fair Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="jobfair_type" name="jobfair_type" required>
                                    <option value="" disabled selected>Select type...</option>
                                    <option value="LGU / PESO Hosted" <?= old('jobfair_type') === 'LGU / PESO Hosted' ? 'selected' : '' ?>>LGU / PESO Hosted</option>
                                    <option value="School-Based" <?= old('jobfair_type') === 'School-Based' ? 'selected' : '' ?>>School-Based</option>
                                    <option value="Private / Licensed Agency" <?= old('jobfair_type') === 'Private / Licensed Agency' ? 'selected' : '' ?>>Private / Licensed Agency</option>
                                    <option value="Special Job Fair" <?= old('jobfair_type') === 'Special Job Fair' ? 'selected' : '' ?>>Special Job Fair</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="proposed_date" class="form-label fw-bold">Proposed Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="proposed_date" name="proposed_date" value="<?= old('proposed_date') ?>" required>
                            </div>
                            <div class="col-12">
                                <label for="proposed_address" class="form-label fw-bold">Proposed Venue / Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="proposed_address" name="proposed_address" placeholder="e.g. Tacloban City Convention Center, Tacloban City" value="<?= old('proposed_address') ?>" required>
                            </div>

                            <!-- Clearance Date Issued 
                            <div class="col-md-6">
                                <label for="clearance_date_issued" class="form-label fw-bold">Clearance Date Issued <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="clearance_date_issued" name="clearance_date_issued" value="<?= old('clearance_date_issued') ?>" required>
                            </div>
                            -->
                            <div class="col-md-6">
                                <label for="application_date_recieve" class="form-label fw-bold">Application Date Received <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="application_date_recieve" name="application_date_recieve" value="<?= old('application_date_recieve', date('Y-m-d')) ?>" required>
                            </div>
                            <div class="col-12">
                                <label for="document_link" class="form-label fw-bold">Document Link (Google Drive / Cloud Storage)</label>
                                <span class="form-text text-danger" style="font-size: 10pt;"><br>
                                    1. Navigate to this <a href="#">link.</a> <br>
                                    2. Create a folder and name the folder based on the Title of the. <br>
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

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="bi bi-send-fill"></i> Submit Application
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var modal = new bootstrap.Modal(document.getElementById('createApplicationModal'));
                modal.show();
            });
        </script>
    <?php endif; ?>
    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('js/applications.js') ?>"></script>
    <script src="<?= base_url('js/navbar_header.js') ?>"></script>
</body>
</html>