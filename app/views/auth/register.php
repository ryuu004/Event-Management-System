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
    padding: 2rem;
    width: 100%;
    max-width: 500px;
    margin: 76px auto 0;
    color: #333;
}

.auth-container::-webkit-scrollbar {
    width: 8px;
}

.auth-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.auth-container::-webkit-scrollbar-thumb {
    background: #c7c7c7;
    border-radius: 4px;
}

.auth-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.auth-title {
    text-align: center;
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 1.8rem;
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
    padding: 0.7rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    height: 45px;
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
    margin-bottom: 0.5rem;
    font-size: 1rem;
    display: block;
}

.create-account-btn {
    background: linear-gradient(45deg, #6c5ce7, #a29bfe);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    padding: 0.9rem 1.5rem;
    width: 100%;
    margin-top: 1.2rem;
    font-size: 1.1rem;
    height: 48px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.create-account-btn:hover {
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

.form-group {
    margin-bottom: 1rem;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -8px;
}

.form-col {
    flex: 0 0 50%;
    max-width: 50%;
    padding: 0 8px;
}

.student-number-info {
    font-size: 0.75rem;
    color: #718096;
    margin-top: 0.25rem;
}

/* SweetAlert2 center override */
.swal2-container {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 0 !important;
    position: fixed !important;
    z-index: 1060 !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    background-color: rgba(0, 0, 0, 0.15) !important;
}

.swal2-popup {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    text-align: center !important;
    padding: 2.5rem 2rem !important;
    background: #fff !important;
}

.swal2-title {
    margin-bottom: 1rem !important;
    line-height: 1.3 !important;
}

.swal2-html-container {
    margin: 0.5rem 0 1.5rem !important;
    line-height: 1.5 !important;
}

.swal2-actions {
    margin-top: 1.5rem !important;
    width: 100% !important;
}

.custom-swal-button {
    min-width: 120px !important;
}

@media (max-width: 768px) {
    .form-col {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .auth-container {
        padding: 1.5rem;
    }
    
    .auth-title {
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }
}

.text-center.mt-4 {
    margin-top: 1.2rem !important;
}
</style>

<div class="auth-page">
    <div class="auth-container">
        <h2 class="auth-title">Create Account</h2>
        <form id="registerForm" onsubmit="handleRegister(event)">
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="SPCC email address" required>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Create password" required>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="student_number" class="form-label">Student Number</label>
                        <input type="text" pattern="\d{9}" minlength="9" maxlength="9" class="form-control" id="student_number" name="student_number" placeholder="9-digit number" required>
                        <div class="student-number-info">Must be exactly 9 digits</div>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="create-account-btn">Create Account</button>
            
            <p class="text-center mt-4 mb-0">
                Already have an account? <a href="/endama2/auth/login" class="auth-link">Login here</a>
            </p>
        </form>
    </div>
</div>

<script>
async function handleRegister(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Frontend SPCC email validation
    const email = form.email.value.trim();
    const password = form.password.value;
    const confirmPassword = form.confirm_password.value;
    const spccPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]*spcc\.edu\.ph$/;
    if (!spccPattern.test(email)) {
        showSweetAlert('error', 'Invalid Email', 'Please use your SPCC email address (e.g. tahari_rhyio@spcc.edu.ph).');
        return;
    }
    if (password !== confirmPassword) {
        showSweetAlert('error', 'Password Mismatch', 'Passwords do not match. Please re-enter.');
        return;
    }

    try {
        const response = await fetch('/endama2/auth/register', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        
        if (response.ok) {
            // Show success message
            showSweetAlert('success', 'Registration Successful!', 'Please login with your new account.', true);
        } else {
            // Show error message
            showSweetAlert('error', 'Registration Failed', data.error || 'An error occurred during registration.');
        }
    } catch (error) {
        console.error('Registration error:', error);
        showSweetAlert('error', 'Error', 'An error occurred. Please try again.');
    }
}

// Helper function for SweetAlert2 modals with consistent styling
function showSweetAlert(icon, title, text, isSuccess = false) {
    if (typeof Swal === 'undefined') {
        alert(text);
        if (isSuccess) window.location.href = '/endama2/auth/login';
        return;
    }
    
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
        confirmButtonText: isSuccess ? 'Go to Login' : 'OK',
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            popup: 'custom-swal-popup',
            title: 'custom-swal-title',
            confirmButton: 'custom-swal-button',
            htmlContainer: 'custom-swal-text',
            actions: 'swal2-actions'
        },
        buttonsStyling: false,
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    }).then((result) => {
        if (isSuccess && result.isConfirmed) {
            window.location.href = '/endama2/auth/login';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .custom-swal-popup {
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 26rem;
            max-width: 90vw;
            text-align: center;
        }
        .custom-swal-title {
            color: #2d3748;
            font-size: 1.6rem;
            font-weight: 600;
            margin: 1rem 0 !important;
            padding: 0;
            line-height: 1.3;
        }
        .custom-swal-text {
            color: #4a5568;
            font-size: 1.1rem;
            margin: 0.5rem 0 1.5rem !important;
            padding: 0;
            line-height: 1.5;
        }
        .custom-swal-button {
            background: linear-gradient(45deg, #6c5ce7, #a29bfe);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
            padding: 0.8rem 1.8rem;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0;
            min-width: 120px;
        }
        .custom-swal-button:hover {
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
            transform: translateY(-2px);
        }
        .swal2-icon {
            border-color: #6c5ce7 !important;
            color: #6c5ce7 !important;
            margin: 1.5rem auto 1rem !important;
        }
        .swal2-actions {
            margin-top: 1.5rem !important;
            width: 100% !important;
            justify-content: center !important;
        }
    `;
    document.head.appendChild(style);
});
</script> 