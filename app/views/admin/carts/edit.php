<?php $pageTitle = 'Edit Order #' . $order['Order_ID']; ?>
<?php
include __DIR__ . '/../../layouts/admin_header.php';
require_once __DIR__ . '/../../../helpers/Icons.php';
?>

<div class="form-background">
    <div class="form-container form-container-small">
        <div class="form-header">
            <h1 class="form-title">Edit Order #<?= $order['Order_ID'] ?></h1>
            <a href="/volta/public/carts/view/<?= $order['Order_ID'] ?>" class="form-back-link">← Return to order
                details</a>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="/volta/public/carts/update/<?= $order['Order_ID'] ?>" class="space-y-6">
            <!-- Order Information (Read-only) -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-3">Order Information</h3>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-medium text-gray-800 ml-2">#<?= $order['Order_ID'] ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Order Date:</span>
                        <span class="font-medium text-gray-800 ml-2"><?= htmlspecialchars($order['OrderDate']) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Customer:</span>
                        <span
                            class="font-medium text-gray-800 ml-2"><?= htmlspecialchars($order['ReceiverName']) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Total Amount:</span>
                        <span class="font-medium text-gray-800 ml-2"><?= number_format($order['Bill'], 0, ',', '.') ?>
                            ₫</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Payment Method:</span>
                        <span
                            class="font-medium text-gray-800 ml-2"><?= htmlspecialchars($order['PaymentMethod']) ?></span>
                    </div>
                </div>
            </div>

            <div class="form-grid">
                <!-- Payment Status -->
                <div>
                    <label class="form-label">
                        Payment Status <span class="required">*</span>
                    </label>
                    <select name="payment_status" required class="form-select">
                        <?php foreach ($paymentStatuses as $value => $label): ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= $order['Transaction'] === $value ? 'selected' : '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Update whether payment has been received</p>
                </div>

                <!-- Order Status -->
                <div>
                    <label class="form-label">
                        Order Status <span class="required">*</span>
                    </label>
                    <select name="order_status" required class="form-select">
                        <?php foreach ($orderStatuses as $value => $label): ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= $order['Status'] === $value ? 'selected' : '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Update the order fulfillment status</p>
                </div>
            </div>

            <!-- Info Box -->
            <div class="form-info-box">
                <?= Icons::infoCircle('form-info-icon') ?>
                <div>
                    <p class="form-info-title">Note</p>
                    <p class="form-info-text">Only payment status and order status can be modified. Other order details
                        cannot be changed.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="/volta/public/carts/view/<?= $order['Order_ID'] ?>" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">
                    <?= Icons::check('btn-icon') ?>
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/admin_footer.php'; ?>