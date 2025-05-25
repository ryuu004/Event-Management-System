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
    padding: 2rem;
    width: 100%;
    max-width: 700px;
    margin: 0 auto;
    color: #fff;
}

.auth-title {
    text-align: center;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
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
    padding: 0.6rem 1rem;
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
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.auth-btn {
    background: linear-gradient(90deg, #7ed6ff, #e056fd);
    border: none;
    border-radius: 12px;
    color: #fff;
    font-weight: 600;
    padding: 0.8rem 1.5rem;
    width: 100%;
    margin-top: 0.5rem;
}

.auth-btn:hover {
    box-shadow: 0 5px 15px rgba(224, 86, 253, 0.4);
}

.auth-link {
    color: #7ed6ff;
    text-decoration: none;
}

.auth-link:hover {
    color: #e056fd;
}

.alert {
    background: rgba(220, 53, 69, 0.2);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: #fff;
}

.student-number-info {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.6);
    margin-top: 0.25rem;
}

.form-group {
    margin-bottom: 0.75rem;
}

body.auth-no-scroll {
    overflow: hidden !important;
}
</style>

<div class="auth-page">
    <div class="auth-container">
        <h2 class="auth-title">Create Account</h2>
        <form id="registerForm" onsubmit="handleRegister(event)">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" required>
                    </div>
                    <div class="form-group">
                        <label for="student_number" class="form-label">Student Number</label>
                        <input type="text" pattern="\d{9}" minlength="9" maxlength="9" class="form-control" id="student_number" name="student_number" placeholder="Enter your 9-digit student number" required>
                        <div class="student-number-info">Must be exactly 9 digits</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Choose a strong password" required>
                    </div>
                    <button type="submit" class="auth-btn">Create Account</button>
                    <p class="text-center mt-3 mb-0">
                        Already have an account? <a href="/endama2/auth/login" class="auth-link">Login here</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
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
            // Show success message with SweetAlert2 if available, otherwise use regular alert
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful!',
                    text: 'Please login with your new account.',
                    confirmButtonText: 'Go to Login',
                    confirmButtonColor: '#7ed6ff',
                    background: 'rgba(24, 28, 58, 0.95)',
                    color: '#fff'
                }).then(() => {
                    window.location.href = '/endama2/auth/login';
                });
            } else {
                alert('Registration successful! Please login.');
                window.location.href = '/endama2/auth/login';
            }
        } else {
            // Show error message
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    text: data.error || 'An error occurred during registration.',
                    confirmButtonColor: '#7ed6ff',
                    background: 'rgba(24, 28, 58, 0.95)',
                    color: '#fff'
                });
            } else {
                alert(data.error || 'Registration failed');
            }
        }
    } catch (error) {
        console.error('Registration error:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred. Please try again.',
                confirmButtonColor: '#7ed6ff',
                background: 'rgba(24, 28, 58, 0.95)',
                color: '#fff'
            });
        } else {
            alert('An error occurred. Please try again.');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('auth-no-scroll');
});
</script> 