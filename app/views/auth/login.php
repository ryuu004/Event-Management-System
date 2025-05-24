<div class="auth-container">
    <h2 class="text-center mb-4">Login</h2>
    
    <!-- Add error message container -->
    <div id="error-message" class="alert alert-danger" style="display: none;"></div>
    
    <form id="loginForm">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="text-center mt-3">
        Don't have an account? <a href="/endama2/auth/register">Register here</a>
    </p>
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
</script> 