<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPCC EVENTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <style>
        html, body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            padding-top: 76px;
            background: #f8f9fa;
            color: #333;
        }

        .navbar-glass {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
            border-bottom: 1px solid #eaeaea;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            color: #2c3e50 !important;
        }
        
        .navbar-brand:hover {
            text-decoration: none !important;
        }
        
        .navbar-nav .nav-link {
            color: #4a5568 !important;
            font-weight: 500;
            margin-right: 8px;
            transition: color 0.2s;
        }
        
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
            color: #7c3aed !important;
        }

        /* Search form styles */
        .search-form {
            margin-right: 1rem !important;
        }
        
        .navbar-search {
            min-width: 220px;
            width: 220px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0 18px;
            background: #fff;
            color: #333 !important;
            font-size: 0.95rem;
            line-height: 40px;
        }
        
        .navbar-search:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
            outline: none;
        }
        
        .navbar-search::placeholder {
            color: #a0aec0;
        }
        
        .navbar .btn-primary {
            background: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: #fff;
            height: 40px;
            padding: 0 20px;
            font-size: 0.95rem;
            line-height: 40px;
            transition: all 0.3s ease;
        }
        
        .navbar .btn-primary:hover {
            background: linear-gradient(135deg, rgb(67, 56, 202) 0%, rgb(126, 34, 206) 100%);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .event-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .event-card .card-body {
            background: #ffffff;
        }
        
        .auth-container {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            padding: 2rem;
            max-width: 400px;
            margin: 2rem auto;
        }

        /* Form controls */
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
            border-color: #7c3aed;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, rgb(67, 56, 202) 0%, rgb(126, 34, 206) 100%);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-success {
            background: #2ecc71;
            border: none;
        }

        .btn-success:hover {
            background: #27ae60;
        }

        .btn-danger {
            background: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        /* Page section headers */
        .section-title {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        /* Badge styling */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 6px;
        }

        /* Custom role badges */
        .role-badge {
            padding: 2px 10px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 500;
            display: inline-block;
        }

        .role-organizer {
            background: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
            color: white;
        }

        .role-participant {
            background-color: #2ecc71;
            color: white;
        }

        /* Text color for primary elements */
        .text-primary {
            color: #7c3aed !important;
        }

        /* Links */
        a {
            color: #7c3aed;
            text-decoration: none;
        }

        a:hover {
            color: #6d28d9;
            text-decoration: underline;
        }

        /* SweetAlert2 custom styles */
        .swal2-popup {
            border-radius: 18px !important;
            padding-top: 1.5rem !important;
        }
        .swal2-title {
            font-weight: 700;
            background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.7rem;
        }
        .swal2-confirm {
            background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%) !important;
            border: none !important;
            color: #fff !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 8px rgba(124,58,237,0.08) !important;
        }
        .swal2-cancel {
            border-radius: 8px !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-glass">
        <div class="container">
            <a class="navbar-brand" href="/endama2/events">SPCC EMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/events') !== false && !strpos($_SERVER['REQUEST_URI'], '/my-events') && !strpos($_SERVER['REQUEST_URI'], '/manage') && !strpos($_SERVER['REQUEST_URI'], '/participants') ? 'active' : '' ?>" href="/endama2/events">All Events</a>
                    </li>
                    <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/my-events') !== false ? 'active' : '' ?>" href="/endama2/events/my-events">My Events</a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'organizer'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/manage') !== false ? 'active' : '' ?>" href="/endama2/events/manage">Manage Events</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <form class="d-flex search-form" role="search" onsubmit="event.preventDefault(); filterEvents();">
                    <input class="form-control navbar-search" type="search" id="searchEvents" placeholder="Search events..." aria-label="Search" onkeyup="filterEvents()">
                </form>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/endama2/auth/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="/endama2/auth/register">Register</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item d-flex align-items-center ms-2">
                        <div class="text-center me-3" style="min-width:90px;">
                            <span style="font-weight:600; color:#2c3e50; font-size:1.08rem; line-height:1; display:block;">
                                <?= htmlspecialchars(isset($_SESSION['user']['first_name']) && $_SESSION['user']['first_name'] ? $_SESSION['user']['first_name'] : 'User') ?>
                            </span>
                            <?php
                                $role = isset($_SESSION['user']['role']) ? strtolower($_SESSION['user']['role']) : 'participant';
                                $roleLabel = ucfirst($role);
                                $roleBadgeClass = $role === 'organizer' ? 'role-organizer' : 'role-participant';
                            ?>
                            <span class="role-badge <?= $roleBadgeClass ?>">
                                <?= htmlspecialchars($roleLabel) ?>
                            </span>
                        </div>
                        <a class="btn btn-outline-secondary btn-sm" href="#" id="logoutLink" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?= $content ?>
    </div>

    <footer class="bg-white mt-5 py-4 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; <?= date('Y') ?> SPCC Events. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-decoration-none text-muted me-3">Terms</a>
                    <a href="#" class="text-decoration-none text-muted me-3">Privacy</a>
                    <a href="#" class="text-decoration-none text-muted">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
            if (confirmLogoutBtn) {
                confirmLogoutBtn.addEventListener('click', function() {
                    window.location.href = '/endama2/auth/logout';
                });
            }
        });
    </script>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <span class="me-2" style="font-size:2.2rem;color:#7c3aed;"><i class="fas fa-sign-out-alt"></i></span>
                        <h5 class="modal-title" id="logoutModalLabel" style="font-weight:700; color:#2c3e50;">Logout Confirmation</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <p class="mb-0" style="color:#555;">Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:8px;">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmLogoutBtn" style="border-radius:8px; background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%); border:none;">Yes, Logout</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 