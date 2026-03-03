<?php $pageTitle = isset($product) ? 'Update Product' : 'Add New Product'; ?>
<?php
include __DIR__ . '/../../layouts/admin_header.php';
require_once __DIR__ . '/../../../helpers/Icons.php';
require_once __DIR__ . '/../../../dao/ProductDAO.php';
?>

<?php
// Determine if we're in edit mode or create mode
$isEditMode = isset($product) && $product !== null;
$formAction = $isEditMode
    ? "/volta/public/products/update/{$product->getId()}"
    : "/volta/public/products/store";
$submitButtonText = $isEditMode ? 'Update' : 'Create Product';
$pageHeading = $isEditMode ? "Edit Product #{$product->getId()}" : 'Add New Product';
?>

<div class="form-background">
    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title"><?= $pageHeading ?></h1>
            <a href="/volta/public/products" class="form-back-link">← Return to List</a>
        </div>

        <form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="form-grid">
                <!-- Product Image -->
                <div class="form-field-full">
                    <label class="form-label">Product Image</label>
                    <?php if ($isEditMode):
                        $productImages = $product->getId() ? (new ProductDAO())->getProductImages($product->getId()) : [];
                        ?>
                        <?php if (!empty($productImages)): ?>
                            <div class="mb-2">
                                <p class="text-sm text-gray-600 mb-2">Current images:</p>
                                <div class="grid grid-cols-4 gap-2">
                                    <?php foreach ($productImages as $image): ?>
                                        <div class="relative group">
                                            <img src="/volta/<?= htmlspecialchars($image['path']) ?>" alt="Product image"
                                                class="h-24 w-full object-contain rounded border bg-gray-50">
                                            <button type="button"
                                                onclick="deleteProductImage(<?= $product->getId() ?>, <?= $image['id'] ?>, this)"
                                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700"
                                                title="Delete image">
                                                ✕
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 mb-2">No image uploaded yet</p>
                        <?php endif; ?>
                    <?php endif; ?>
                    <input type="file" name="image" id="product_image"
                        accept="image/jpeg,image/png,image/gif,image/jpg,image/webp" class="form-input"
                        onchange="previewImage(this)">
                    <p class="text-sm text-gray-500 mt-1">JPG, PNG, GIF or WebP (max 5MB).</p>

                    <!-- Image Preview -->
                    <div id="image_preview" class="mt-2 hidden">
                        <p class="text-sm text-gray-600 mb-1">Preview:</p>
                        <img id="preview_img" src="" alt="Preview" class="h-32 w-auto object-contain border rounded">
                    </div>
                </div>

                <!-- Product Name -->
                <div class="form-field-full">
                    <label class="form-label">Product Name <span class="required">*</span></label>
                    <input type="text" name="productName" required
                        value="<?= $isEditMode ? htmlspecialchars($product->getProductName()) : '' ?>"
                        class="form-input">
                </div>

                <!-- Description -->
                <div class="form-field-full">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4"
                        class="form-textarea"><?= $isEditMode ? htmlspecialchars($product->getDescription()) : '' ?></textarea>
                </div>

                <!-- Author -->
                <div>
                    <label class="form-label">Author</label>
                    <input type="text" name="author"
                        value="<?= $isEditMode ? htmlspecialchars($product->getAuthor()) : '' ?>" class="form-input">
                </div>

                <!-- Publisher -->
                <div>
                    <label class="form-label">Publisher</label>
                    <input type="text" name="publisher"
                        value="<?= $isEditMode ? htmlspecialchars($product->getPublisher()) : '' ?>" class="form-input">
                </div>

                <!-- Price -->
                <div>
                    <label class="form-label">Price (VNĐ) <span class="required">*</span></label>
                    <input type="number" name="price" required min="0"
                        value="<?= $isEditMode ? $product->getPrice() : '0' ?>" class="form-input">
                </div>

                <!-- Discount Rate -->
                <div>
                    <label class="form-label">Discount Rate (%)</label>
                    <input type="number" name="discountRate" min="0" max="100" step="0.01"
                        value="<?= $isEditMode ? $product->getDiscountRate() : '0' ?>" class="form-input">
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label class="form-label">Stock Quantity <span class="required">*</span></label>
                    <input type="number" name="quantity" required min="0"
                        value="<?= $isEditMode ? $product->getQuantity() : '0' ?>" class="form-input">
                </div>

                <!-- Number of Pages -->
                <div>
                    <label class="form-label">Number of Pages</label>
                    <input type="number" name="pageNum" min="0"
                        value="<?= $isEditMode ? $product->getPageNum() : '0' ?>" class="form-input">
                </div>

                <!-- Size -->
                <div>
                    <label class="form-label">Size</label>
                    <input type="text" name="size" placeholder="e.g., 14.5 x 20.5 cm"
                        value="<?= $isEditMode ? htmlspecialchars($product->getSize()) : '' ?>" class="form-input">
                </div>

                <!-- Year of Publication -->
                <div>
                    <label class="form-label">Year of Publication</label>
                    <input type="number" name="yearOfPublication" min="0" max="2100"
                        value="<?= $isEditMode ? $product->getYearOfPublication() : '2025' ?>" class="form-input">
                </div>

                <!-- Category -->
                <div>
                    <label class="form-label">Category</label>
                    <input type="text" name="category" placeholder="e.g., Literature, Self-help..."
                        value="<?= $isEditMode ? htmlspecialchars($product->getCategory()) : '' ?>" class="form-input">
                </div>

                <!-- Format -->
                <div>
                    <label class="form-label">Format</label>
                    <input type="text" name="format" placeholder="e.g., Paperback, Hardcover..."
                        value="<?= $isEditMode ? htmlspecialchars($product->getFormat()) : '' ?>" class="form-input">
                </div>

                <!-- Language -->
                <div>
                    <label class="form-label">Language</label>
                    <input type="text" name="language"
                        value="<?= $isEditMode ? htmlspecialchars($product->getLanguage()) : 'Tiếng Việt' ?>"
                        class="form-input">
                </div>

                <!-- Keywords -->
                <div>
                    <label class="form-label">Keywords</label>
                    <input type="text" name="keywords" placeholder="Separate with commas"
                        value="<?= $isEditMode ? htmlspecialchars($product->getKeywords()) : '' ?>" class="form-input">
                </div>

                <!-- Status -->
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Available" <?= $isEditMode && $product->getStatus() === 'Available' ? 'selected' : '' ?>>Available</option>
                        <option value="Hidden" <?= $isEditMode && $product->getStatus() === 'Hidden' ? 'selected' : '' ?>>
                            Hidden</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="/volta/public/products" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">
                    <?= $isEditMode ? Icons::check('btn-icon') : Icons::add('btn-icon') ?>
                    <?= $submitButtonText ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/volta/public/javascript/product.js"></script>

<?php include __DIR__ . '/../../layouts/admin_footer.php'; ?>