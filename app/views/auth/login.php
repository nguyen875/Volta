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
    <title>Login - Book Store</title>
    <link href="/volta/public/css/tailwind.min.css" rel="stylesheet">
    <link href="/volta/public/css/auth.css" rel="stylesheet">
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="/volta/public/image/WebLogo.png" alt="Book Store Logo">
                <h1 class="auth-title">Welcome Back</h1>
                <p class="auth-subtitle">Login to your account</p>
            </div>

            <?php if ($error): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="/volta/public/login">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="Enter your email" required
                        autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Enter your password"
                        required>
                </div>

                <button type="submit" class="btn-primary">Login</button>
            </form>

            <div class="auth-footer">
                Don't have an account? <a href="/volta/public/signup">Sign up here</a>
            </div>

            <div class="auth-footer" style="border-top: none; padding-top: 0.5rem;">
                <a href="/volta/public/">← Back to Homepage</a>
            </div>
        </div>
    </div>
</body>

</html>