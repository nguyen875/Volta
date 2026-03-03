<?php
$pageTitle = 'Order Successful | Book Store';
require_once __DIR__ . '/../../helpers/Icons.php';
include __DIR__ . '/../layouts/public_header.php';
?>

<!-- Main Content -->
<main class="container mx-auto px-4 py-16 min-h-screen">
    <div class="max-w-2xl mx-auto">
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-block bg-green-100 rounded-full p-6 mb-4">
                <?= Icons::check('w-20 h-20 text-green-600') ?>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Order Placed Successfully!</h1>
            <p class="text-lg text-gray-600">Thank you for your purchase</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Order Details</h2>

            <div class="space-y-3 mb-6">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Order Number:</span>
                    <span class="font-semibold text-gray-800">#<?= str_pad($orderId, 6, '0', STR_PAD_LEFT) ?></span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Order Date:</span>
                    <span class="font-semibold text-gray-800"><?= date('d/m/Y') ?></span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Total Amount:</span>
                    <span class="font-semibold text-green-600 text-lg"><?= number_format($total, 0, ',', '.') ?>
                        ₫</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Payment Method:</span>
                    <span
                        class="font-semibold text-gray-800"><?= $paymentMethod === 'COD' ? 'Cash on Delivery' : 'Bank Transfer' ?></span>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 mb-2">📦 What's Next?</h3>
                <ul class="text-sm text-gray-700 space-y-2">
                    <li>✓ Your order has been confirmed</li>
                    <li>✓ We're preparing your books for shipment</li>
                    <li>✓ Delivery will start soon</li>
                    <li>✓ You'll receive your order within 3-5 business days</li>
                </ul>
            </div>

            <!-- Delivery Address -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-2">Delivery Address:</h3>
                <p class="text-gray-600"><?= htmlspecialchars($customerName) ?></p>
                <p class="text-gray-600"><?= htmlspecialchars($customerPhone) ?></p>
                <p class="text-gray-600"><?= htmlspecialchars($customerAddress) ?></p>
            </div>

            <?php if ($paymentMethod === 'Bank'): ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="font-semibold text-yellow-800 mb-2">⚠️ Payment Pending</h3>
                    <p class="text-sm text-gray-700">
                        Please complete your bank transfer payment. Your order will be processed once payment is confirmed.
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="/volta/public/shop"
                class="flex-1 bg-blue-600 text-white text-center py-3 px-6 rounded-lg hover:bg-blue-700 transition font-semibold">
                Continue Shopping
            </a>
            <a href="/volta/public/"
                class="flex-1 bg-gray-200 text-gray-800 text-center py-3 px-6 rounded-lg hover:bg-gray-300 transition font-semibold">
                Return to Home
            </a>
        </div>

        <!-- Support Info -->
        <div class="text-center mt-8 text-sm text-gray-600">
            <p>Need help? Contact our support team</p>
            <p class="font-semibold text-blue-600 mt-1">support@bookstore.com</p>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>