<?php
$pageTitle = 'Frequently Asked Questions (FAQ) - Book Store';
$pageDescription = 'Find answers to common questions about Book Store. Learn about shipping, returns, payment methods, and more.';
$pageKeywords = 'FAQ, frequently asked questions, book store help, customer support, shipping info';
$canonicalUrl = 'http://localhost/volta/public/faq';

include __DIR__ . '/../layouts/public_header.php';
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h1>
                <p class="text-lg text-gray-600">Find quick answers to common questions about our bookstore</p>
            </div>

            <!-- FAQ Categories -->
            <div class="mb-8">
                <div class="flex flex-wrap gap-2 justify-center">
                    <a href="#ordering"
                        class="px-4 py-2 bg-purple-100 text-purple-700 rounded-full hover:bg-purple-200 transition">📦
                        Ordering</a>
                    <a href="#shipping"
                        class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition">🚚
                        Shipping</a>
                    <a href="#payment"
                        class="px-4 py-2 bg-green-100 text-green-700 rounded-full hover:bg-green-200 transition">💳
                        Payment</a>
                    <a href="#returns"
                        class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full hover:bg-yellow-200 transition">↩️
                        Returns</a>
                    <a href="#account"
                        class="px-4 py-2 bg-pink-100 text-pink-700 rounded-full hover:bg-pink-200 transition">👤
                        Account</a>
                </div>
            </div>

            <!-- Ordering Questions -->
            <section id="ordering" class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <span
                        class="bg-purple-100 text-purple-600 rounded-full w-8 h-8 flex items-center justify-center mr-3">📦</span>
                    Ordering
                </h2>

                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>How do I place an order?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <ol class="list-decimal list-inside space-y-2 ml-4">
                                <li>Browse our <a href="/volta/public/shop"
                                        class="text-purple-600 hover:underline">shop</a> and find books you want</li>
                                <li>Click "Add to Cart" on each product</li>
                                <li>Review your cart and click "Proceed to Checkout"</li>
                                <li>Fill in your shipping information</li>
                                <li>Choose your payment method</li>
                                <li>Confirm and place your order</li>
                            </ol>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>Can I modify or cancel my order?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>You can modify or cancel your order within 2 hours of placement. After that, the order is
                                processed and cannot be changed. Contact our customer service at <a
                                    href="mailto:support@bookstore.com"
                                    class="text-purple-600 hover:underline">support@bookstore.com</a> or call (028)
                                1234-5678 for assistance.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>Do I need an account to place an order?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>Yes, you need to create an account to place an order. This helps you track your orders
                                and save your shipping information for future purchases. <a href="/volta/public/signup"
                                    class="text-purple-600 hover:underline">Sign up here</a> - it only takes a minute!
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Shipping Questions -->
            <section id="shipping" class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <span
                        class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3">🚚</span>
                    Shipping & Delivery
                </h2>

                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>How long does shipping take?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li><strong>HCMC area:</strong> 1-2 business days</li>
                                <li><strong>Other major cities:</strong> 2-4 business days</li>
                                <li><strong>Remote areas:</strong> 4-7 business days</li>
                            </ul>
                            <p class="mt-2">Orders placed before 2 PM are processed the same day.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>Do you offer free shipping?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>Yes! We offer <strong>FREE shipping on all orders</strong> nationwide. No minimum
                                purchase required!</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>How can I track my order?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>After your order ships, you'll receive an email with tracking information. You can also
                                check your order status by logging into your account and viewing your order history.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Payment Questions -->
            <section id="payment" class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <span
                        class="bg-green-100 text-green-600 rounded-full w-8 h-8 flex items-center justify-center mr-3">💳</span>
                    Payment Methods
                </h2>

                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>What payment methods do you accept?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li><strong>Cash on Delivery (COD)</strong> - Pay when you receive your order</li>
                                <li><strong>Bank Transfer</strong> - Direct transfer to our bank account</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>Is it safe to shop on your website?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>Absolutely! Your information is protected with industry-standard encryption. We never
                                store your payment card details on our servers. All transactions are secure and
                                confidential.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>Can I use discount coupons?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>Yes! Enter your discount code at checkout to apply it to your order. Each coupon can only
                                be used once and may have specific conditions. Check the coupon details for more
                                information.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Returns Questions -->
            <section id="returns" class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <span
                        class="bg-orange-100 text-orange-600 rounded-full w-8 h-8 flex items-center justify-center mr-3">↩️</span>
                    Returns & Refunds
                </h2>

                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>What is your return policy?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>We accept returns within <strong>14 days</strong> of delivery for books in original,
                                unused condition. See our full <a href="/volta/public/return-policy"
                                    class="text-purple-600 hover:underline">Return Policy</a> for details.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>How do I initiate a return?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>Contact our customer service at <a href="mailto:returns@bookstore.com"
                                    class="text-purple-600 hover:underline">returns@bookstore.com</a> with your order
                                number and reason for return. We'll provide you with return instructions and a return
                                authorization number.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>What if my book arrives damaged?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>We're sorry! Report damaged items within <strong>7 days</strong> of delivery with photos.
                                We'll send a replacement at no cost or provide a full refund. See our <a
                                    href="/volta/public/warranty-policy"
                                    class="text-purple-600 hover:underline">Warranty Policy</a> for more details.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Account Questions -->
            <section id="account" class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <span
                        class="bg-pink-100 text-pink-600 rounded-full w-8 h-8 flex items-center justify-center mr-3">👤</span>
                    Account & Profile
                </h2>

                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>How do I create an account?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>Click <a href="/volta/public/signup" class="text-purple-600 hover:underline">Sign Up</a>
                                and provide your name, email, and password. You'll receive a confirmation and can start
                                shopping immediately!</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>Can I save my shipping address?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>Yes! Go to your <a href="/volta/public/profile"
                                    class="text-purple-600 hover:underline">Profile</a> and add your default phone
                                number and shipping address. This information will auto-fill at checkout to save you
                                time.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button
                            class="w-full text-left p-4 font-semibold text-gray-800 hover:bg-gray-50 flex justify-between items-center"
                            onclick="toggleFAQ(this)">
                            <span>I forgot my password. What should I do?</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden p-4 pt-0 text-gray-600">
                            <p>Contact our support team at <a href="mailto:support@bookstore.com"
                                    class="text-purple-600 hover:underline">support@bookstore.com</a> or call (028)
                                1234-5678, and we'll help you reset your password.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg shadow-lg p-8 text-white text-center">
                <h3 class="text-2xl font-bold mb-2">Still Have Questions?</h3>
                <p class="mb-6 opacity-90">Our customer support team is here to help!</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/volta/public/contact"
                        class="bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        📧 Contact Us
                    </a>
                    <a href="tel:+842812345678"
                        class="bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-800 transition">
                        📞 Call: (028) 1234-5678
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/volta/public/javascript/home.js"></script>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>