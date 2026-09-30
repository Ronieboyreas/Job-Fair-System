<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-JobFair Portal</title>
    <link rel="icon" href="<?= base_url('logo/jobfairsystem_icon.ico') ?>">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .navbar-brand img {
            max-height: 45px;
            object-fit: contain;
        }
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 100px 0 80px 0;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-2">
        <div class="container">
            <!-- Left Side Logo -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
                <img src="<?= base_url('logo/jobfairsystem_logo.png') ?>" alt="e-JobFair Portal Logo">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Navigation Links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="<?= base_url('index') ?>">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?= base_url('about') ?>">
                            About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?= base_url('contact') ?>">
                            Contact
                        </a>
                    </li>
                </ul>

                <!-- Auth Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <a href="<?= base_url('login') ?>" class="btn btn-outline-primary px-3 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> LogIn
                    </a>
                    <a href="<?= base_url('register') ?>" class="btn btn-primary px-3 fw-semibold">
                        <i class="bi bi-person-plus me-1"></i> Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">Connecting Employers and Jobseekers Effortlessly</h1>
            <p class="lead mb-4">Discover job fair events, apply seamlessly, and keep track of your career opportunities in one place.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg text-primary fw-bold px-4">Get Started</a>
                <a href="<?= base_url('login') ?>" class="btn btn-outline-light btn-lg fw-bold px-4">Sign In</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-top py-4 text-center text-muted mt-auto">
        <div class="container">
            <small>&copy; 2026 e-JobFair Portal. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>