<?php
$pageTitle = htmlspecialchars($product->getProductName()) . ' | Book Store';
$additionalCSS = [
    '/volta/public/css/client.css',
    '/volta/public/css/notyf.min.css',
    '/volta/public/css/product-detail.css',
];
require_once __DIR__ . '/../../helpers/Icons.php';
include __DIR__ . '/../layouts/public_header.php';
?>
<!-- Breadcrumb -->
<div class="bg-white border-b">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <a href="/volta/public/home" class="hover:text-blue-600">Home</a>
            <span>/</span>
            <a href="/volta/public/shop" class="hover:text-blue-600">Shop</a>
            <span>/</span>
            <span class="text-gray-900"><?= htmlspecialchars($product->getProductName()) ?></span>
        </div>
    </div>
</div>

<!-- Main Content -->
<main class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div>
            <?php
            $mainImage = !empty($productImages) ? $productImages[0]['path'] : null;
            // Database paths already include 'public/', so we just need '/volta/'
            $mainImageUrl = $mainImage ? '/volta/' . htmlspecialchars($mainImage) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'500\' viewBox=\'0 0 400 500\'%3E%3Crect fill=\'%23f3f4f6\' width=\'400\' height=\'500\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'48\' fill=\'%239ca3af\'%3E📚%3C/text%3E%3C/svg%3E';
            ?>
            <img src="<?= $mainImageUrl ?>" alt="<?= htmlspecialchars($product->getProductName()) ?>"
                class="product-detail-image"
                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'500\' viewBox=\'0 0 400 500\'%3E%3Crect fill=\'%23f3f4f6\' width=\'400\' height=\'500\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'48\' fill=\'%239ca3af\'%3E📚%3C/text%3E%3C/svg%3E'">

            <?php if (count($productImages) > 1): ?>
                <!-- Additional Images Thumbnails -->
                <div class="grid grid-cols-4 gap-2 mt-4">
                    <?php foreach ($productImages as $index => $image): ?>
                        <img src="/volta/<?= htmlspecialchars($image['path']) ?>"
                            alt="<?= htmlspecialchars($product->getProductName()) ?> - Image <?= $index + 1 ?>"
                            class="cursor-pointer border-2 border-gray-200 hover:border-blue-500 rounded-lg transition"
                            onclick="changeMainImage(this.src)" onerror="this.style.display='none'">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Product Info -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($product->getProductName()) ?></h1>

            <div class="mb-4">
                <span class="text-lg text-gray-600">by <span
                        class="font-semibold"><?= htmlspecialchars($product->getAuthor()) ?></span></span>
            </div>

            <!-- Price -->
            <div class="mb-6">
                <?php
                $discountedPrice = $product->getPrice() * (1 - $product->getDiscountRate() / 100);
                $stock = $product->getQuantity();
                ?>

                <?php if ($product->getDiscountRate() > 0): ?>
                    <div class="original-price-large mb-2"><?= number_format($product->getPrice()) ?> ₫</div>
                <?php endif; ?>

                <div class="flex items-center gap-3">
                    <span class="price-large"><?= number_format($discountedPrice) ?> ₫</span>
                    <?php if ($product->getDiscountRate() > 0): ?>
                        <span class="inline-block bg-red-100 text-red-600 text-sm font-semibold px-3 py-1 rounded-full">
                            -<?= $product->getDiscountRate() ?>% OFF
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stock Status -->
            <div class="mb-6">
                <?php if ($stock > 10): ?>
                    <span class="inline-block bg-green-100 text-green-800 text-sm font-semibold px-4 py-2 rounded-lg">
                        ✓ In Stock (<?= $stock ?> available)
                    </span>
                <?php elseif ($stock > 0): ?>
                    <span class="inline-block bg-yellow-100 text-yellow-800 text-sm font-semibold px-4 py-2 rounded-lg">
                        ⚠ Low Stock (Only <?= $stock ?> left)
                    </span>
                <?php else: ?>
                    <span class="inline-block bg-red-100 text-red-800 text-sm font-semibold px-4 py-2 rounded-lg">
                        ✗ Out of Stock
                    </span>
                <?php endif; ?>
            </div>

            <!-- Quantity Selector -->
            <?php if ($stock > 0): ?>
                <div class="quantity-selector">
                    <label class="detail-label">Quantity:</label>
                    <button class="quantity-btn" onclick="decreaseQuantity()">−</button>
                    <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="<?= $stock ?>"
                        readonly>
                    <button class="quantity-btn" onclick="increaseQuantity(<?= $stock ?>)">+</button>
                </div>

                <!-- Add to Cart Button -->
                <button class="btn-add-large" onclick="addToCart(<?= $product->getId() ?>)">
                    🛒 Add to Cart
                </button>
            <?php else: ?>
                <button class="btn-add-large" disabled>
                    Out of Stock
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Product Details Sections -->
    <div class="mt-12">
        <!-- Description -->
        <div class="detail-section">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
            <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($product->getDescription())) ?></p>
        </div>

        <!-- Specifications -->
        <div class="detail-section">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Product Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="detail-label">Author</div>
                    <div class="detail-value"><?= htmlspecialchars($product->getAuthor()) ?></div>
                </div>
                <div>
                    <div class="detail-label">Publisher</div>
                    <div class="detail-value"><?= htmlspecialchars($product->getPublisher()) ?></div>
                </div>
                <div>
                    <div class="detail-label">Language</div>
                    <div class="detail-value"><?= htmlspecialchars($product->getLanguage()) ?></div>
                </div>
                <div>
                    <div class="detail-label">Publication Year</div>
                    <div class="detail-value"><?= htmlspecialchars($product->getYearOfPublication()) ?></div>
                </div>
                <div>
                    <div class="detail-label">Pages</div>
                    <div class="detail-value"><?= htmlspecialchars($product->getPageNum()) ?> pages</div>
                </div>
                <div>
                    <div class="detail-label">Size</div>
                    <div class="detail-value"><?= htmlspecialchars($product->getSize()) ?></div>
                </div>
                <div>
                    <div class="detail-label">Format</div>
                    <div class="detail-value"><?= htmlspecialchars($product->getFormat()) ?></div>
                </div>
                <div>
                    <div class="detail-label">Category</div>
                    <div class="detail-value"><?= htmlspecialchars($product->getCategory()) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Shop Button -->
    <div class="mt-8 text-center">
        <a href="/volta/public/shop"
            class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            <?= Icons::arrowLeft('w-5 h-5 mr-2') ?>
            Back to Shop
        </a>
    </div>
</main>

<script src="/volta/public/javascript/notyf.min.js"></script>
<script src="/volta/public/javascript/product-detail.js"></script>
<?php
$additionalJS = [
    '/volta/public/javascript/notyf.min.js',
    '/volta/public/javascript/product-detail.js'
];
include __DIR__ . '/../layouts/public_footer.php';
?>