<?php
$pageTitle = 'Contact Us - Book Store | Get in Touch';
$pageDescription = 'Contact Book Store for inquiries, support, or feedback. Find our store locations, phone numbers, email, and social media links.';
$pageKeywords = 'contact book store, customer service, store locations, book store support, social media';
$canonicalUrl = 'http://localhost/volta/public/contact';

include __DIR__ . '/../layouts/public_header.php';
?>

<!-- Contact Schema Markup -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact Book Store",
    "url": "<?= $canonicalUrl ?>",
    "mainEntity": {
        "@type": "BookStore",
        "name": "Book Store",
        "telephone": "+84-28-1234-5678",
        "email": "contact@bookstore.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "123 Nguyen Hue St, District 1",
            "addressLocality": "Ho Chi Minh City",
            "addressCountry": "VN"
        },
        "sameAs": [
            "https://facebook.com/bookstore",
            "https://twitter.com/bookstore",
            "https://instagram.com/bookstore",
            "https://youtube.com/bookstore",
            "https://linkedin.com/company/bookstore"
        ]
    }
}
</script>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Get in Touch</h1>
                <p class="text-lg text-gray-600">We'd love to hear from you! Reach out to us through any of these
                    channels.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Contact Information</h2>

                    <div class="space-y-6">
                        <!-- Phone -->
                        <div class="flex items-start">
                            <div class="bg-purple-100 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Phone</h3>
                                <p class="text-gray-600">Hotline: <a href="tel:+842812345678"
                                        class="text-purple-600 hover:underline">(028) 1234-5678</a></p>
                                <p class="text-gray-600">Support: <a href="tel:+842898765432"
                                        class="text-purple-600 hover:underline">(028) 9876-5432</a></p>
                                <p class="text-sm text-gray-500 mt-1">Mon-Fri: 9 AM - 6 PM</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="bg-blue-100 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                                <p class="text-gray-600">General: <a href="mailto:contact@bookstore.com"
                                        class="text-blue-600 hover:underline">contact@bookstore.com</a></p>
                                <p class="text-gray-600">Support: <a href="mailto:support@bookstore.com"
                                        class="text-blue-600 hover:underline">support@bookstore.com</a></p>
                                <p class="text-gray-600">Sales: <a href="mailto:sales@bookstore.com"
                                        class="text-blue-600 hover:underline">sales@bookstore.com</a></p>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start">
                            <div class="bg-green-100 rounded-full p-3 mr-4">
                                <?= Icons::location('w-6 h-6 text-green-600') ?>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Main Office</h3>
                                <p class="text-gray-600">123 Nguyen Hue Street</p>
                                <p class="text-gray-600">District 1, Ho Chi Minh City</p>
                                <p class="text-gray-600">Vietnam</p>
                                <a href="https://www.google.com/maps/search/?api=1&query=123+Nguyen+Hue+Street+District+1+Ho+Chi+Minh+City"
                                    target="_blank" class="text-green-600 hover:underline text-sm mt-1 inline-block">
                                    View on Map →
                                </a>
                            </div>
                        </div>

                        <!-- Business Hours -->
                        <div class="flex items-start">
                            <div class="bg-orange-100 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Business Hours</h3>
                                <p class="text-gray-600">Monday - Friday: 8:00 AM - 9:00 PM</p>
                                <p class="text-gray-600">Saturday - Sunday: 9:00 AM - 8:00 PM</p>
                                <p class="text-gray-600 text-sm mt-1">Public Holidays: 9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Follow Us on Social Media</h2>

                    <p class="text-gray-600 mb-6">Stay connected and get the latest updates, promotions, and book
                        recommendations!</p>

                    <div class="space-y-4">
                        <!-- Facebook -->
                        <a href="https://facebook.com/bookstore" target="_blank" rel="noopener noreferrer"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition group">
                            <div class="bg-blue-600 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 group-hover:text-blue-600">Facebook</h3>
                                <p class="text-sm text-gray-600">@BookStore</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Instagram -->
                        <a href="https://instagram.com/bookstore" target="_blank" rel="noopener noreferrer"
                            class="flex items-center p-4 bg-pink-50 rounded-lg hover:bg-pink-100 transition group">
                            <div
                                class="bg-gradient-to-br from-purple-600 via-pink-600 to-orange-600 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 group-hover:text-pink-600">Instagram</h3>
                                <p class="text-sm text-gray-600">@BookStore</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- X (Twitter) -->
                        <a href="https://x.com/bookstore" target="_blank" rel="noopener noreferrer"
                            class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition group">
                            <div class="bg-black rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 group-hover:text-gray-900">X (Twitter)</h3>
                                <p class="text-sm text-gray-600">@BookStore</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- YouTube -->
                        <a href="https://youtube.com/bookstore" target="_blank" rel="noopener noreferrer"
                            class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition group">
                            <div class="bg-red-600 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 group-hover:text-red-600">YouTube</h3>
                                <p class="text-sm text-gray-600">@BookStore</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- LinkedIn -->
                        <a href="https://linkedin.com/company/bookstore" target="_blank" rel="noopener noreferrer"
                            class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition group">
                            <div class="bg-indigo-700 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600">LinkedIn</h3>
                                <p class="text-sm text-gray-600">Book Store Company</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- TikTok -->
                        <a href="https://tiktok.com/@bookstore" target="_blank" rel="noopener noreferrer"
                            class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition group">
                            <div class="bg-gray-900 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 group-hover:text-gray-900">TikTok</h3>
                                <p class="text-sm text-gray-600">@BookStore</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Quick Links</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="/volta/public/warranty-policy"
                        class="text-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition">
                        <div class="text-3xl mb-2">📋</div>
                        <p class="font-semibold text-gray-800">Warranty Policy</p>
                    </a>
                    <a href="/volta/public/return-policy"
                        class="text-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition">
                        <div class="text-3xl mb-2">↩️</div>
                        <p class="font-semibold text-gray-800">Return Policy</p>
                    </a>
                    <a href="/volta/public/#locations"
                        class="text-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition">
                        <div class="text-3xl mb-2">📍</div>
                        <p class="font-semibold text-gray-800">Store Locations</p>
                    </a>
                    <a href="/volta/public/#careers"
                        class="text-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition">
                        <div class="text-3xl mb-2">💼</div>
                        <p class="font-semibold text-gray-800">Careers</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/public_footer.php'; ?>