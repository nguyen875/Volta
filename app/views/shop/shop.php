<?php 
$pageTitle = 'Shop - Browse Quality Books Online | Book Store';
$pageDescription = 'Browse our extensive collection of books. Find literature, fiction, non-fiction, and more. Free shipping on all orders. Shop now!';
$pageKeywords = 'online bookstore, buy books, book collection, literature, fiction, non-fiction, Vietnamese books';
$canonicalUrl = 'http://localhost/volta/public/shop';

$additionalCSS = [
    '/volta/public/css/client.css',
    '/volta/public/css/shop.css',
    '/volta/public/css/notyf.min.css'
];
include __DIR__ . '/../layouts/public_header.php';
?>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Breadcrumb for SEO -->
        <nav class="mb-4 text-sm" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-gray-600">
                <li><a href="/volta/public/" class="hover:text-purple-600">Home</a></li>
                <li>/</li>
                <li class="text-gray-800 font-semibold">Shop</li>
            </ol>
        </nav>

        <!-- Page Header with H1 -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Shop Our Book Collection</h1>
            <p class="text-gray-600">Discover our collection of quality books across all genres</p>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <form method="GET" action="/volta/public/shop" class="flex gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="<?= htmlspecialchars($pagination['search'] ?? '') ?>"
                    placeholder="Search books by title, author..." 
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Search
                </button>
            </form>
        </div>

        <!-- Products Grid -->
        <?php if (empty($products)): ?>
            <div class="text-center py-16">
                <?= Icons::emptyState('mx-auto h-24 w-24 text-gray-400') ?>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-2 text-gray-500">
                    <?php if (!empty($pagination['search'])): ?>
                        Try searching with different keywords
                    <?php else: ?>
                        Check back later for new arrivals
                    <?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                <?php foreach ($products as $product): 
                    $discountedPrice = $product->getPrice() * (1 - $product->getDiscountRate() / 100);
                    $stock = $product->getQuantity();
                    $stockStatus = $stock > 10 ? 'in' : ($stock > 0 ? 'low' : 'out');
                    $imagePath = $productImages[$product->getId()] ?? null;
                    $imageUrl = $imagePath ? '/volta/' . htmlspecialchars($imagePath) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'500\' viewBox=\'0 0 400 500\'%3E%3Crect fill=\'%23f3f4f6\' width=\'400\' height=\'500\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'48\' fill=\'%239ca3af\'%3E📚%3C/text%3E%3C/svg%3E';
                ?>
                    <div class="product-card" data-product-id="<?= $product->getId() ?>">
                        <img 
                            src="<?= $imageUrl ?>" 
                            alt="<?= htmlspecialchars($product->getProductName()) ?>"
                            class="product-image"
                            loading="lazy"
                            onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'500\' viewBox=\'0 0 400 500\'%3E%3Crect fill=\'%23f3f4f6\' width=\'400\' height=\'500\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'48\' fill=\'%239ca3af\'%3E📚%3C/text%3E%3C/svg%3E'"
                        >
                        <div class="product-content">
                            <h3 class="product-title"><?= htmlspecialchars($product->getProductName()) ?></h3>
                            <p class="product-author">by <?= htmlspecialchars($product->getAuthor()) ?></p>
                            
                            <div class="product-price-section">
                                <span class="stock-badge stock-<?= $stockStatus ?>">
                                    <?php if ($stockStatus === 'in'): ?>
                                        In Stock (<?= $stock ?>)
                                    <?php elseif ($stockStatus === 'low'): ?>
                                        Low Stock (<?= $stock ?>)
                                    <?php else: ?>
                                        Out of Stock
                                    <?php endif; ?>
                                </span>
                                
                                <?php if ($product->getDiscountRate() > 0): ?>
                                    <div class="product-original-price"><?= number_format($product->getPrice()) ?> ₫</div>
                                <?php endif; ?>
                                
                                <div>
                                    <span class="product-price"><?= number_format($discountedPrice) ?> ₫</span>
                                    <?php if ($product->getDiscountRate() > 0): ?>
                                        <span class="discount-badge">-<?= $product->getDiscountRate() ?>%</span>
                                    <?php endif; ?>
                                </div>
                                
                                <a href="/volta/public/shop/product/<?= $product->getId() ?>" class="btn-view-detail">
                                    View Details
                                </a>
                                
                                <button 
                                    class="btn-add-cart" 
                                    onclick="addToCart(<?= $product->getId() ?>)"
                                    <?= $stock <= 0 ? 'disabled' : '' ?>
                                >
                                    <?= $stock > 0 ? '🛒 Add to Cart' : 'Out of Stock' ?>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($pagination['total_pages'] > 1): ?>
                <div class="flex justify-center items-center gap-2 mt-12">
                    <?php
                    $baseUrl = '/volta/public/shop?';
                    if (!empty($pagination['search'])) {
                        $baseUrl .= 'search=' . urlencode($pagination['search']) . '&';
                    }
                    
                    $maxVisiblePages = 5;
                    $startPage = max(1, $pagination['current_page'] - floor($maxVisiblePages / 2));
                    $endPage = min($pagination['total_pages'], $startPage + $maxVisiblePages - 1);
                    $startPage = max(1, $endPage - $maxVisiblePages + 1);
                    ?>

                    <!-- Previous -->
                    <?php if ($pagination['current_page'] > 1): ?>
                        <a href="<?= $baseUrl ?>page=<?= $pagination['current_page'] - 1 ?>" 
                           class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Previous
                        </a>
                    <?php endif; ?>

                    <!-- Pages -->
                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <?php if ($i == $pagination['current_page']): ?>
                            <span class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium">
                                <?= $i ?>
                            </span>
                        <?php else: ?>
                            <a href="<?= $baseUrl ?>page=<?= $i ?>" 
                               class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <?= $i ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <!-- Next -->
                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                        <a href="<?= $baseUrl ?>page=<?= $pagination['current_page'] + 1 ?>" 
                           class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Next
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

<?php 
$additionalJS = ['/volta/public/javascript/notyf.min.js', '/volta/public/javascript/shop.js'];
include __DIR__ . '/../layouts/public_footer.php';
?>
