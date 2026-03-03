<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AuthController::handleSignup();
    exit;
}
session_start();
$error = $_SESSION['auth_error'] ?? null;
unset($_SESSION['auth_error']);
?>
<!doctype html>
<form method="post" action="/volta/public/signup.php">
    <h2>Sign Up (Customer)</h2>
    <?php if ($error)
        echo "<div style='color:red;'>" . htmlspecialchars($error) . "</div>"; ?>
    <label>Name: <input type="text" name="username" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <label>Confirm: <input type="password" name="confirm_password" required></label><br>
    <button type="submit">Create Account</button>
    <p>Already have an account? <a href="/volta/public/login.php">Login</a></p>
</form>