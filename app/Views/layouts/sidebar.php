<!-- Sidebar Markup -->
<aside class="sidebar bg-dark text-white d-flex flex-column position-fixed top-0 start-0 vh-100 shadow" id="sidebar">
    
    <!-- App Title / Logo + Toggle Button -->
    <div class="sidebar-header p-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2 overflow-hidden">
            <img src="<?= base_url('logo/jobfairsystem_icon.ico') ?>" 
                 alt="e-JobFair Icon" 
                 class="img-fluid flex-shrink-0" 
                 style="max-height: 32px; width: auto;">
            <span class="sidebar-text fw-bold fs-6 text-white text-truncate">e-JobFair Portal</span>
        </div>
        <button type="button" class="btn btn-sm text-white-50 p-0 border-0 shadow-none hover-white" id="sidebarToggle" title="Toggle Sidebar">
            <i class="bi bi-list fs-3"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="sidebar-nav nav nav-pills flex-column px-2 py-3 flex-grow-1 overflow-y-auto">
        
        <?php if (session()->get('role') === 'Administrator'): ?>
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link text-white d-flex align-items-center mb-1 rounded-3 <?= url_is('admin/dashboard*') ? 'active bg-primary text-white' : '' ?>" title="Dashboard">
                <i class="bi bi-speedometer2 fs-5"></i> 
                <span class="sidebar-text ms-3">Dashboard</span>
            </a>
        <?php endif; ?>
        
        <?php if (session()->get('role') === 'Staff' || session()->get('role') === 'User'): ?>
            <a href="<?= base_url('user/dashboard') ?>" class="nav-link text-white d-flex align-items-center mb-1 rounded-3 <?= url_is('user/dashboard*') ? 'active bg-primary text-white' : '' ?>" title="Dashboard">
                <i class="bi bi-speedometer2 fs-5"></i> 
                <span class="sidebar-text ms-3">Dashboard</span>
            </a>
            <a href="<?= base_url('employer') ?>" class="nav-link text-white d-flex align-items-center mb-1 rounded-3 <?= url_is('employer*') ? 'active bg-primary text-white' : '' ?>" title="Employers">
                <i class="bi bi-buildings fs-5"></i> 
                <span class="sidebar-text ms-3">Employers</span>
            </a>
            <a href="<?= base_url('user/application') ?>" class="nav-link text-white d-flex align-items-center mb-1 rounded-3 <?= url_is('user/application*') ? 'active bg-primary text-white' : '' ?>" title="Application">
                <i class="bi bi-folder-plus fs-5"></i> 
                <span class="sidebar-text ms-3">Application</span>
            </a>
            <a href="<?= base_url('user/calendar') ?>" class="nav-link text-white d-flex align-items-center mb-1 rounded-3 <?= url_is('user/calendar*') ? 'active bg-primary text-white' : '' ?>" title="Calendar">
                <i class="bi bi-calendar2-event fs-5"></i>
                <span class="sidebar-text ms-3">Calendar</span>
            </a>
            <a href="<?= base_url('user/settings') ?>" class="nav-link text-white d-flex align-items-center mb-1 rounded-3 <?= url_is('user/settings*') ? 'active bg-primary text-white' : '' ?>" title="Account Settings">
                <i class="bi bi-gear fs-5"></i>
                <span class="sidebar-text ms-3">Account Settings</span>
            </a>
        <?php endif; ?>
        
        <?php if (session()->get('role') === 'Administrator'): ?>
            <a href="<?= base_url('applications') ?>" class="nav-link text-white d-flex align-items-center mb-1 rounded-3 <?= url_is('applications*') ? 'active bg-primary text-white' : '' ?>" title="Applications">
                <i class="bi bi-file-earmark-text fs-5"></i> 
                <span class="sidebar-text ms-3">Applications</span>
            </a>

            <!-- ADMIN CONTROLS SECTION -->
            <div class="sidebar-section-title px-3 pt-3 pb-1 text-uppercase text-white-50 fw-bold sidebar-text" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                Admin Controls
            </div>
            <hr class="sidebar-divider my-2 border-secondary border-opacity-25">

            <a href="<?= base_url('admin/account') ?>" class="nav-link text-white d-flex align-items-center mb-1 rounded-3 <?= url_is('admin/account*') ? 'active bg-primary text-white' : '' ?>" title="Manage Accounts">
                <i class="bi bi-person-gear fs-5"></i> 
                <span class="sidebar-text ms-3">Manage Accounts</span>
            </a>

            <a href="<?= base_url('admin/reports') ?>" class="nav-link text-white d-flex align-items-center mb-1 rounded-3 <?= url_is('admin/reports*') ? 'active bg-primary text-white' : '' ?>" title="Activity Reports">
                <i class="bi bi-graph-up fs-5"></i> 
                <span class="sidebar-text ms-3">Activity Reports</span>
            </a>
        <?php endif; ?>

    </div>

    <!-- Redesigned Sidebar Footer -->
    <div class="sidebar-footer border-top border-secondary border-opacity-25 p-3 text-center text-md-start">
        <div class="sidebar-text text-white-50 small mb-1">
            &copy; <?= date('Y') ?> <strong class="text-white">e-JobFair Portal</strong>
        </div>
        <div class="sidebar-text text-white-50" style="font-size: 0.725rem;">
            All Rights Reserved. <span class="badge bg-secondary bg-opacity-50 text-white-50 ms-1">v1.0</span>
        </div>
        <div class="sidebar-icon-only text-center d-none" title="&copy; <?= date('Y') ?> e-JobFair Portal">
            <i class="bi bi-c-circle text-white-50 fs-6"></i>
        </div>
    </div>

</aside>