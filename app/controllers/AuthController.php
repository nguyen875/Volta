<?php
// app/controllers/AuthController.php

require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../helpers/ApiResponse.php';
require_once __DIR__ . '/../services/UserService.php';

class AuthController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * POST /api/login
     * Body: { email, password }
     */
    public function login(): void
    {
        $data = ApiResponse::body();
        $email    = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if ($email === '' || $password === '') {
            ApiResponse::error('Email and password are required.', 422);
        }

        $user = $this->userService->authenticate($email, $password);
        if (!$user) {
            ApiResponse::error('Invalid credentials.', 401);
        }

        Auth::login($user->id, 'customer', $user->fullName);

        ApiResponse::success([
            'user' => ApiResponse::dto($user),
        ], 'Login successful.');
    }

    /**
     * POST /api/signup
     * Body: { email, password, confirm_password, full_name, phone }
     */
    public function signup(): void
    {
        $data = ApiResponse::body();

        $email    = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $confirm  = $data['confirm_password'] ?? '';
        $fullName = trim($data['full_name'] ?? '');
        $phone    = trim($data['phone'] ?? '');

        if ($email === '' || $password === '') {
            ApiResponse::error('Email and password are required.', 422);
        }
        if ($password !== $confirm) {
            ApiResponse::error('Passwords do not match.', 422);
        }

        try {
            $userId = $this->userService->create([
                'email'     => $email,
                'password'  => $password,
                'full_name' => $fullName,
                'phone'     => $phone,
            ]);

            $user = $this->userService->getById($userId);
            Auth::login($userId, 'customer', $fullName);

            ApiResponse::success([
                'user' => $user ? ApiResponse::dto($user) : ['id' => $userId],
            ], 'Account created successfully.', 201);

        } catch (\InvalidArgumentException $e) {
            ApiResponse::error($e->getMessage(), 422);
        } catch (\RuntimeException $e) {
            ApiResponse::error($e->getMessage(), 409);
        }
    }

    /**
     * POST /api/logout
     */
    public function logout(): void
    {
        Auth::logout();
        ApiResponse::success(null, 'Logged out successfully.');
    }

    /**
     * GET /api/me
     */
    public function me(): void
    {
        Auth::requireLogin();

        $user = $this->userService->getById(Auth::userId());
        if (!$user) {
            ApiResponse::error('User not found.', 404);
        }

        ApiResponse::success([
            'user' => ApiResponse::dto($user),
        ]);
    }
}
