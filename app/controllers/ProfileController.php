<?php
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../dao/CustomerDAO.php';

class ProfileController
{
    private $customerDAO;

    public function __construct()
    {
        $this->customerDAO = new CustomerDAO();
    }

    public function index()
    {
        Auth::requireLogin();

        // Get customer info
        $customer = $this->customerDAO->getByUserId($_SESSION['UID']);

        include __DIR__ . '/../views/profile/edit.php';
    }

    public function update()
    {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $phoneNum = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');

            $success = $this->customerDAO->updateInfo($_SESSION['UID'], $phoneNum, $address);

            if ($success) {
                $_SESSION['success'] = 'Profile updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update profile';
            }

            header('Location: /volta/public/profile');
            exit;
        }
    }
}
