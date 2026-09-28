<!-- Top Header Bar -->
        <header class="header-navbar sticky-top py-2 px-4 mb-4">
            <div class="d-flex align-items-center justify-content-between">
                
                <!-- Brand / Page Title -->
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('logo/jobfairsystem_logo.png') ?>" 
                         alt="e-JobFair Portal Logo" 
                         class="img-fluid" 
                         style="max-height: 48px; width: auto;">
                </div>

                <!-- Right Side Tools: Clock & User Dropdown -->
                <div class="d-flex align-items-center gap-3">
                    
                    <!-- Live Date & Time Display -->
                    <div class="text-end d-none d-md-block border-end pe-3">
                        <div class="fw-bold text-dark small" id="liveClockTime">--:--:-- --</div>
                        <div class="text-muted small" id="liveClockDate">Loading date...</div>
                    </div>

                    <!-- User Account Popout Menu -->
                    <div class="dropdown">
                        <a href="#" class="user-dropdown-btn d-flex align-items-center gap-2 text-decoration-none text-dark px-2 py-1 rounded-3 dropdown-toggle" id="headerUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: 600;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                            <div class="d-none d-sm-block text-start ms-1">
                                <div class="fw-bold text-dark lh-1 small mb-1">
                                    <?= esc(session()->get('display_name') ?? 'Admin User') ?>
                                </div>
                                <?php if (session()->get('role') === 'Administrator'): ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger py-1 px-2" style="font-size: 0.68rem;">
                                        <?= esc(session()->get('role') ?? 'Administrator') ?>
                                    </span>
                                <?php elseif (session()->get('role') === 'User'): ?>
                                    <span class="badge bg-primary bg-opacity-10 text-primary py-1 px-2" style="font-size: 0.68rem;">
                                        <?= esc(session()->get('role') ?? 'User') ?>
                                    </span>
                                <?php elseif (session()->get('role') == 'Staff'): ?>
                                    <span class="badge bg-info bg-opacity-10 text-info py-1 px-2" style="font-size: 0.68rem;">
                                        <?= esc(session()->get('role') ?? 'Staff') ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>

                        <!-- Dropdown Options Menu -->
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="headerUserDropdown">
                            <li class="px-3 py-2 bg-light border-bottom">
                                <div class="fw-bold text-dark small"><?= esc(session()->get('username')) ?></div>
                                <div class="text-muted small"><?= esc(session()->get('email') ?? 'Administrator') ?></div>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 gap-2 mt-1" href="<?= base_url('admin/account') ?>">
                                    <i class="bi bi-gear text-primary fs-6"></i> Account Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 gap-2 text-danger" href="<?= base_url('logout') ?>">
                                    <i class="bi bi-box-arrow-right fs-6"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </header>