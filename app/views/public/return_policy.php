<?php
$pageTitle = 'Return Policy - Book Store';
$pageDescription = 'Learn about our book return and refund policy. Easy returns within 14 days of purchase.';
$pageKeywords = 'return policy, refund policy, book returns, money back guarantee';
$canonicalUrl = 'http://localhost/volta/public/return-policy';

include __DIR__ . '/../layouts/public_header.php';
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Return Policy</h1>
                <p class="text-gray-600">Effective Date: January 1, 2024</p>
            </div>

            <!-- Introduction -->
            <section class="mb-8">
                <p class="text-gray-700 leading-relaxed">
                    We want you to be completely satisfied with your purchase. If you're not happy with your book(s),
                    we offer a simple return process within our specified timeframe.
                </p>
            </section>

            <!-- Return Period -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">1. Return Period</h2>
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-gray-700 font-semibold text-lg">
                        <strong class="text-green-700">14 Days</strong> from the date of delivery
                    </p>
                    <p class="text-gray-600 mt-2">
                        Returns must be initiated within this period to be eligible for a refund or exchange.
                    </p>
                </div>
            </section>

            <!-- Eligible Returns -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">2. Eligible Returns</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold text-lg mb-2 text-green-600">✓ Accepted Returns</h3>
                        <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                            <li>Books in unused, original condition</li>
                            <li>Books with original packaging and all materials intact</li>
                            <li>Books without writing, highlighting, or damage</li>
                            <li>Unopened shrink-wrapped items</li>
                            <li>Wrong item received</li>
                            <li>Changed your mind (within 14 days)</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-semibold text-lg mb-2 text-red-600">✗ Non-Returnable Items</h3>
                        <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                            <li>Books with visible signs of use (bent pages, markings, etc.)</li>
                            <li>Books purchased more than 14 days ago</li>
                            <li>Digital downloads or eBooks</li>
                            <li>Clearance or final sale items</li>
                            <li>Gift cards or vouchers</li>
                            <li>Items without proof of purchase</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Return Process -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">3. How to Return an Item</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div
                            class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">
                            1</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Request Return Authorization</h3>
                            <p class="text-gray-700">Contact us at <a href="mailto:returns@bookstore.com"
                                    class="text-indigo-600 hover:underline">returns@bookstore.com</a> with your order
                                number and reason for return</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">
                            2</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Receive Return Instructions</h3>
                            <p class="text-gray-700">We'll email you a return authorization number and shipping
                                instructions within 24 hours</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">
                            3</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Package and Ship</h3>
                            <p class="text-gray-700">Pack the item securely in original packaging and ship to our return
                                center using the provided label</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">
                            4</div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Inspection and Refund</h3>
                            <p class="text-gray-700">Once received, we'll inspect the item and process your refund
                                within 5-7 business days</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Refund Information -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">4. Refund Information</h2>
                <div class="space-y-4 text-gray-700">
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h3 class="font-semibold mb-2">Refund Method</h3>
                        <p>Refunds will be issued to your original payment method</p>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-4">
                        <h3 class="font-semibold mb-2">Processing Time</h3>
                        <p>5-7 business days after we receive and inspect your return</p>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-4">
                        <h3 class="font-semibold mb-2">Refund Amount</h3>
                        <p>Full purchase price (excluding original shipping costs unless item was defective)</p>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-4">
                        <h3 class="font-semibold mb-2">Bank Processing</h3>
                        <p>Additional 3-5 business days for the refund to appear in your account</p>
                    </div>
                </div>
            </section>

            <!-- Shipping Costs -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">5. Return Shipping Costs</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-2 text-green-700">We Pay Shipping</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Defective or damaged items</li>
                            <li>Wrong item sent</li>
                            <li>Our error</li>
                        </ul>
                    </div>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-2 text-orange-700">You Pay Shipping</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Changed your mind</li>
                            <li>Ordered wrong item</li>
                            <li>No longer needed</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Exchanges -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">6. Exchanges</h2>
                <p class="text-gray-700 mb-4">
                    We currently do not offer direct exchanges. If you need a different book:
                </p>
                <ol class="list-decimal list-inside space-y-2 ml-4 text-gray-700">
                    <li>Return the original item for a refund</li>
                    <li>Place a new order for the desired book</li>
                    <li>We'll process both transactions as quickly as possible</li>
                </ol>
            </section>

            <!-- Contact Information -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">7. Questions?</h2>
                <div class="bg-gray-50 rounded-lg p-6">
                    <p class="text-gray-700 mb-4">Our customer service team is here to help:</p>
                    <div class="space-y-2">
                        <p class="text-gray-700">
                            <strong>Email:</strong> <a href="mailto:returns@bookstore.com"
                                class="text-indigo-600 hover:underline">returns@bookstore.com</a>
                        </p>
                        <p class="text-gray-700">
                            <strong>Phone:</strong> (028) 1234-5678 (Mon-Fri, 9 AM - 6 PM)
                        </p>
                        <p class="text-gray-700">
                            <strong>Live Chat:</strong> Available on our website during business hours
                        </p>
                    </div>
                </div>
            </section>

            <!-- Footer Links -->
            <div class="border-t pt-6 flex justify-between items-center">
                <a href="/volta/public/warranty-policy" class="text-indigo-600 hover:underline">
                    View Warranty Policy →
                </a>
                <a href="/volta/public/" class="text-gray-600 hover:text-gray-800">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>