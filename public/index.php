<?php
// filepath: c:\xampp\htdocs\volta\public\index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

function route($pattern, $callback, $methods = ['GET'], $roles = null) {
    global $path, $userRole, $isLoggedIn;
    
    // Check if method matches
    if (!in_array($_SERVER['REQUEST_METHOD'], $methods)) {
        return false;
    }
    
    // Check if role is required and matches
    if ($roles !== null && (!$isLoggedIn || !in_array($userRole, (array)$roles))) {
        return false;
    }
    
    // Check if path matches pattern
    if (preg_match($pattern, $path, $matches)) {
        array_shift($matches); // Remove full match
        call_user_func_array($callback, $matches);
        return true;
    }
    
    return false;
}

function controller($name, $method, ...$args) {
    require_once "../app/controllers/{$name}.php";
    $controller = new $name();
    return $controller->$method(...$args);
}

function view($viewPath) {
    include "../app/views/{$viewPath}.php";
}

// Initialize session activity timestamp
if (!isset($_SESSION['LAST_ACTIVITY'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
}

// Get the request URI
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// Remove the base path if volta is in a subdirectory
$path = str_replace('/volta/public', '', $path);

// Auth Routes (before other routes)
if ($path === '/login') {
    require_once '../app/controllers/AuthController.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        AuthController::handleLogin();
    } else {
        include '../app/views/auth/login.php';
    }
    exit;

} elseif ($path === '/signup') {
    require_once '../app/controllers/AuthController.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        AuthController::handleSignup();
    } else {
        include '../app/views/auth/signup.php';
    }
    exit;

} elseif ($path === '/logout') {
    require_once '../app/helpers/Auth.php';
    Auth::logout();
    exit;

} elseif ($path === '/401') {
    include '../app/views/public/401.php';
    exit;

} elseif ($path === '/profile') {
    require_once '../app/controllers/ProfileController.php';
    $controller = new ProfileController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->update();
    } else {
        $controller->index();
    }
    exit;

    // User CRUD Routes
} elseif ($path === '/users') {
    // List all users
    require_once '../app/controllers/UserController.php';
    $controller = new UserController();
    $controller->index();
    exit;

} elseif ($path === '/users/create') {
    // Show create form
    require_once '../app/controllers/UserController.php';
    $controller = new UserController();
    $controller->create();
    exit;

} elseif ($path === '/users/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store new user
    require_once '../app/controllers/UserController.php';
    $controller = new UserController();
    $controller->store();
    exit;

} elseif (preg_match('/^\/users\/edit\/(\d+)$/', $path, $matches)) {
    // Show edit form
    require_once '../app/controllers/UserController.php';
    $controller = new UserController();
    $controller->edit($matches[1]);
    exit;

} elseif (preg_match('/^\/users\/update\/(\d+)$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user
    require_once '../app/controllers/UserController.php';
    $controller = new UserController();
    $controller->update($matches[1]);
    exit;

} elseif (preg_match('/^\/users\/delete\/(\d+)$/', $path, $matches)) {
    // Delete user
    require_once '../app/controllers/UserController.php';
    $controller = new UserController();
    $controller->destroy($matches[1]);

    // Product CRUD Routes
} elseif ($path === '/products') {
    // List all products
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->index();
    exit;

} elseif ($path === '/products/create') {
    // Show create form
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->create();

} elseif ($path === '/products/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store new product
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->store();

} elseif (preg_match('/^\/products\/edit\/(\d+)$/', $path, $matches)) {
    // Show edit form
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->edit($matches[1]);

} elseif (preg_match('/^\/products\/update\/(\d+)$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update product
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->update($matches[1]);

} elseif (preg_match('/^\/products\/delete\/(\d+)$/', $path, $matches)) {
    // Delete product
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->destroy($matches[1]);

    // Product Image Routes
} elseif (preg_match('/^\/products\/(\d+)\/images$/', $path, $matches)) {
    // Manage product images
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->manageImages($matches[1]);

} elseif (preg_match('/^\/products\/(\d+)\/images\/upload$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Upload product image
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->uploadImage($matches[1]);

} elseif (preg_match('/^\/products\/(\d+)\/images\/(\d+)\/delete$/', $path, $matches)) {
    // Delete product image
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->deleteImage($matches[1], $matches[2]);

} elseif (preg_match('/^\/products\/(\d+)\/images\/(\d+)\/set-primary$/', $path, $matches)) {
    // Set primary image
    require_once '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->setPrimaryImage($matches[1], $matches[2]);

    // Discount CRUD Routes
} elseif ($path === '/discounts') {
    // List all discounts
    require_once '../app/controllers/DiscountController.php';
    $controller = new DiscountController();
    $controller->index();
    exit;

} elseif ($path === '/discounts/create') {
    // Show create form
    require_once '../app/controllers/DiscountController.php';
    $controller = new DiscountController();
    $controller->create();

} elseif ($path === '/discounts/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store new discount
    require_once '../app/controllers/DiscountController.php';
    $controller = new DiscountController();
    $controller->store();

} elseif (preg_match('/^\/discounts\/edit\/(\d+)$/', $path, $matches)) {
    // Show edit form
    require_once '../app/controllers/DiscountController.php';
    $controller = new DiscountController();
    $controller->edit($matches[1]);

} elseif (preg_match('/^\/discounts\/update\/(\d+)$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update discount
    require_once '../app/controllers/DiscountController.php';
    $controller = new DiscountController();
    $controller->update($matches[1]);

} elseif (preg_match('/^\/discounts\/delete\/(\d+)$/', $path, $matches)) {
    // Delete discount
    require_once '../app/controllers/DiscountController.php';
    $controller = new DiscountController();
    $controller->destroy($matches[1]);

    // Cart/Order Routes (View-only)
} elseif ($path === '/carts') {
    // List all orders
    require_once '../app/controllers/CartController.php';
    $controller = new CartController();
    $controller->index();
    exit;

} elseif (preg_match('/^\/carts\/view\/(\d+)$/', $path, $matches)) {
    // View order details
    require_once '../app/controllers/CartController.php';
    $controller = new CartController();
    $controller->view($matches[1]);
    exit;

} elseif (preg_match('/^\/carts\/edit\/(\d+)$/', $path, $matches)) {
    // Edit order status
    require_once '../app/controllers/CartController.php';
    $controller = new CartController();
    $controller->edit($matches[1]);
    exit;

} elseif (preg_match('/^\/carts\/update\/(\d+)$/', $path, $matches)) {
    // Update order status
    require_once '../app/controllers/CartController.php';
    $controller = new CartController();
    $controller->update($matches[1]);
    exit;

} else {
    // Public routes
    switch ($path) {
        case '/':
        case '/home':
            include '../app/views/public/home.php';
            break;

        case '/shop':
            require_once '../app/controllers/ShopController.php';
            $controller = new ShopController();
            $controller->index();
            break;

        case '/warranty-policy':
            include '../app/views/public/warranty_policy.php';
            break;

        case '/return-policy':
            include '../app/views/public/return_policy.php';
            break;

        case '/contact':
            include '../app/views/public/contact.php';
            break;

        case '/faq':
            include '../app/views/public/faq.php';
            break;

        // Customer Cart Routes
        case '/cart':
            require_once '../app/controllers/CustomerCartController.php';
            $controller = new CustomerCartController();
            $controller->index();
            break;

        case '/cart/add':
            require_once '../app/controllers/CustomerCartController.php';
            $controller = new CustomerCartController();
            $controller->add();
            break;

        case '/cart/update':
            require_once '../app/controllers/CustomerCartController.php';
            $controller = new CustomerCartController();
            $controller->update();
            break;

        case '/cart/remove':
            require_once '../app/controllers/CustomerCartController.php';
            $controller = new CustomerCartController();
            $controller->remove();
            break;

        case '/checkout':
            require_once '../app/controllers/CustomerCartController.php';
            $controller = new CustomerCartController();
            $controller->checkout();
            break;

        case '/cart/apply-discount':
            require_once '../app/controllers/CustomerCartController.php';
            $controller = new CustomerCartController();
            $controller->applyDiscount();
            break;

        case '/cart/place-order':
            require_once '../app/controllers/CustomerCartController.php';
            $controller = new CustomerCartController();
            $controller->placeOrder();
            break;

        case '/maintain':
            include '../app/views/public/maintain.php';
            break;

        default:
            // Check if it's a product detail route
            if (preg_match('/^\/shop\/product\/(\d+)$/', $path, $matches)) {
                require_once '../app/controllers/ShopController.php';
                $controller = new ShopController();
                $controller->productDetail($matches[1]);
            } elseif (preg_match('/^\/order-success\/(\d+)$/', $path, $matches)) {
                require_once '../app/controllers/CustomerCartController.php';
                $controller = new CustomerCartController();
                $controller->orderSuccess($matches[1]);
            } else {
                http_response_code(404);
                include '../app/views/public/404.php';
            }
            break;
    }
}
?>