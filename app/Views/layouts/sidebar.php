<div style="width: 250px; min-height: 100vh; background-color: #2c3e50; color: white; display: flex; flex-direction: column; position: fixed; left: 0; top: 0; bottom: 0;">
    
    <!-- App Title / Logo -->
    <div style="padding: 20px; background-color: #1a252f; font-weight: bold; font-size: 1.1rem; border-bottom: 1px solid #34495e;">
        Job Fair System
    </div>

    <!-- User Details Section -->
    <div style="padding: 15px 20px; background-color: #34495e; font-size: 0.85rem; border-bottom: 1px solid #2c3e50;">
        <div style="font-weight: bold; font-size: 0.95rem; text-transform: capitalize;"><?= esc(session()->get('display_name')) ?></div>
        <div style="opacity: 0.8; margin-top: 2px;"><span style="color: #2ecc71; font-weight: bold;"><?= esc(session()->get('role')) ?></span></div>
    </div>

    <!-- Navigation Links -->
    <div style="display: flex; flex-direction: column; padding-top: 10px; flex-grow: 1;">
        
        <!-- General Links (For All Roles) -->
        <a href="<?= base_url('dashboard') ?>" style="padding: 12px 20px; color: #ecf0f1; text-decoration: none; transition: 0.2s;" onmouseover="this.style.backgroundColor='#34495e'" onmouseout="this.style.backgroundColor='transparent'">
            Dashboard
        </a>

        <a href="<?= base_url('applications') ?>" style="padding: 12px 20px; color: #ecf0f1; text-decoration: none; transition: 0.2s;" onmouseover="this.style.backgroundColor='#34495e'" onmouseout="this.style.backgroundColor='transparent'">
            Applications
        </a>
        <a href="<?= base_url('employers') ?>" style="padding: 12px 20px; color: #ecf0f1; text-decoration: none; transition: 0.2s;" onmouseover="this.style.backgroundColor='#34495e'" onmouseout="this.style.backgroundColor='transparent'">
            Employers
        </a>
        <a href="<?= base_url('reports') ?>" style="padding: 12px 20px; color: #ecf0f1; text-decoration: none; transition: 0.2s;" onmouseover="this.style.backgroundColor='#34495e'" onmouseout="this.style.backgroundColor='transparent'">
            Job Fair Reports
        </a>
        <!-- ADMIN-ONLY RESTRICTION -->
        <?php if (session()->get('role') === 'Administrator'): ?>
            <div style="padding: 12px 20px 5px 20px; font-size: 0.75rem; color: #95a5a6; text-transform: uppercase; font-weight: bold; margin-top: 10px;">
                Admin Controls
            </div>

            <a href="<?= base_url('admin/users') ?>" style="padding: 12px 20px; color: #ecf0f1; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.backgroundColor='#34495e'" onmouseout="this.style.backgroundColor='transparent'">
                Manage Users
            </a>

            <a href="<?= base_url('admin/reports') ?>" style="padding: 12px 20px; color: #ecf0f1; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.backgroundColor='#34495e'" onmouseout="this.style.backgroundColor='transparent'">
                Activity Reports
            </a>
        <?php endif; ?>

    </div>

    <!-- Logout Link (Fixed at Bottom) -->
    <div style="border-top: 1px solid #34495e;">
        <a href="<?= base_url('logout') ?>" style="display: block; padding: 15px 20px; color: #ecf0f1; text-decoration: none; font-weight: bold;" onmouseover="this.style.backgroundColor='#34495e'" onmouseout="this.style.backgroundColor='transparent'">
            Logout
        </a>
    </div>

</div>