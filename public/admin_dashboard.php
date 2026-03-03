<?php
require_once __DIR__ . '/../app/helpers/Auth.php';
Auth::requireAdmin();
?>
<!doctype html>
<h1>Admin Dashboard</h1>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['Name'] ?? 'Admin'); ?></p>
<p><a href="/volta/public/index.php">Home</a> | <a href="/volta/public/logout.php">Logout</a></p>