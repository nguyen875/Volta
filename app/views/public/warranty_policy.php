<?php
$pageTitle = 'Warranty Policy - Book Store';
$pageDescription = 'Learn about our book warranty and replacement policy. We ensure quality products and customer satisfaction.';
$pageKeywords = 'warranty policy, book warranty, product guarantee, quality assurance';
$canonicalUrl = 'http://localhost/volta/public/warranty-policy';

include __DIR__ . '/../layouts/public_header.php';
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Warranty Policy</h1>
                <p class="text-gray-600">Effective Date: January 1, 2024</p>
            </div>

            <!-- Introduction -->
            <section class="mb-8">
                <p class="text-gray-700 leading-relaxed">
                    At Book Store, we are committed to providing high-quality books and ensuring customer satisfaction.
                    This warranty policy outlines our commitment to replacing defective or damaged products.
                </p>
            </section>

            <!-- Product Coverage -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">1. Product Coverage</h2>
                <div class="space-y-4 text-gray-700">
                    <div>
                        <h3 class="font-semibold text-lg mb-2">1.1 Covered Items</h3>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>All books sold through Book Store</li>
                            <li>Physical defects in manufacturing (torn pages, missing pages, incorrect binding)</li>
                            <li>Printing errors (unreadable text, missing sections)</li>
                            <li>Damaged books received during shipping</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-semibold text-lg mb-2">1.2 Not Covered</h3>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Normal wear and tear from regular use</li>
                            <li>Damage caused by misuse, accidents, or improper storage</li>
                            <li>Books damaged after delivery acceptance</li>
                            <li>Used or second-hand books (unless specifically stated)</li>
                            <li>Digital or downloadable products</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Warranty Period -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">2. Warranty Period</h2>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <p class="text-gray-700">
                        <strong class="text-blue-700">30 Days</strong> from the date of delivery for manufacturing
                        defects
                    </p>
                    <p class="text-gray-700 mt-2">
                        <strong class="text-blue-700">7 Days</strong> for shipping damage claims (must be reported
                        immediately upon receipt)
                    </p>
                </div>
            </section>

            <!-- Claim Process -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">3. How to Make a Warranty Claim</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div
                            class="bg-purple-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">
                            1</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Contact Customer Service</h3>
                            <p class="text-gray-700">Email us at <a href="mailto:warranty@bookstore.com"
                                    class="text-purple-600 hover:underline">warranty@bookstore.com</a> or call (028)
                                1234-5678</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="bg-purple-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">
                            2</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Provide Required Information</h3>
                            <ul class="list-disc list-inside text-gray-700 ml-4">
                                <li>Order number</li>
                                <li>Photos of the defect or damage</li>
                                <li>Description of the issue</li>
                                <li>Date of purchase and delivery</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="bg-purple-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">
                            3</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Review and Approval</h3>
                            <p class="text-gray-700">Our team will review your claim within 2-3 business days</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="bg-purple-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">
                            4</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Replacement or Refund</h3>
                            <p class="text-gray-700">Approved claims will receive a replacement book or full refund
                                within 7-10 business days</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Replacement Options -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">4. Replacement Options</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-2 text-purple-600">Option 1: Replacement</h3>
                        <p class="text-gray-700">We will send you a new copy of the same book at no additional cost,
                            including free shipping.</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-2 text-purple-600">Option 2: Refund</h3>
                        <p class="text-gray-700">Full refund to your original payment method if replacement is not
                            available or preferred.</p>
                    </div>
                </div>
            </section>

            <!-- Important Notes -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">5. Important Notes</h2>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        <li>Defective books must be returned in their original condition</li>
                        <li>Customer is responsible for return shipping costs unless item arrived damaged</li>
                        <li>Warranty claims must include proof of purchase (order confirmation)</li>
                        <li>Replacement books may be different editions if original is out of stock</li>
                        <li>International orders may have extended processing times</li>
                    </ul>
                </div>
            </section>

            <!-- Contact Information -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">6. Contact Us</h2>
                <div class="bg-gray-50 rounded-lg p-6">
                    <p class="text-gray-700 mb-4">For warranty claims and questions:</p>
                    <div class="space-y-2">
                        <p class="text-gray-700">
                            <strong>Email:</strong> <a href="mailto:warranty@bookstore.com"
                                class="text-purple-600 hover:underline">warranty@bookstore.com</a>
                        </p>
                        <p class="text-gray-700">
                            <strong>Phone:</strong> (028) 1234-5678 (Mon-Fri, 9 AM - 6 PM)
                        </p>
                        <p class="text-gray-700">
                            <strong>Address:</strong> 123 Nguyen Hue St, District 1, HCMC
                        </p>
                    </div>
                </div>
            </section>

            <!-- Footer Links -->
            <div class="border-t pt-6 flex justify-between items-center">
                <a href="/volta/public/return-policy" class="text-purple-600 hover:underline">
                    View Return Policy →
                </a>
                <a href="/volta/public/" class="text-gray-600 hover:text-gray-800">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>