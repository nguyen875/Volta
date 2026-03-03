<?php
$pageTitle = htmlspecialchars($product->getProductName()) . ' by ' . htmlspecialchars($product->getAuthor()) . ' - Book Store';
$pageDescription = substr(strip_tags($product->getDescription()), 0, 160) . '...';
$pageKeywords = htmlspecialchars($product->getKeywords()) . ', ' . htmlspecialchars($product->getAuthor()) . ', ' . htmlspecialchars($product->getCategory());
$ogImage = $firstImage ? 'http://localhost/volta/' . $firstImage : 'http://localhost/volta/public/image/WebLogo.png';
$canonicalUrl = 'http://localhost/volta/public/shop/product/' . $product->getId();

include __DIR__ . '/../layouts/public_header.php';
?>

<!-- Product Schema Markup -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Book",
    "name": "<?= htmlspecialchars($product->getProductName()) ?>",
    "author": {
        "@type": "Person",
        "name": "<?= htmlspecialchars($product->getAuthor()) ?>"
    },
    "publisher": {
        "@type": "Organization",
        "name": "<?= htmlspecialchars($product->getPublisher()) ?>"
    },
    "description": "<?= htmlspecialchars(substr(strip_tags($product->getDescription()), 0, 200)) ?>",
    "image": "<?= $ogImage ?>",
    "offers": {
        "@type": "Offer",
        "price": "<?= $product->getPrice() * (1 - $product->getDiscountRate() / 100) ?>",
        "priceCurrency": "VND",
        "availability": "<?= $product->getQuantity() > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>",
        "url": "<?= $canonicalUrl ?>"
    },
    "isbn": "<?= $product->getId() ?>",
    "numberOfPages": "<?= $product->getPageNum() ?>",
    "inLanguage": "<?= htmlspecialchars($product->getLanguage()) ?>",
    "bookFormat": "<?= htmlspecialchars($product->getFormat()) ?>",
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.5",
        "reviewCount": "10"
    }
}
</script>

<div class="min-h-screen bg-gray-100 py-8">
    // ...existing product detail code...
</div>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>