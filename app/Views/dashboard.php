<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Job Fair System</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f8f9fa;">

    <!-- INCLUDE THE REUSABLE SIDEBAR -->
    <?= $this->include('layouts/sidebar') ?>

    <!-- MAIN CONTENT AREA (Offset by sidebar width) -->
    <div style="margin-left: 250px; padding: 30px;">
        <h2>Dashboard Overview</h2>
        <p>Welcome back, <strong><?= esc(session()->get('display_name')) ?></strong>!</p>
        
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-top: 20px;">
            <h3>System Status</h3>
            <p>You are logged in as a <strong><?= esc(session()->get('role')) ?></strong> account.</p>
        </div>
    </div>

</body>
</html>