<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Fair System | Applications</title>
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom Sidebar CSS -->
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css') ?>">
    <script src="<?= base_url('js/sidebar.js') ?>"></script>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f8f9fa;">

    <!-- Include Reusable Sidebar -->
    <?= $this->include('layouts/sidebar') ?>

    <!-- Main Content Wrapper -->
    <main class="content-wrapper">
        <div class="container-fluid p-4">
            
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Job Fair Activity Applications</h2>
                    <p class="text-muted mb-0">Manage and monitor submitted job fair activity applications.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createApplicationModal">
                    <i class="bi bi-plus-lg"></i> New Application
                </button>
            </div>

            <!-- Flash Notifications -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Applications Data Table Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
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
                                            <!-- Action Buttons Column -->
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <!-- View Button -->
                                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewModal<?= $app['id'] ?>" title="View Details">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button>
                                                    <!-- Edit Button -->
                                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $app['id'] ?>" title="Edit Application">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $app['id'] ?>" title="Delete Application">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- VIEW MODAL -->
                                        <div class="modal fade" id="viewModal<?= $app['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title fw-bold"><i class="bi bi-info-circle me-2"></i>Application Details #<?= esc($app['id']) ?></h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <strong>Job Fair Type:</strong> 
                                                                <span><?= esc($app['jobfair_type']) ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <strong>Proposed Date:</strong> 
                                                                <span><?= esc($app['proposed_date']) ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <strong>Proposed Address:</strong> 
                                                                <span><?= esc($app['proposed_address']) ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <strong>Clearance Date Issued:</strong> 
                                                                <span><?= esc($app['clearance_date_issued']) ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <strong>Application Date Received:</strong> 
                                                                <span><?= esc($app['application_date_recieve']) ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <strong>Submitted By:</strong> 
                                                                <span class="fw-bold text-primary"><?= esc($app['display_name'] ?? 'N/A') ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <strong>Current Status:</strong> 
                                                                <span class="badge <?= $badgeClass ?>"><?= esc($app['status']) ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <strong>Document Link:</strong> 
                                                                <?php if (!empty($app['document_link'])): ?>
                                                                    <a href="<?= esc($app['document_link']) ?>" target="_blank" class="text-decoration-none">Open Document <i class="bi bi-box-arrow-up-right"></i></a>
                                                                <?php else: ?>
                                                                    <span class="text-muted">None</span>
                                                                <?php endif; ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- EDIT MODAL -->
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
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Job Fair Type</label>
                                                                    <select class="form-select" name="jobfair_type" required>
                                                                        <option value="LGU / PESO Hosted" <?= $app['jobfair_type'] === 'LGU / PESO Hosted' ? 'selected' : '' ?>>LGU / PESO Hosted</option>
                                                                        <option value="School-Based" <?= $app['jobfair_type'] === 'School-Based' ? 'selected' : '' ?>>School-Based</option>
                                                                        <option value="Private / Licensed Agency" <?= $app['jobfair_type'] === 'Private / Licensed Agency' ? 'selected' : '' ?>>Private / Licensed Agency</option>
                                                                        <option value="Special Job Fair" <?= $app['jobfair_type'] === 'Special Job Fair' ? 'selected' : '' ?>>Special Job Fair</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Proposed Date</label>
                                                                    <input type="date" class="form-control" name="proposed_date" value="<?= esc($app['proposed_date']) ?>" required>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-bold">Proposed Address</label>
                                                                    <input type="text" class="form-control" name="proposed_address" value="<?= esc($app['proposed_address']) ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Clearance Date Issued</label>
                                                                    <input type="date" class="form-control" name="clearance_date_issued" value="<?= esc($app['clearance_date_issued']) ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Application Date Received</label>
                                                                    <input type="date" class="form-control" name="application_date_recieve" value="<?= esc($app['application_date_recieve']) ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Status</label>
                                                                    <select class="form-select" name="status" required>
                                                                        <option value="Pending" <?= $app['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                                        <option value="Under Review" <?= $app['status'] === 'Under Review' ? 'selected' : '' ?>>Under Review</option>
                                                                        <option value="Approved" <?= $app['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
                                                                        <option value="Rejected" <?= $app['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Document Link</label>
                                                                    <input type="url" class="form-control" name="document_link" value="<?= esc($app['document_link']) ?>">
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

                                        <!-- DELETE CONFIRMATION MODAL -->
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

    <!-- CREATE APPLICATION MODAL -->
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

                            <!-- Proposed Date -->
                            <div class="col-md-6">
                                <label for="proposed_date" class="form-label fw-bold">Proposed Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="proposed_date" name="proposed_date" value="<?= old('proposed_date') ?>" required>
                            </div>

                            <!-- Proposed Address -->
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

                            <!-- Application Date Received -->
                            <div class="col-md-6">
                                <label for="application_date_recieve" class="form-label fw-bold">Application Date Received <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="application_date_recieve" name="application_date_recieve" value="<?= old('application_date_recieve', date('Y-m-d')) ?>" required>
                            </div>

                            <!-- Document Link -->
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
                                    <input type="url" class="form-control" id="document_link" name="document_link" placeholder="https://drive.google.com/..." value="<?= old('document_link') ?>">
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

    <!-- Auto-reopen Modal if Validation Fails -->
    <?php if (session()->getFlashdata('errors')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var modal = new bootstrap.Modal(document.getElementById('createApplicationModal'));
                modal.show();
            });
        </script>
    <?php endif; ?>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>