<?php
require_once __DIR__ . '/../../helpers/Auth.php';
Auth::requireLogin();

$pageTitle = 'Checkout - Book Store';
include __DIR__ . '/../layouts/public_header.php';
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-8 text-gray-800">Checkout</h1>

            <?php if (empty($_SESSION['cart'])): ?>
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <p class="text-gray-600 mb-4">Your cart is empty</p>
                    <a href="/volta/public/shop" class="text-purple-600 hover:text-purple-800 font-semibold">
                        Continue Shopping →
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold mb-4 text-gray-800">Shipping Information</h2>

                            <form method="POST" action="/volta/public/cart/place-order">
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2">Receiver Name *</label>
                                    <input type="text" name="receiver_name"
                                        value="<?= htmlspecialchars($_SESSION['Name'] ?? '') ?>" required
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Phone Number *
                                        <?php if (empty($customer['PhoneNum'] ?? '')): ?>
                                            <a href="/volta/public/profile" class="text-sm text-purple-600 hover:underline">
                                                (Set default in profile)
                                            </a>
                                        <?php endif; ?>
                                    </label>
                                    <input type="tel" name="phone"
                                        value="<?= htmlspecialchars($customer['PhoneNum'] ?? '') ?>" required
                                        placeholder="Enter phone number"
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Shipping Address *
                                        <?php if (empty($customer['Address'] ?? '')): ?>
                                            <a href="/volta/public/profile" class="text-sm text-purple-600 hover:underline">
                                                (Set default in profile)
                                            </a>
                                        <?php endif; ?>
                                    </label>
                                    <textarea name="address" rows="3" required placeholder="Enter full address"
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"><?= htmlspecialchars($customer['Address'] ?? '') ?></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2">Payment Method *</label>
                                    <select name="payment_method" required
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                        <option value="COD">Cash on Delivery (COD)</option>
                                        <option value="Bank">Bank Transfer</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Discount Coupon (Optional)
                                    </label>
                                    <select name="discount_code" id="discount_code" onchange="applyDiscount()"
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                        <option value="">-- No Discount --</option>
                                        <?php if (!empty($activeDiscounts)): ?>
                                            <?php foreach ($activeDiscounts as $discount): ?>
                                                <option value="<?= htmlspecialchars($discount->getCode()) ?>"
                                                    data-amount="<?= $discount->getMoneyDeduct() ?>"
                                                    data-condition="<?= htmlspecialchars($discount->getCondition() ?? '') ?>">
                                                    <?= htmlspecialchars($discount->getCode()) ?> -
                                                    Save <?= number_format($discount->getMoneyDeduct(), 0, ',', '.') ?> ₫
                                                    <?php if ($discount->getCondition()): ?>
                                                        (<?= htmlspecialchars($discount->getCondition()) ?>)
                                                    <?php endif; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if (empty($activeDiscounts)): ?>
                                        <p class="text-sm text-gray-500 mt-1">No active discount coupons available</p>
                                    <?php endif; ?>
                                    <div id="discount-info" class="mt-2 text-sm text-green-600" style="display: none;">
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <button type="submit"
                                        class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700">
                                        Place Order
                                    </button>
                                    <a href="/volta/public/cart"
                                        class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 inline-block text-center">
                                        Back to Cart
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                            <h2 class="text-xl font-bold mb-4 text-gray-800">Order Summary</h2>

                            <div class="space-y-2 mb-4">
                                <?php
                                require_once __DIR__ . '/../../dao/ProductDAO.php';
                                $productDAO = new ProductDAO();
                                $subtotal = 0;

                                foreach ($_SESSION['cart'] as $productId => $quantity):
                                    $product = $productDAO->getById($productId);
                                    if ($product):
                                        $price = $product->getPrice() * (1 - $product->getDiscountRate() / 100);
                                        $itemTotal = $price * $quantity;
                                        $subtotal += $itemTotal;
                                        ?>
                                        <div class="flex justify-between text-sm">
                                            <span><?= htmlspecialchars($product->getProductName()) ?> x<?= $quantity ?></span>
                                            <span><?= number_format($itemTotal, 0, ',', '.') ?> ₫</span>
                                        </div>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>

                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between">
                                    <span>Subtotal:</span>
                                    <span class="font-semibold"
                                        id="subtotal-amount"><?= number_format($subtotal, 0, ',', '.') ?> ₫</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Shipping:</span>
                                    <span class="text-green-600">Free</span>
                                </div>
                                <div class="flex justify-between text-green-600" id="discount-row" style="display: none;">
                                    <span>Discount (<span id="discount-code-label"></span>):</span>
                                    <span id="discount-value">0 ₫</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t pt-2">
                                    <span>Total:</span>
                                    <span class="text-purple-600"
                                        id="total-amount"><?= number_format($subtotal, 0, ',', '.') ?> ₫</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    const subtotal = <?= $subtotal ?>;

    function applyDiscount() {
        const selectElement = document.getElementById('discount_code');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const discountCode = selectedOption.value;
        const discountAmount = parseFloat(selectedOption.getAttribute('data-amount') || 0);
        const discountCondition = selectedOption.getAttribute('data-condition') || '';

        const discountRow = document.getElementById('discount-row');
        const discountCodeLabel = document.getElementById('discount-code-label');
        const discountValue = document.getElementById('discount-value');
        const totalElement = document.getElementById('total-amount');
        const discountInfo = document.getElementById('discount-info');

        if (discountCode && discountAmount > 0) {
            // Show discount row
            discountRow.style.display = 'flex';
            discountCodeLabel.textContent = discountCode;
            discountValue.textContent = '-' + Math.floor(discountAmount).toLocaleString('vi-VN') + ' ₫';

            // Calculate new total (round to whole number)
            const newTotal = Math.max(0, Math.floor(subtotal - discountAmount));
            totalElement.textContent = newTotal.toLocaleString('vi-VN') + ' ₫';

            // Show condition info
            if (discountCondition) {
                discountInfo.style.display = 'block';
                discountInfo.textContent = '✓ Discount applied: ' + discountCondition;
            } else {
                discountInfo.style.display = 'none';
            }
        } else {
            // Hide discount row
            discountRow.style.display = 'none';
            totalElement.textContent = Math.floor(subtotal).toLocaleString('vi-VN') + ' ₫';
            discountInfo.style.display = 'none';
        }
    }
</script>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>