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
<body>
    <?= $this->include('layouts/sidebar') ?>
    <!-- Main Content Area -->
    <main class="content-wrapper">
        <?= $this->include('layouts/header') ?>
        <div class="container pb-5">
            <div class="row g-3 mb-4">

                <!-- Total Applications -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-3 bg-info bg-opacity-10 p-3 me-3 text-info">
                                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle text-muted fw-semibold">Total Applications</h6>
                                <h3 class="fw-bold text-dark mb-0"><?= number_format($totalApps ?? 0) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Applications -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-3 bg-warning bg-opacity-10 p-3 me-3 text-warning">
                                <i class="bi bi-hourglass-split fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle text-muted fw-semibold">Pending</h6>
                                <h3 class="fw-bold text-dark mb-0"><?= number_format($pendingApps ?? 0) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approved / Hired Applications -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3 text-success">
                                <i class="bi bi-check-circle-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle text-muted fw-semibold">Approved</h6>
                                <h3 class="fw-bold text-dark mb-0"><?= number_format($approvedApps ?? 0) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected Applications -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-3 bg-danger bg-opacity-10 p-3 me-3 text-danger">
                                <i class="bi bi-x-circle-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle text-muted fw-semibold">Rejected</h6>
                                <h3 class="fw-bold text-dark mb-0"><?= number_format($rejectedApps ?? 0) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <h4 class="fw-bold text-dark mb-1">My Job Fair Applications</h4>
            <p class="text-muted small mb-0">Overview of applications registered under your account.</p><hr>
            <!-- Flash Messages for Success / Error -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- Applications Table Card -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="userApplicationsTable" class="table table-hover align-middle mb-0" style="width:100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Jobfair ID</th>
                                    <th>Proposed Date</th>
                                    <th>Proposed Address</th>
                                    <th>Document Link</th>
                                    <th>Date Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($applications)): ?>
                                    <?php foreach ($applications as $app): ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    $statusClass = match(strtolower($app['status'] ?? 'Pending')) {
                                                        'approved' => 'bg-success-subtle text-success',
                                                        'rejected'          => 'bg-danger-subtle text-danger',
                                                        default             => 'bg-warning-subtle text-warning-emphasis'
                                                    };
                                                ?>
                                                <span class="badge <?= $statusClass ?> rounded-pill px-3 py-1">
                                                    <?= ucfirst(esc($app['status'] ?? 'Pending')) ?>
                                                </span>
                                            </td>
                                            <td class="fw-semibold text-dark"># <?= esc($app['id']) ?></td>
                                            <td class="fw-semibold text-dark"><?= esc($app['proposed_date']) ?></td>
                                            <td><?= esc($app['proposed_address']) ?></td>
                                            <td>
                                                <?php if (!empty($app['document_link'])): ?>
                                                    <a href="<?= esc($app['document_link']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-paperclip me-1"></i> View Doc
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">No file</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="small text-muted">
                                                <?= !empty($app['created_at']) ? date('M d, Y - h:i A', strtotime($app['created_at'])) : 'N/A' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
        <script src="<?= base_url('js/user_dashboard.js') ?>"></script>
</body>
</html>