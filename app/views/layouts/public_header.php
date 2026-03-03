<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title><?= $pageTitle ?? 'Book Store - Your Online Bookstore for Quality Books' ?></title>
    <meta name="description"
        content="<?= $pageDescription ?? 'Discover thousands of quality books at amazing prices. Browse our collection of literature, fiction, non-fiction, and more. Fast shipping nationwide.' ?>">
    <meta name="keywords"
        content="<?= $pageKeywords ?? 'books, bookstore, online books, literature, fiction, non-fiction, Vietnamese books, buy books online' ?>">
    <meta name="author" content="Book Store">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $canonicalUrl ?? 'http://localhost/volta/public' . $_SERVER['REQUEST_URI'] ?>">

    <!-- Open Graph Meta Tags (Facebook, LinkedIn) -->
    <meta property="og:title" content="<?= $pageTitle ?? 'Book Store - Your Online Bookstore' ?>">
    <meta property="og:description"
        content="<?= $pageDescription ?? 'Discover thousands of quality books at amazing prices' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $canonicalUrl ?? 'http://localhost/volta/public' . $_SERVER['REQUEST_URI'] ?>">
    <meta property="og:image" content="<?= $ogImage ?? 'http://localhost/volta/public/image/WebLogo.png' ?>">
    <meta property="og:site_name" content="Book Store">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $pageTitle ?? 'Book Store' ?>">
    <meta name="twitter:description" content="<?= $pageDescription ?? 'Discover thousands of quality books' ?>">
    <meta name="twitter:image" content="<?= $ogImage ?? 'http://localhost/volta/public/image/WebLogo.png' ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/volta/public/image/WebLogo.png">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/volta/public/css/tailwind.min.css">
    <link rel="stylesheet" href="/volta/public/css/homepage.css">
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link rel="stylesheet" href="<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BookStore",
        "name": "Book Store",
        "description": "Online bookstore offering thousands of quality books",
        "url": "http://localhost/volta/public",
        "logo": "http://localhost/volta/public/image/WebLogo.png",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "123 Nguyen Hue St, District 1",
            "addressLocality": "Ho Chi Minh City",
            "addressCountry": "VN"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+84-28-1234-5678",
            "contactType": "customer service"
        },
        "sameAs": [
            "https://facebook.com/bookstore",
            "https://twitter.com/bookstore"
        ]
    }
    </script>
</head>

<body class="bg-gray-50">
    <?php
    require_once __DIR__ . '/../../helpers/Icons.php';
    require_once __DIR__ . '/../../helpers/Auth.php';

    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>

    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-2 md:px-4 py-5 md:py-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="/volta/public/" class="flex items-center space-x-3 hover:opacity-80 transition">
                        <img src="/volta/public/image/WebLogo.png" alt="Book Store Logo"
                            class="h-12 w-12 object-contain">
                        <h1 class="text-3xl font-bold">Book Store</h1>
                    </a>
                    <p class="text-sm opacity-90">Online Book Store</p>
                </div>
                <nav class="hidden md:flex space-x-2 items-center">
                    <a href="/volta/public/"
                        class="px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">Home</a>
                    <a href="/volta/public/shop"
                        class="px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">Shop</a>
                    <a href="/volta/public/cart"
                        class="px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">
                        🛒 Cart (<span id="cart-count"><?= array_sum($_SESSION['cart'] ?? []) ?></span>)
                    </a>

                    <?php if (Auth::isAdmin()): ?>
                        <a href="/volta/public/users"
                            class="px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">
                            Admin
                        </a>
                        <a href="/volta/public/logout"
                            class="px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">
                            Logout
                        </a>
                    <?php elseif (Auth::isLoggedIn()): ?>
                        <a href="/volta/public/profile"
                            class="px-3 py-2 rounded-lg bg-white bg-opacity-10 hover:bg-opacity-20 transition"
                            title="Edit Profile">
                            <?= htmlspecialchars($_SESSION['Name'] ?? 'User') ?>
                        </a>
                        <a href="/volta/public/logout"
                            class="px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="/volta/public/login"
                            class="px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">
                            Login
                        </a>
                        <a href="/volta/public/signup"
                            class="px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">
                            Sign Up
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>