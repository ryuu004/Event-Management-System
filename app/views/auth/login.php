<!-- Add custom styles for auth pages -->
<style>
.auth-page {
    min-height: 100vh;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f7fa;
    padding: 0;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
}

.auth-container {
    background: #fff;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    border-radius: 16px;
    padding: 2.5rem 3.5rem;
    width: 100%;
    max-width: 500px;
    margin: 76px auto 0;
    color: #333;
}

.auth-title {
    text-align: center;
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 2.5rem;
    color: #6c5ce7;
    background: linear-gradient(45deg, #6c5ce7, #a29bfe);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.form-control {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #333;
    padding: 0.9rem 1.2rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    height: 50px;
    width: 100%;
}

.form-control:focus {
    background: #fff;
    border-color: #6c5ce7;
    box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1);
    outline: none;
}

.form-control::placeholder {
    color: #a0aec0;
}

.form-label {
    color: #2d3748;
    font-weight: 500;
    margin-bottom: 1rem;
    font-size: 1rem;
    display: block;
}

.auth-btn {
    background: linear-gradient(45deg, #6c5ce7, #a29bfe);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    padding: 0.9rem 1.5rem;
    width: 100%;
    margin-top: 2rem;
    font-size: 1.1rem;
    height: 55px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.auth-btn:hover {
    box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
    transform: translateY(-2px);
}

.auth-link {
    color: #6c5ce7;
    text-decoration: none;
    transition: color 0.2s;
    font-weight: 500;
}

.auth-link:hover {
    color: #5d4aeb;
    text-decoration: underline;
}

.alert {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.2);
    color: #dc3545;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.mb-4 {
    margin-bottom: 2rem !important;
}

body.auth-no-scroll {
    overflow: hidden !important;
}

.text-center.mt-4 {
    margin-top: 2rem !important;
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