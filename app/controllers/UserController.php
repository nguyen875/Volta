<?php
require_once __DIR__ . '/../services/UserService.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $search = $_GET['search'] ?? '';
        $per_page = isset($_GET['per_page']) ? (int) $_GET['per_page'] : 10;
        $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if (!in_array($per_page, [10, 25, 50])) {
            $per_page = 10;
        }

        $offset = ($current_page - 1) * $per_page;

        $total_records = $this->userService->getTotalCount($search);
        $total_pages = ceil($total_records / $per_page);

        $users = $this->userService->getAllUsers($search, $per_page, $offset);

        $pagination = [
            'current_page' => $current_page,
            'per_page' => $per_page,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'search' => $search
        ];

        require_once __DIR__ . '/../views/admin/users/list.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        include __DIR__ . '/../views/admin/users/form.php';
    }

    public function store()
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'Customer';

            // Validate inputs
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'All fields are required';
                header('Location: /volta/public/users/create');
                exit;
            }

            // Create user with hashed password
            $user = new User(null, $username, $email, $role, $password);

            try {
                require_once __DIR__ . '/../../config/database.php';
                $db = getDB();

                $db->beginTransaction();

                // Insert into LOGIN table with hashed password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO LOGIN (Name, Email, Password, Role) VALUES (?, ?, ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$username, $email, $hashedPassword, $role]);

                $userId = $db->lastInsertId();

                // Insert into role-specific table
                if ($role === 'Admin') {
                    $sql = "INSERT INTO ADMIN (UID) VALUES (?)";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$userId]);
                } else {
                    $sql = "INSERT INTO CUSTOMER (UID, PhoneNum, Address, Status) VALUES (?, NULL, NULL, 'Active')";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$userId]);
                }

                $db->commit();

                $_SESSION['success'] = 'User created successfully';
                header('Location: /volta/public/users');
                exit;

            } catch (Exception $e) {
                $db->rollBack();
                error_log("User creation error: " . $e->getMessage());

                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $_SESSION['error'] = 'Email already exists';
                } else {
                    $_SESSION['error'] = 'Failed to create user: ' . $e->getMessage();
                }

                header('Location: /volta/public/users/create');
                exit;
            }
        }
    }

    public function edit($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $user = $this->userService->getUserById($id);

        if (!$user) {
            $_SESSION['error'] = 'User not found';
            header('Location: /volta/public/users');
            exit;
        }

        include __DIR__ . '/../views/admin/users/form.php';
    }

    public function update($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->userService->updateUser($id, $_POST);
            if ($success) {
                header('Location: /volta/public/users');
                exit;
            }
        }
    }

    public function destroy($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        try {
            $result = $this->userService->deleteUser($id);
            if ($result) {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    http_response_code(200);
                    echo json_encode([
                        'success' => true,
                        'message' => 'User deleted successfully'
                    ]);
                    exit;
                } else {
                    header('Location: /volta/public/users');
                    exit;
                }
            } else {
                throw new Exception('Delete operation failed');
            }
        } catch (Exception $e) {
            error_log("Delete user error: " . $e->getMessage());
            if ($isAjax) {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to delete user: ' . $e->getMessage()
                ]);
                exit;
            } else {
                header('Location: /volta/public/users?error=' . urlencode($e->getMessage()));
                exit;
            }
        }
    }
}
