<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPCC EVENTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <style>
        html, body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        body {
            padding-top: 76px;
            background: linear-gradient(135deg, rgba(24, 28, 58, 0.95) 0%, rgba(24, 28, 58, 0.95) 100%) fixed;
        }

        .navbar-glass {
            background: rgba(24, 28, 58, 0.95);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 0 0 24px 24px;
            border-bottom: 1.5px solid rgba(255,255,255,0.08);
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.6rem;
            letter-spacing: 1px;
            color: #7ed6ff !important;
            text-shadow: 0 2px 8px rgba(30, 55, 153, 0.3);
        }
        
        .navbar-nav .nav-link {
            color: #dff9fb !important;
            font-weight: 500;
            margin-right: 8px;
        }
        
        .navbar-nav .nav-link:hover {
            color: #fff !important;
            background: linear-gradient(90deg, #7ed6ff 0%, #e056fd 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Search form styles */
        .search-form {
            margin-right: 1rem !important;
        }
        
        .navbar-search {
            min-width: 220px;
            width: 220px;
            height: 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0 18px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff !important;
            font-size: 0.95rem;
            line-height: 40px;
        }
        
        .navbar-search:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: none;
            outline: none;
        }
        
        .navbar-search::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .navbar .btn-primary {
            background: linear-gradient(90deg, #7ed6ff 0%, #e056fd 100%);
            border: none;
            border-radius: 20px;
            font-weight: 600;
            color: #fff;
            height: 40px;
            padding: 0 20px;
            font-size: 0.95rem;
            line-height: 40px;
        }
        
        .event-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        }

        .event-card .card-body {
            background: rgba(24, 28, 58, 0.95);
        }
        
        .auth-container {
            background: rgba(24, 28, 58, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 24px;
            padding: 2rem;
            max-width: 400px;
            margin: 2rem auto;
        }

        /* Override Bootstrap form control focus */
        .form-control:focus {
            box-shadow: none;
            border-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-glass">
        <div class="container">
            <a class="navbar-brand" href="/endama2/events">SPCC EVENTS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/endama2/events">All Events</a>
                    </li>
                    <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/endama2/events/my-events">My Events</a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'organizer'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/endama2/events/manage">Manage Events</a>
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
                        <a class="nav-link" href="/endama2/auth/register">Register</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item d-flex align-items-center ms-2">
                        <div class="text-center me-3" style="min-width:90px;">
                            <span style="font-weight:600; color:#7ed6ff; font-size:1.08rem; line-height:1; display:block;">
                                <?= htmlspecialchars(isset($_SESSION['user']['first_name']) && $_SESSION['user']['first_name'] ? $_SESSION['user']['first_name'] : 'User') ?>
                            </span>
                            <?php
                                $role = isset($_SESSION['user']['role']) ? strtolower($_SESSION['user']['role']) : 'participant';
                                $roleLabel = ucfirst($role);
                                $roleBg = $role === 'organizer'
                                    ? 'background:linear-gradient(90deg,#7ed6ff,#e056fd);'
                                    : 'background:linear-gradient(90deg,#43e97b,#38f9d7);';
                            ?>
                            <span style="font-size:0.72rem; color:#fff; <?= $roleBg ?>padding:1.5px 9px;border-radius:8px;display:inline-block;margin-top:3px;letter-spacing:0.5px;">
                                <?= htmlspecialchars($roleLabel) ?>
                            </span>
                        </div>
                        <a class="nav-link" href="#" id="logoutLink">Logout</a>
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

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to logout?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <a href="/endama2/auth/logout" class="btn btn-danger" id="confirmLogoutBtn">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check authentication status and update UI
        function updateAuthUI() {
            let token = null;
            let user = null;

            try {
                token = localStorage.getItem('token');
                user = JSON.parse(localStorage.getItem('user'));
            } catch (e) {
                console.error('Error accessing storage:', e);
                // Try cookies as fallback
                token = getCookie('token');
                const userStr = getCookie('user');
                if (userStr) {
                    try {
                        user = JSON.parse(userStr);
                    } catch (e) {
                        console.error('Error parsing user cookie:', e);
                    }
                }
            }

            const isAuthenticated = !!token && !!user;
            
            // Update UI elements
            document.querySelectorAll('.auth-required').forEach(el => {
                el.style.display = isAuthenticated ? 'block' : 'none';
            });
            
            document.querySelectorAll('.auth-not-required').forEach(el => {
                el.style.display = isAuthenticated ? 'none' : 'block';
            });
        }

        // Helper function to get cookies
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }

        // Handle logout
        function handleLogout(e) {
            e.preventDefault();
            
            // Clear localStorage
            try {
                localStorage.removeItem('token');
                localStorage.removeItem('user');
            } catch (e) {
                console.error('Error clearing storage:', e);
            }
            
            // Clear cookies
            document.cookie = 'token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            document.cookie = 'user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            
            // Redirect to login
            window.location.href = '/endama2/auth/login';
        }

        // Update UI on page load
        document.addEventListener('DOMContentLoaded', updateAuthUI);

        document.addEventListener('DOMContentLoaded', function() {
            var logoutLink = document.getElementById('logoutLink');
            if (logoutLink) {
                logoutLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    var modal = new bootstrap.Modal(document.getElementById('logoutModal'));
                    modal.show();
                });
            }
        });
    </script>
</body>
</html> 