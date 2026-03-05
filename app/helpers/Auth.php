<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/ApiResponse.php';

class Auth
{
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin(): bool
    {
        return self::isLoggedIn() && ($_SESSION['role'] ?? '') === 'admin';
    }

    public static function isCustomer(): bool
    {
        return self::isLoggedIn() && ($_SESSION['role'] ?? '') === 'customer';
    }

    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Require the user to be logged in. Returns JSON 401 if not.
     */
    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            ApiResponse::error('Authentication required.', 401);
        }
        // Check session timeout (30 minutes)
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
            self::logout();
            ApiResponse::error('Session expired. Please log in again.', 401);
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    /**
     * Require admin role. Returns JSON 403 if not.
     */
    public static function requireAdmin(): void
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            ApiResponse::error('Forbidden. Admin access required.', 403);
        }
    }

    /**
     * Set session data after successful login.
     */
    public static function login(int $userId, string $role, string $fullName): void
    {
        $_SESSION['user_id'] = $userId;
        $_SESSION['role']    = $role;
        $_SESSION['name']    = $fullName;
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    public static function logout(): void
    {
        // clear session securely
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }
}