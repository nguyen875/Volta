<?php
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public static function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            return;
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($email === '' || $password === '') {
            $_SESSION['auth_error'] = 'Email and password required';
            header("Location: /volta/public/login");
            exit;
        }
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user->getPassword())) {
            $_SESSION['auth_error'] = 'Invalid credentials';
            header("Location: /volta/public/login");
            exit;
        }
        // set session
        $_SESSION['UID'] = $user->getId();
        $_SESSION['Role'] = $user->getRole();
        $_SESSION['Name'] = $user->getUsername();
        // redirect based on role
        if ($user->getRole() === 'Admin') {
            header("Location: /volta/public/users");
        } else {
            header("Location: /volta/public/home");
        }
        exit;
    }

    public static function handleSignup()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            return;
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        if ($username === '' || $email === '' || $password === '') {
            $_SESSION['auth_error'] = 'Name, email and password required';
            header("Location: /volta/public/signup");
            exit;
        }
        if ($password !== $confirm) {
            $_SESSION['auth_error'] = 'Passwords do not match';
            header("Location: /volta/public/signup");
            exit;
        }
        // Force role Customer inside User::createCustomer
        $res = User::createCustomer($username, $email, $password);
        if (!$res['success']) {
            $_SESSION['auth_error'] = $res['error'] ?? 'Signup failed';
            header("Location: /volta/public/signup");
            exit;
        }
        $user = $res['user'];
        $_SESSION['UID'] = $user->getId();
        $_SESSION['Role'] = $user->getRole();
        $_SESSION['Name'] = $user->getUsername();
        header("Location: /volta/public/home");
        exit;
    }
}
