<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Auth
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['UID']) && isset($_SESSION['Role']);
    }

    public static function isAdmin()
    {
        return self::isLoggedIn() && $_SESSION['Role'] === 'Admin';
    }

    public static function isCustomer()
    {
        return self::isLoggedIn() && $_SESSION['Role'] === 'Customer';
    }

    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            header("Location: /volta/public/401?reason=login");
            exit;
        }
        // Check session timeout (30 minutes)
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
            self::logout(true); // expired logout
            header("Location: /volta/public/401?reason=expired");
            exit;
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity
    }

    public static function requireAdmin()
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            http_response_code(403);
            header("Location: /volta/public/401?reason=forbidden");
            exit;
        }
    }

    public static function logout($expired = false)
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
        if ($expired) {
            return; // don't redirect, let caller handle
        }
        header("Location: /volta/public/login");
        exit;
    }
}
?>