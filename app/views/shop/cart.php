<?php 
$pageTitle = 'Shopping Cart - Book Store';
include __DIR__ . '/../layouts/public_header.php';
?>

<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Shopping Cart</h1>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <!-- Empty Cart State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <?= Icons::shoppingBag('w-24 h-24 mx-auto text-gray-400 mb-4') ?>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Start adding some books to your cart!</p>
                <a href="/volta/public/shop" 
                   class="inline-block bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                    Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <!-- Cart Items -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md">
                        <?php 
                        require_once __DIR__ . '/../../dao/ProductDAO.php';
                        $productDAO = new ProductDAO();
                        $subtotal = 0;
                        
                        foreach ($_SESSION['cart'] as $productId => $quantity):
                            $product = $productDAO->getById($productId);
                            if (!$product) continue;
                            
                            $firstImage = $productDAO->getFirstImage($productId);
                            $price = $product->getPrice() * (1 - $product->getDiscountRate() / 100);
                            $itemTotal = $price * $quantity;
                            $subtotal += $itemTotal;
                        ?>
                            <div class="flex items-center gap-4 p-4 border-b last:border-b-0">
                                <!-- Product Image -->
                                <img src="/volta/<?= htmlspecialchars($firstImage ?? 'public/image/no-image.png') ?>" 
                                     alt="<?= htmlspecialchars($product->getProductName()) ?>"
                                     class="w-24 h-32 object-cover rounded">
                                
                                <!-- Product Info -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 mb-1">
                                        <?= htmlspecialchars($product->getProductName()) ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        <?= htmlspecialchars($product->getAuthor() ?? 'Unknown Author') ?>
                                    </p>
                                    <p class="text-lg font-bold text-purple-600">
                                        <?= number_format($price, 0, ',', '.') ?> ₫
                                    </p>
                                </div>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-3">
                                    <form method="POST" action="/volta/public/cart/update" class="flex items-center gap-2">
                                        <input type="hidden" name="product_id" value="<?= $productId ?>">
                                        <button type="submit" name="action" value="decrease" 
                                                class="w-8 h-8 bg-gray-200 rounded hover:bg-gray-300">
                                            -
                                        </button>
                                        <span class="w-12 text-center font-semibold"><?= $quantity ?></span>
                                        <button type="submit" name="action" value="increase" 
                                                class="w-8 h-8 bg-gray-200 rounded hover:bg-gray-300"
                                                <?= $quantity >= $product->getQuantity() ? 'disabled' : '' ?>>
                                            +
                                        </button>
                                    </form>
                                    
                                    <!-- Remove Button -->
                                    <form method="POST" action="/volta/public/cart/remove">
                                        <input type="hidden" name="product_id" value="<?= $productId ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-800 ml-4">
                                            <?= Icons::delete('w-5 h-5') ?>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Item Total -->
                                <div class="text-right min-w-[120px]">
                                    <p class="font-bold text-gray-800">
                                        <?= number_format($itemTotal, 0, ',', '.') ?> ₫
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h2 class="text-xl font-bold mb-4 text-gray-800">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal (<?= array_sum($_SESSION['cart']) ?> items)</span>
                                <span><?= number_format($subtotal, 0, ',', '.') ?> ₫</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="text-green-600">Free</span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-lg font-bold text-gray-800">
                                    <span>Total</span>
                                    <span class="text-purple-600"><?= number_format($subtotal, 0, ',', '.') ?> ₫</span>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (isset($_SESSION['UID'])): ?>
                            <a href="/volta/public/checkout" 
                               class="block w-full bg-purple-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-purple-700 transition mb-3">
                                Proceed to Checkout
                            </a>
                        <?php else: ?>
                            <a href="/volta/public/login" 
                               class="block w-full bg-purple-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-purple-700 transition mb-3">
                                Login to Checkout
                            </a>
                        <?php endif; ?>
                        
                        <a href="/volta/public/shop" 
                           class="block w-full bg-gray-200 text-gray-800 text-center py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>