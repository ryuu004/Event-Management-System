<div class="auth-container">
    <h2 class="text-center mb-4">Register</h2>
    <form id="registerForm" onsubmit="handleRegister(event)">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="">Select a role</option>
                <option value="organizer">Organizer</option>
                <option value="participant">Participant</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <p class="text-center mt-3">
        Already have an account? <a href="/endama2/auth/login">Login here</a>
    </p>
</div>

<script>
async function handleRegister(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('/endama2/auth/register', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        
        if (response.ok) {
            alert('Registration successful! Please login.');
            window.location.href = '/endama2/auth/login';
        } else {
            alert(data.error || 'Registration failed');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    }
}
</script> 