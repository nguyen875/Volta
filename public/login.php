<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AuthController::handleLogin();
    exit;
}
session_start();
$error = $_SESSION['auth_error'] ?? null;
unset($_SESSION['auth_error']);
?>
<!doctype html>
<!-- very minimal form -->
<form method="post" action="/volta/public/login.php">
    <h2>Login</h2>
    <?php if ($error)
        echo "<div style='color:red;'>" . htmlspecialchars($error) . "</div>"; ?>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
    <p>No account? <a href="/volta/public/signup.php">Sign up</a></p>
</form>