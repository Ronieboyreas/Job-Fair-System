<!-- Sidebar Markup -->
<aside class="sidebar text-white d-flex flex-column position-fixed top-0 start-0 vh-100 shadow-sm" id="sidebar" style="font-weight: bold;">
    
    <!-- App Title / Logo + Toggle Button -->
    <div class="sidebar-header p-3 bg-primary bg-opacity-25 p-2 border-bottom border-secondary d-flex align-items-center justify-content-between">
        <span class="sidebar-text fw-bold fs-5 text-white text-truncate">
            <img src="<?= base_url('logo/jobfairsystem_logo.png') ?>" 
                        alt="e-JobFair Portal Logo" 
                        class="img-fluid" 
                        style="max-height: 80px; width: auto;"></span>
        <button type="button" class="btn btn-sm text-black p-0 border-0 shadow-none" id="sidebarToggle" title="Toggle Sidebar">
            <i class="bi bi-list fs-3"></i>
        </button>
    </div>

    <!-- User Profile Badge -->
    <div class="sidebar-user p-3 bg-primary bg-opacity-25 border-bottom border-secondary small">
        <div class="sidebar-text fw-bold text-capitalize text-black fs-6">
            <?= esc(session()->get('display_name')) ?> 
            <span class="badge bg-info ms-1"><?= esc(session()->get('role')) ?></span>
        </div>
        <div class="sidebar-icon-only text-center d-none" title="<?= esc(session()->get('display_name')) ?>">
            <i class="bi bi-person-circle fs-5"></i>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="sidebar-nav nav nav-pills flex-column px-2 py-3 flex-grow-1 bg-primary bg-opacity-25">
        <?php if (session()->get('role') === 'Administrator'): ?>
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link text-black d-flex align-items-center mb-1 <?= url_is('admin/dashboard*') ? 'active' : '' ?>" title="Dashboard">
                <i class="bi bi-speedometer2"></i> 
                <span class="sidebar-text ms-2">Dashboard</span>
            </a>
        <?php endif; ?>
        
        <?php if (session()->get('role') === 'Staff' || session()->get('role') === 'User'): ?>
            <a href="<?= base_url('user/dashboard') ?>" class="nav-link text-black d-flex align-items-center mb-1 <?= url_is('user/dashboard*') ? 'active' : '' ?>" title="Dashboard">
                <i class="bi bi-speedometer2"></i> 
                <span class="sidebar-text ms-2">Dashboard</span>
            </a>
            <a href="<?= base_url('employer') ?>" class="nav-link text-black d-flex align-items-center mb-1 <?= url_is('employer*') ? 'active' : '' ?>" title="Dashboard">
            <i class="bi bi-people"></i> 
            <span class="sidebar-text ms-2">Employers</span>
            </a>
            <a href="<?= base_url('user/application') ?>" class="nav-link text-black d-flex align-items-center mb-1 <?= url_is('jobfair_application*') ? 'active' : '' ?>" title="Dashboard">
                <i class="bi bi-file-earmark-plus"></i> 
                <span class="sidebar-text ms-2">Application</span>
            </a>
        <?php endif; ?>
        
        <?php if (session()->get('role') === 'Administrator'): ?>
        <a href="<?= base_url('applications') ?>" class="nav-link text-black d-flex align-items-center mb-1 <?= url_is('applications*') ? 'active' : '' ?>" title="Applications">
            <i class="bi bi-file-earmark-text"></i> 
            <span class="sidebar-text ms-2">Applications</span>
        </a>

        <!-- ADMIN-ONLY RESTRICTION -->
        
            <div class="sidebar-section-title px-3 pt-3 pb-1 text-uppercase text-secondary fw-bold sidebar-text" style="font-size: 0.75rem;">
                Admin Controls
            </div>
            <hr class="sidebar-divider d-none my-2 border-secondary">

            <a href="<?= base_url('admin/account') ?>" class="nav-link text-black d-flex align-items-center mb-1 <?= url_is('admin/account*') ? 'active' : '' ?>" title="Manage Users">
                <i class="bi bi-people"></i> 
                <span class="sidebar-text ms-2">Manage Accounts</span>
            </a>

            <a href="<?= base_url('admin/reports') ?>" class="nav-link text-black d-flex align-items-center mb-1 <?= url_is('admin/reports*') ? 'active' : '' ?>" title="Activity Reports">
                <i class="bi bi-graph-up"></i> 
                <span class="sidebar-text ms-2">Activity Reports</span>
            </a>
        <?php endif; ?>

    </div>

    <!-- Footer & Logout -->
    <div class="sidebar-footer border-top bg-primary bg-opacity-25 p-2">
        <a href="<?= base_url('logout') ?>" class="btn btn-outline-primary w-100 text-black d-flex border-0" title="Logout">
            <i class="bi bi-box-arrow-right text-black-50"></i> 
            <span class="sidebar-text ms-1" style="font-weight: bold;">Logout</span>
        </a>
    </div>

</aside>