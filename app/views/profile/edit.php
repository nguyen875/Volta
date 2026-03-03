<?php
require_once __DIR__ . '/../../helpers/Auth.php';
Auth::requireLogin();

$pageTitle = 'My Profile';
include __DIR__ . '/../layouts/public_header.php';
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">My Profile</h1>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?= htmlspecialchars($_SESSION['success']);
                        unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?= htmlspecialchars($_SESSION['error']);
                        unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/volta/public/profile">
                    <!-- User Info (Read-only) -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-semibold text-gray-700 mb-3">Account Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-600">Name</label>
                                <p class="font-medium text-gray-800">
                                    <?= htmlspecialchars($customer['Name'] ?? $_SESSION['Name']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600">Email</label>
                                <p class="font-medium text-gray-800"><?= htmlspecialchars($customer['Email'] ?? '') ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Editable Fields -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-700 mb-3">Default Shipping Information</h3>
                        <p class="text-sm text-gray-600 mb-4">This information will be used as default when placing
                            orders</p>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Phone Number
                            </label>
                            <input type="tel" name="phone" value="<?= htmlspecialchars($customer['PhoneNum'] ?? '') ?>"
                                placeholder="Enter your phone number"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Address
                            </label>
                            <textarea name="address" rows="3" placeholder="Enter your full address"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"><?= htmlspecialchars($customer['Address'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                            Save Changes
                        </button>
                        <a href="/volta/public/"
                            class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition inline-block">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>