<?php 
$userRole = session()->get('role') ?? ''; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar - Job Fair System</title>
    <link rel="icon" href="<?= base_url('logo/jobfairsystem_icon.ico') ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FullCalendar 6 JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <link rel="stylesheet" href="<?= base_url('css/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/calendar.css') ?>">
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
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Edit Event Modal -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold" id="modalTitle">Application Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="editEventForm">
                        <div class="modal-body p-4">
                            <input type="hidden" id="event_id" name="id">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Organization / Sponsor</label>
                                <input type="text" class="form-control" id="organization_name" name="organization_name" <?= ($userRole !== 'Administrator') ? 'readonly' : '' ?>>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Submitted By</label>
                                <input type="text" class="form-control" id="event_applicant" name="event_applicant" <?= ($userRole !== 'Administrator') ? 'readonly' : '' ?>>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Job Fair Type</label>
                                <input type="text" class="form-control" id="event_type" name="event_type" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Proposed Address / Site</label>
                                <input type="text" class="form-control" id="event_address" name="event_address" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="proposed_date" class="form-label fw-bold">Proposed Date</label>
                                <input type="date" class="form-control" id="proposed_date" name="proposed_date" required>
                            </div>

                            <?php if (in_array($userRole, ['Staff', 'Administrator'])): ?>
                            <div class="mb-3">
                                <label for="event_status" class="form-label fw-bold">Application Status</label>
                                <select class="form-select" id="event_status" name="status">
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <?php endif; ?>

                            <div id="readOnlyNotice" class="alert alert-info py-2 d-none">
                                <i class="bi bi-info-circle me-1"></i> You are viewing this entry in read-only mode.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="saveBtn" class="btn btn-primary fw-bold">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('js/sidebar.js') ?>"></script>
<script>
    const CALENDAR_CONFIG = {
        fetchUrl: "<?= site_url('user/calendar/fetch') ?>",
        updateUrl: "<?= site_url('user/calendar/update') ?>",
        userRole: "<?= session()->get('role') ?>"
    };
    const CURRENT_ACCOUNT_ID = '<?= session()->get('account_id') ?? session()->get('user_id') ?>';
    const USER_ROLE = '<?= session()->get('role') ?>';
</script>
<script src="<?= base_url('js/calendar.js') ?>"></script>
<script src="<?= base_url('js/navbar_header.js') ?>"></script>
</body>
</html>