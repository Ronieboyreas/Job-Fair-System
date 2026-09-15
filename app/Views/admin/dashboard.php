<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Job Fair System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom Sidebar Overrides -->
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css') ?>">
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f8f9fa;">
    <!-- INCLUDE THE REUSABLE SIDEBAR -->
    <?= $this->include('layouts/sidebar') ?>

    <!-- Main Content Area -->

    
    <main class="content-wrapper">
        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <img src="<?= base_url('logo/jobfairsystem_logo.png') ?>" 
                        alt="e-JobFair Portal Logo" 
                        class="img-fluid" 
                        style="max-height: 80px; width: auto;">
                </div>
            </div>

            <!-- Stats Cards Row -->
            <div class="row g-3 mb-4">
                <!-- Total Users -->
                <div class="col-12 col-sm-6 col-xl">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3 text-primary">
                                <i class="bi bi-people-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle text-muted fw-semibold">Total Users</h6>
                                <h3 class="fw-bold text-dark mb-0"><?= number_format($totalUsers ?? 0) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Applications -->
                <div class="col-12 col-sm-6 col-xl">
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

                <!-- Pending -->
                <div class="col-12 col-sm-6 col-xl">
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

                <!-- Approved -->
                <div class="col-12 col-sm-6 col-xl">
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

            </div>

            <!-- Chart Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title fw-bold mb-0">Approved Job Fairs per Month (<?= date('Y') ?>)</h5>
                        </div>
                        <div class="card-body" style="position: relative; height: 350px;">
                            <canvas id="approvedFairsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= base_url('js/sidebar.js') ?>"></script>

    <script>
        const ctx = document.getElementById('approvedFairsChart').getContext('2d');
        const approvedData = <?= json_encode($chartData ?? array_fill(0, 12, 0)) ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Approved Job Fairs',
                    data: approvedData,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#198754',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>