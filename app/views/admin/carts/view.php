<?php $pageTitle = 'Order Details #' . $order['Order_ID']; ?>
<?php
include __DIR__ . '/../../layouts/admin_header.php';
require_once __DIR__ . '/../../../helpers/Icons.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <a href="/volta/public/carts" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                        ← Back to Orders
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800">Order #<?= $order['Order_ID'] ?></h1>
                    <p class="text-gray-600 mt-2">Order placed on <?= htmlspecialchars($order['OrderDate']) ?></p>
                </div>
                <a href="/volta/public/carts/edit/<?= $order['Order_ID'] ?>"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <?= Icons::edit('w-4 h-4 mr-2') ?>
                    Edit Status
                </a>
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">Order Items</h2>
                    </div>
                    <div class="p-6">
                        <table class="min-w-full">
                            <thead class="border-b border-gray-200">
                                <tr>
                                    <th class="text-left py-2 text-sm font-medium text-gray-500">Product</th>
                                    <th class="text-right py-2 text-sm font-medium text-gray-500">Price</th>
                                    <th class="text-center py-2 text-sm font-medium text-gray-500">Qty</th>
                                    <th class="text-right py-2 text-sm font-medium text-gray-500">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php
                                $subtotal = 0;
                                foreach ($items as $item):
                                    $subtotal += $item['FinalTotal'];
                                    ?>
                                    <tr>
                                        <td class="py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($item['ProductName']) ?></div>
                                            <?php if ($item['DiscountRate'] > 0): ?>
                                                <div class="text-xs text-green-600">Discount: <?= $item['DiscountRate'] ?>%
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 text-right">
                                            <?php if ($item['DiscountRate'] > 0): ?>
                                                <div class="text-sm text-gray-500 line-through">
                                                    <?= number_format($item['Price'], 0, ',', '.') ?> ₫</div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= number_format($item['PriceAfterDiscount'], 0, ',', '.') ?> ₫</div>
                                            <?php else: ?>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= number_format($item['Price'], 0, ',', '.') ?> ₫</div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 text-center">
                                            <span class="text-sm text-gray-900">×<?= $item['Quantity'] ?></span>
                                        </td>
                                        <td class="py-4 text-right">
                                            <span
                                                class="text-sm font-semibold text-gray-900"><?= number_format($item['FinalTotal'], 0, ',', '.') ?>
                                                ₫</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="border-t-2 border-gray-300">
                                <tr>
                                    <td colspan="3" class="py-4 text-right font-semibold text-gray-700">Subtotal:</td>
                                    <td class="py-4 text-right font-semibold text-gray-900">
                                        <?= number_format($subtotal, 0, ',', '.') ?> ₫</td>
                                </tr>
                                <?php if ($order['DiscountCoupon']): ?>
                                    <tr>
                                        <td colspan="3" class="py-2 text-right text-sm text-gray-600">
                                            Discount (<?= htmlspecialchars($order['DiscountCoupon']) ?>):
                                        </td>
                                        <td class="py-2 text-right text-sm text-green-600">
                                            -<?= number_format($order['Total'] - $order['Bill'], 0, ',', '.') ?> ₫
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="py-4 text-right text-lg font-bold text-gray-800">Total:</td>
                                    <td class="py-4 text-right text-lg font-bold text-blue-600">
                                        <?= number_format($order['Bill'], 0, ',', '.') ?> ₫</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Delivery Information</h2>
                    <div class="space-y-3">
                        <div class="flex">
                            <span class="text-sm text-gray-500 w-32">Recipient:</span>
                            <span
                                class="text-sm font-medium text-gray-900"><?= htmlspecialchars($order['ReceiverName']) ?></span>
                        </div>
                        <div class="flex">
                            <span class="text-sm text-gray-500 w-32">Phone:</span>
                            <span
                                class="text-sm font-medium text-gray-900"><?= htmlspecialchars($order['PhoneNum']) ?></span>
                        </div>
                        <div class="flex">
                            <span class="text-sm text-gray-500 w-32">Address:</span>
                            <span
                                class="text-sm font-medium text-gray-900"><?= htmlspecialchars($order['Address']) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="space-y-6">
                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Customer Info</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($order['CustomerName'] ?? 'N/A') ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($order['Email'] ?? 'N/A') ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Customer ID</p>
                            <p class="text-sm font-medium text-gray-900">#<?= $order['UID'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Status</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Order Status</p>
                            <?php
                            $statusColors = [
                                'Chờ xác nhận' => 'bg-yellow-100 text-yellow-800',
                                'Đã xác nhận' => 'bg-blue-100 text-blue-800',
                                'Đang vận chuyển' => 'bg-purple-100 text-purple-800',
                                'Delivered' => 'bg-green-100 text-green-800',
                                'Cancelled' => 'bg-red-100 text-red-800'
                            ];
                            $statusLabels = [
                                'Chờ xác nhận' => 'Pending',
                                'Đã xác nhận' => 'Confirmed',
                                'Đang vận chuyển' => 'Shipping',
                                'Delivered' => 'Delivered',
                                'Cancelled' => 'Cancelled'
                            ];
                            ?>
                            <span
                                class="inline-block px-3 py-1 text-sm font-semibold rounded-full <?= $statusColors[$order['Status']] ?? 'bg-gray-100 text-gray-800' ?>">
                                <?= $statusLabels[$order['Status']] ?? $order['Status'] ?>
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-2">Payment Status</p>
                            <span
                                class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                                <?= $order['Transaction'] === 'Đã thanh toán' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                <?= $order['Transaction'] === 'Đã thanh toán' ? 'Paid' : 'Unpaid' ?>
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Payment Method</p>
                            <p class="text-sm font-medium text-gray-900"><?= $order['PaymentMethod'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Timeline</h2>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-blue-600 rounded-full mt-1.5"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Order Placed</p>
                                <p class="text-xs text-gray-500"><?= htmlspecialchars($order['OrderDate']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/admin_footer.php'; ?>