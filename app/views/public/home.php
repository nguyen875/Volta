<?php
$pageTitle = 'Book Store - Online Bookstore | Buy Quality Books';
$pageDescription = 'Your trusted online bookstore. Browse thousands of quality books with free shipping. Fiction, non-fiction, literature, and more. Shop now!';
$pageKeywords = 'online bookstore, buy books online, quality books, free shipping books, Vietnamese bookstore';
$canonicalUrl = 'http://localhost/volta/public/';

include __DIR__ . '/../layouts/public_header.php';
?>

<!-- Hero Section -->
<section class="gradient-bg text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">Welcome to Book Store</h1>
        <h2 class="text-2xl mb-8 opacity-90">Your Online Destination for Quality Books</h2>
        <p class="text-xl mb-8 opacity-90">Discover thousands of books across all genres with amazing prices and free
            shipping</p>
        <div class="flex justify-center space-x-4">
            <a href="/volta/public/shop"
                class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-300 hover:text-purple-700 transition duration-300">
                Browse Books
            </a>
            <a href="#features"
                class="bg-transparent border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition duration-300">
                Learn More
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16" id="features">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Why Choose Book Store</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Shop -->
            <div class="bg-white rounded-lg shadow-md p-8 card-hover">
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <?= Icons::shoppingBag('w-8 h-8 text-purple-600') ?>
                    </div>
                    <h4 class="text-xl font-bold mb-2 text-gray-800">Wide Selection</h4>
                    <p class="text-gray-600 mb-4">Browse thousands of books across all genres with great deals and
                        discounts</p>
                    <a href="/volta/public/shop" class="text-purple-600 hover:text-purple-800 font-semibold">
                        Start Shopping &rarr;
                    </a>
                </div>
            </div>

            <!-- Store Location -->
            <div class="bg-white rounded-lg shadow-md p-8 card-hover">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <?= Icons::location('w-8 h-8 text-blue-600') ?>
                    </div>
                    <h4 class="text-xl font-bold mb-2 text-gray-800">Visit Our Store</h4>
                    <p class="text-gray-600 mb-4">Find us at multiple locations. Fast shipping nationwide or pickup
                        in-store</p>
                    <a href="#locations" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Find Store &rarr;
                    </a>
                </div>
            </div>

            <!-- Careers -->
            <div class="bg-white rounded-lg shadow-md p-8 card-hover">
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <?= Icons::briefcase('w-8 h-8 text-green-600') ?>
                    </div>
                    <h4 class="text-xl font-bold mb-2 text-gray-800">Join Our Team</h4>
                    <p class="text-gray-600 mb-4">We're hiring! Explore career opportunities and become part of our
                        story</p>
                    <a href="#careers" class="text-green-600 hover:text-green-800 font-semibold">
                        View Openings &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Store Locations -->
<section class="bg-gray-100 py-16" id="locations">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Visit Our Physical Stores</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                <h4 class="font-bold text-xl mb-3 text-gray-800">District 1 - Main Store</h4>
                <a href="https://www.google.com/maps/search/?api=1&query=123+Nguyen+Hue+Street+District+1+Ho+Chi+Minh+City"
                    target="_blank" class="flex items-start text-gray-600 mb-2 hover:text-purple-600 transition">
                    <?= Icons::location('w-5 h-5 mr-2 mt-0.5 flex-shrink-0') ?>
                    <span>123 Nguyen Hue St, District 1, HCMC</span>
                </a>
                <p class="text-gray-600 mb-2 flex items-center">
                    <span class="mr-2">📞</span> (028) 1234-5678
                </p>
                <p class="text-gray-600 flex items-center">
                    <span class="mr-2">🕐</span> Mon-Sun: 8:00 AM - 9:00 PM
                </p>
                <a href="https://www.google.com/maps/search/?api=1&query=123+Nguyen+Hue+Street+District+1+Ho+Chi+Minh+City"
                    target="_blank" class="mt-4 inline-block text-purple-600 font-semibold hover:text-purple-800">
                    View on Map &rarr;
                </a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                <h4 class="font-bold text-xl mb-3 text-gray-800">District 3 - Branch</h4>
                <a href="https://www.google.com/maps/search/?api=1&query=456+Vo+Van+Tan+Street+District+3+Ho+Chi+Minh+City"
                    target="_blank" class="flex items-start text-gray-600 mb-2 hover:text-purple-600 transition">
                    <?= Icons::location('w-5 h-5 mr-2 mt-0.5 flex-shrink-0') ?>
                    <span>456 Vo Van Tan St, District 3, HCMC</span>
                </a>
                <p class="text-gray-600 mb-2 flex items-center">
                    <span class="mr-2">📞</span> (028) 2345-6789
                </p>
                <p class="text-gray-600 flex items-center">
                    <span class="mr-2">🕐</span> Mon-Sun: 9:00 AM - 8:00 PM
                </p>
                <a href="https://www.google.com/maps/search/?api=1&query=456+Vo+Van+Tan+Street+District+3+Ho+Chi+Minh+City"
                    target="_blank" class="mt-4 inline-block text-purple-600 font-semibold hover:text-purple-800">
                    View on Map &rarr;
                </a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                <h4 class="font-bold text-xl mb-3 text-gray-800">Binh Thanh - Branch</h4>
                <a href="https://www.google.com/maps/search/?api=1&query=789+Xo+Viet+Nghe+Tinh+Binh+Thanh+Ho+Chi+Minh+City"
                    target="_blank" class="flex items-start text-gray-600 mb-2 hover:text-purple-600 transition">
                    <?= Icons::location('w-5 h-5 mr-2 mt-0.5 flex-shrink-0') ?>
                    <span>789 Xo Viet Nghe Tinh, Binh Thanh, HCMC</span>
                </a>
                <p class="text-gray-600 mb-2 flex items-center">
                    <span class="mr-2">📞</span> (028) 3456-7890
                </p>
                <p class="text-gray-600 flex items-center">
                    <span class="mr-2">🕐</span> Mon-Sun: 9:00 AM - 8:00 PM
                </p>
                <a href="https://www.google.com/maps/search/?api=1&query=789+Xo+Viet+Nghe+Tinh+Binh+Thanh+Ho+Chi+Minh+City"
                    target="_blank" class="mt-4 inline-block text-purple-600 font-semibold hover:text-purple-800">
                    View on Map &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Careers Section -->
<section class="py-16" id="careers">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Career Opportunities</h2>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                <h4 class="font-bold text-xl mb-2 text-gray-800">Sales Associate</h4>
                <p class="text-gray-600 mb-2">📍 Multiple locations</p>
                <p class="text-gray-600 mb-4">Help customers find their perfect book. Full-time and part-time positions
                    available.</p>
                <button class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Apply Now</button>
            </div>
            <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                <h4 class="font-bold text-xl mb-2 text-gray-800">Warehouse Manager</h4>
                <p class="text-gray-600 mb-2">📍 District 1 - Main Store</p>
                <p class="text-gray-600 mb-4">Manage inventory and logistics. Experience required.</p>
                <button class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Apply Now</button>
            </div>
            <div class="bg-white rounded-lg shadow-md p-8">
                <h4 class="font-bold text-xl mb-2 text-gray-800">Marketing Specialist</h4>
                <p class="text-gray-600 mb-2">📍 Remote / District 1 Office</p>
                <p class="text-gray-600 mb-4">Create compelling campaigns for our book collections.</p>
                <button class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Apply Now</button>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>