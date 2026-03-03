<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = $_SESSION['auth_error'] ?? null;
unset($_SESSION['auth_error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Book Store</title>
    <link href="/volta/public/css/tailwind.min.css" rel="stylesheet">
    <link href="/volta/public/css/auth.css" rel="stylesheet">
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="/volta/public/image/WebLogo.png" alt="Book Store Logo">
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Join our book community</p>
            </div>

            <?php if ($error): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="/volta/public/signup">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="username" class="form-input" placeholder="Enter your name" required
                        autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Create a password" required
                        minlength="6">
                    <p class="password-hint">Minimum 6 characters</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-input"
                        placeholder="Confirm your password" required>
                </div>

                <button type="submit" class="btn-primary btn-signup">Create Account</button>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="/volta/public/login">Login here</a>
            </div>

            <div class="auth-footer" style="border-top: none; padding-top: 0.5rem;">
                <a href="/volta/public/">← Back to Homepage</a>
            </div>
        </div>
    </div>
</body>

</html>