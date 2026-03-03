<?php
$pageTitle = 'Order Successful - Book Store';
include __DIR__ . '/../layouts/public_header.php';
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Success Message -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-6 text-center">
                <div class="text-green-500 mb-4">
                    <?= Icons::checkCircle('w-24 h-24 mx-auto') ?>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Order Placed Successfully!</h1>
                <p class="text-gray-600 mb-4">Thank you for your order. We'll process it shortly.</p>
                <p class="text-lg font-semibold text-purple-600">Order #<?= $order['Order_ID'] ?></p>
            </div>

            <!-- Order Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Order Details</h2>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-600">Order Date</p>
                        <p class="font-semibold"><?= htmlspecialchars($order['OrderDate']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Payment Method</p>
                        <p class="font-semibold"><?= htmlspecialchars($order['PaymentMethod']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Receiver</p>
                        <p class="font-semibold"><?= htmlspecialchars($order['ReceiverName']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-semibold"><?= htmlspecialchars($order['PhoneNum']) ?></p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600">Delivery Address</p>
                        <p class="font-semibold"><?= htmlspecialchars($order['Address']) ?></p>
                    </div>
                </div>

                <!-- Order Items -->
                <h3 class="font-semibold mb-3 text-gray-800">Items</h3>
                <div class="space-y-2">
                    <?php foreach ($orderItems as $item): ?>
                        <div class="flex justify-between text-sm border-b pb-2">
                            <span><?= htmlspecialchars($item['ProductName']) ?> x<?= $item['Quantity'] ?></span>
                            <span class="font-semibold"><?= number_format($item['FinalTotal'], 0, ',', '.') ?> ₫</span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Total -->
                <div class="border-t mt-4 pt-4">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total Amount</span>
                        <span class="text-purple-600"><?= number_format($order['Bill'], 0, ',', '.') ?> ₫</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 justify-center">
                <a href="/volta/public/shop"
                    class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                    Continue Shopping
                </a>
                <a href="/volta/public/"
                    class="bg-gray-200 text-gray-800 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Go Home
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>