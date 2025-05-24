<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .event-card {
            transition: transform 0.2s;
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .auth-container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/endama2/events">Events</a>
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
                <ul class="navbar-nav">
                    <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/endama2/auth/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/endama2/auth/register">Register</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/endama2/auth/logout">Logout</a>
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
    </script>
</body>
</html> 