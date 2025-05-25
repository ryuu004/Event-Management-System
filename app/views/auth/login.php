<!-- Add custom styles for auth pages -->
<style>
.auth-page {
    min-height: calc(100vh - 76px);
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-container {
    background: rgba(24, 28, 58, 0.95);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: 2.5rem;
    width: 100%;
    max-width: 420px;
    margin: 0 auto;
    color: #fff;
    opacity: 0;
    animation: simpleFade 0.3s ease-out forwards;
}

@keyframes simpleFade {
    to {
        opacity: 1;
    }
}

.auth-title {
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    background: linear-gradient(90deg, #7ed6ff, #e056fd);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.form-control {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    color: #fff;
    padding: 0.8rem 1.2rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 0 0.25rem rgba(126, 214, 255, 0.15);
    color: #fff;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.form-label {
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.auth-btn {
    background: linear-gradient(90deg, #7ed6ff, #e056fd);
    border: none;
    border-radius: 12px;
    color: #fff;
    font-weight: 600;
    padding: 0.8rem 1.5rem;
    width: 100%;
    margin-top: 1rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.auth-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(224, 86, 253, 0.4);
}

.auth-link {
    color: #7ed6ff;
    text-decoration: none;
    transition: color 0.2s ease;
}

.auth-link:hover {
    color: #e056fd;
}

.alert {
    background: rgba(220, 53, 69, 0.2);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: #fff;
}

body.auth-no-scroll {
    overflow: hidden !important;
}
</style>

<div class="auth-page">
    <div class="auth-container">
        <h2 class="auth-title">Welcome Back</h2>
        
        <!-- Add error message container -->
        <div id="error-message" class="alert alert-danger" style="display: none;"></div>
        
        <form id="loginForm">
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="auth-btn">Sign In</button>
        </form>
        <p class="text-center mt-4 mb-0">
            Don't have an account? <a href="/endama2/auth/register" class="auth-link">Register here</a>
        </p>
    </div>
</div>

<script>
// After successful login
function handleLoginSuccess(response) {
    // Redirect to main events page
    window.location.href = '/endama2/events';
}

// Handle form submission
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Clear any previous error messages
    const errorDiv = document.getElementById('error-message');
    errorDiv.style.display = 'none';
    
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('/endama2/auth/login', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        console.log('Login response:', data);
        
        if (response.ok) {
            handleLoginSuccess(data);
        } else {
            // Show error message
            errorDiv.textContent = data.error || 'Login failed';
            errorDiv.style.display = 'block';
        }
    } catch (error) {
        console.error('Login error:', error);
        errorDiv.textContent = 'An error occurred. Please try again.';
        errorDiv.style.display = 'block';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('auth-no-scroll');
});
</script> 