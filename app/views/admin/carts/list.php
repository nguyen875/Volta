<?php $pageTitle = 'Order Management'; ?>
<?php
include __DIR__ . '/../../layouts/admin_header.php';
require_once __DIR__ . '/../../../helpers/Icons.php';
?>

<div class="list-container">
    <div class="list-content">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="list-header">Order</h1>
            <p class="text-gray-600 mt-2">View and manage customer orders with revenue statistics</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Revenue</p>
                        <p class="text-2xl font-bold text-green-600">
                            <?= number_format($stats['TotalRevenue'] ?? 0, 0, ',', '.') ?> ₫
                        </p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <?= Icons::money('w-8 h-8 text-green-600') ?>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Orders</p>
                        <p class="text-2xl font-bold text-blue-600"><?= $stats['TotalOrders'] ?? 0 ?></p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <?= Icons::shoppingBag('w-8 h-8 text-blue-600') ?>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Completed</p>
                        <p class="text-2xl font-bold text-teal-600"><?= $stats['CompletedOrders'] ?? 0 ?></p>
                    </div>
                    <div class="bg-teal-100 rounded-full p-3">
                        <?= Icons::checkCircle('w-8 h-8 text-teal-600') ?>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Cancelled</p>
                        <p class="text-2xl font-bold text-red-600"><?= $stats['CancelledOrders'] ?? 0 ?></p>
                    </div>
                    <div class="bg-red-100 rounded-full p-3">
                        <?= Icons::xCircle('w-8 h-8 text-red-600') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="/volta/public/carts" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>"
                        placeholder="" class="form-input">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>"
                        placeholder="" class="form-input">
                </div>
                <div class="min-w-[120px]">
                    <label class="form-label">Per Page</label>
                    <select name="per_page" class="form-input">
                        <option value="10" <?= ($pagination['per_page'] ?? 10) == 10 ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= ($pagination['per_page'] ?? 10) == 25 ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= ($pagination['per_page'] ?? 10) == 50 ? 'selected' : '' ?>>50</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 inline-flex items-center">
                        <?= Icons::filter('w-4 h-4 mr-2') ?>
                        Filter
                    </button>
                    <a href="/volta/public/carts"
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 inline-flex items-center">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="list-table-wrapper">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="table-header">Order ID</th>
                            <th class="table-header">Customer</th>
                            <th class="table-header">Order Date</th>
                            <th class="table-header">Total Amount</th>
                            <th class="table-header">Payment</th>
                            <th class="table-header">Status</th>
                            <th class="table-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="7" class="table-cell-center">
                                    <?= Icons::document('mx-auto h-12 w-12 text-gray-400') ?>
                                    <p class="mt-2">No orders found</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr class="hover:bg-gray-50" id="order-<?= $order['Order_ID'] ?>">
                                    <td class="table-cell">
                                        <span class="text-sm font-medium text-gray-900">#<?= $order['Order_ID'] ?></span>
                                    </td>
                                    <td class="table-cell-wrap">
                                        <div class="table-cell-text font-medium">
                                            <?= htmlspecialchars($order['CustomerName'] ?? $order['ReceiverName'] ?? 'N/A') ?>
                                        </div>
                                        <div class="table-cell-text-secondary"><?= htmlspecialchars($order['Email'] ?? '') ?>
                                        </div>
                                    </td>
                                    <td class="table-cell table-cell-text-secondary">
                                        <?= htmlspecialchars($order['OrderDate']) ?>
                                    </td>
                                    <td class="table-cell">
                                        <div class="table-cell-text font-semibold text-purple-600">
                                            <?= number_format($order['Bill'], 0, ',', '.') ?> ₫</div>
                                        <?php if ($order['DiscountCoupon']): ?>
                                            <div class="table-cell-text-small text-green-600">
                                                <?= Icons::tag('w-3 h-3 inline') ?>
                                                <?= htmlspecialchars($order['DiscountCoupon']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="table-cell">
                                        <?php
                                        $paymentColors = [
                                            'Paid' => 'bg-green-100 text-green-800',
                                            'Unpaid' => 'bg-yellow-100 text-yellow-800',
                                            'Cancelled' => 'bg-red-100 text-red-800'
                                        ];
                                        ?>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full <?= $paymentColors[$order['Transaction']] ?? 'bg-gray-100 text-gray-800' ?>">
                                            <?= htmlspecialchars($order['Transaction']) ?>
                                        </span>
                                        <div class="table-cell-text-small mt-1"><?= htmlspecialchars($order['PaymentMethod']) ?>
                                        </div>
                                    </td>
                                    <td class="table-cell">
                                        <?php
                                        $statusColors = [
                                            'Pending' => 'bg-yellow-100 text-yellow-800',
                                            'Confirmed' => 'bg-blue-100 text-blue-800',
                                            'Delivering' => 'bg-purple-100 text-purple-800',
                                            'Delivered' => 'bg-green-100 text-green-800',
                                            'Cancelled' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusIcons = [
                                            'Pending' => '⏳',
                                            'Confirmed' => '✓',
                                            'Delivering' => '🚚',
                                            'Delivered' => '✅',
                                            'Cancelled' => '❌'
                                        ];
                                        ?>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full <?= $statusColors[$order['Status']] ?? 'bg-gray-100 text-gray-800' ?>">
                                            <?= $statusIcons[$order['Status']] ?? '' ?>
                                            <?= htmlspecialchars($order['Status']) ?>
                                        </span>
                                    </td>
                                    <td class="table-cell table-cell-text">
                                        <div class="flex items-center gap-2">
                                            <a href="/volta/public/carts/view/<?= $order['Order_ID'] ?>"
                                                class="text-blue-600 hover:text-blue-900 font-medium inline-flex items-center text-sm">
                                                <?= Icons::view('w-4 h-4 mr-1') ?>
                                                View
                                            </a>
                                            <a href="/volta/public/carts/edit/<?= $order['Order_ID'] ?>"
                                                class="text-green-600 hover:text-green-900 font-medium inline-flex items-center text-sm">
                                                <?= Icons::edit('w-4 h-4 mr-1') ?>
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($pagination['total_pages'] > 1): ?>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- Results info -->
                        <div class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">
                                <?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?>
                            </span>
                            to
                            <span class="font-medium">
                                <?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total_records']) ?>
                            </span>
                            of
                            <span class="font-medium"><?= $pagination['total_records'] ?></span>
                            results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex items-center gap-2">
                            <?php
                            $queryParams = $_GET;
                            unset($queryParams['page']);
                            $baseQuery = http_build_query($queryParams);
                            $baseUrl = '/volta/public/carts?' . ($baseQuery ? $baseQuery . '&' : '');
                            ?>

                            <!-- Previous button -->
                            <?php if ($pagination['current_page'] > 1): ?>
                                <a href="<?= $baseUrl ?>page=<?= $pagination['current_page'] - 1 ?>"
                                    class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Previous
                                </a>
                            <?php else: ?>
                                <span
                                    class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                                    Previous
                                </span>
                            <?php endif; ?>

                            <!-- Page numbers -->
                            <div class="hidden sm:flex gap-2">
                                <?php
                                $startPage = max(1, $pagination['current_page'] - 2);
                                $endPage = min($pagination['total_pages'], $pagination['current_page'] + 2);

                                // Always show first page
                                if ($startPage > 1): ?>
                                    <a href="<?= $baseUrl ?>page=1"
                                        class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        1
                                    </a>
                                    <?php if ($startPage > 2): ?>
                                        <span class="px-3 py-2 text-sm font-medium text-gray-700">...</span>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- Page range -->
                                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <?php if ($i == $pagination['current_page']): ?>
                                        <span
                                            class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md">
                                            <?= $i ?>
                                        </span>
                                    <?php else: ?>
                                        <a href="<?= $baseUrl ?>page=<?= $i ?>"
                                            class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                            <?= $i ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <!-- Always show last page -->
                                <?php if ($endPage < $pagination['total_pages']): ?>
                                    <?php if ($endPage < $pagination['total_pages'] - 1): ?>
                                        <span class="px-3 py-2 text-sm font-medium text-gray-700">...</span>
                                    <?php endif; ?>
                                    <a href="<?= $baseUrl ?>page=<?= $pagination['total_pages'] ?>"
                                        class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        <?= $pagination['total_pages'] ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Next button -->
                            <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                <a href="<?= $baseUrl ?>page=<?= $pagination['current_page'] + 1 ?>"
                                    class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Next
                                </a>
                            <?php else: ?>
                                <span
                                    class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                                    Next
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/../../layouts/admin_footer.php'; ?>