# Volta - Online Electronic E-commerce Website

A comprehensive e-commerce platform for managing and selling electronics online, built with PHP, MySQL, and modern web technologies.

---

## 🌟 Features

### 👥 User Management
- **Role-based Access Control**: Admin and Customer roles
- **Secure Authentication**: 
  - Login/Signup with password hashing (bcrypt)
  - Session management with 30-minute timeout
  - 401 error pages for unauthorized access
- **Customer Profiles**: 
  - Set default shipping information (phone & address)
  - Profile editing for customers
  - Auto-fill checkout forms with saved data

### 📦 Product Management (Admin)
- **CRUD Operations**: Create, Read, Update, Delete products
- **Product Details**:
  - Name, Author, Publisher, Category
  - Price with discount rate support
  - Stock quantity tracking
  - ISBN, Page count, Language, Format
  - Multiple keywords and descriptions
- **Image Management**:
  - Multiple images per product
  - Set primary image
  - Upload/Delete images
  - Fallback placeholder images

### 🛍️ Shopping Experience
- **Product Catalog**:
  - Browse all books with pagination
  - Search by title, author, or keywords
  - Filter by category
  - Real-time stock status (In Stock/Low Stock/Out of Stock)
- **Shopping Cart**:
  - Add/Remove products
  - Update quantities
  - Real-time cart count
  - AJAX cart operations with notifications
- **Checkout Process**:
  - Shipping information form
  - Payment method selection (COD/Bank Transfer)
  - Discount coupon application
  - Order summary with totals

### 💰 Discount System
- **Coupon Management** (Admin):
  - Create discount codes
  - Set discount amounts
  - Define conditions (minimum order, user type, etc.)
  - Track coupon quantity and status
- **Customer Usage**:
  - Dropdown selection of active coupons
  - Real-time discount calculation
  - Automatic validation at checkout

### 📋 Order Management
- **Admin Dashboard**:
  - View all orders with filters
  - Order details with customer info
  - Update order status (Pending → Confirmed → Delivering → Delivered)
  - Update payment status (Unpaid → Paid)
  - Track order statistics
- **Customer View**:
  - Order confirmation page
  - Order history (future feature)
  - Order status tracking

### 🎨 User Interface
- **Modern Design**:
  - Tailwind CSS framework
  - Gradient backgrounds
  - Responsive layout (mobile-first)
  - Card-based product displays
- **Admin Panel**:
  - Sidebar navigation
  - Consistent form styling
  - AJAX operations with toast notifications
  - Icons library (Heroicons style)

### 🔍 SEO Optimization
1. **Meta Tags**: Title, description, keywords on all pages
2. **Open Graph**: Facebook/LinkedIn sharing optimization
3. **Twitter Cards**: Twitter sharing optimization
4. **Schema.org Markup**: 
   - BookStore structured data
   - Product/Book schema for individual products
   - Breadcrumb navigation
5. **Semantic HTML**: Proper H1, H2, H3 hierarchy
6. **Sitemap.xml**: Search engine discovery
7. **Robots.txt**: Crawl control for search engines
8. **Canonical URLs**: Prevent duplicate content
9. **Alt Text**: All images have descriptive alt attributes
10. **Internal Linking**: Footer with important links
11. **Mobile-Friendly**: Fully responsive design
12. **Performance**: Image lazy loading, optimized assets

---

## 🏗️ Architecture

### MVC Pattern
```
app/
├── controllers/     # Business logic & routing handlers
├── models/          # Data models (User, Product, Discount, etc.)
├── dao/             # Data Access Objects (database operations)
├── views/           # View templates
│   ├── admin/       # Admin panel views
│   ├── auth/        # Login/Signup pages
│   ├── shop/        # Shop, product detail, cart, checkout
│   ├── profile/     # Customer profile
│   ├── public/      # Homepage, 404, 401 pages
│   └── layouts/     # Headers & footers
├── helpers/         # Utility classes (Auth, Icons)
└── services/        # Business logic services
```

### Database Schema
- **LOGIN**: User accounts (UID, Email, Password, Role, Name)
- **ADMIN**: Admin users (references LOGIN)
- **CUSTOMER**: Customer details (references LOGIN, PhoneNum, Address)
- **PRODUCT**: Book products (Product_ID, Name, Price, Stock, etc.)
- **IMAGE**: Product images (Image_ID, ImageUrl, Product_ID)
- **DISCOUNT_COUPON**: Discount codes (Code, MoneyDeduct, Condition, Quantity)
- **ORDER**: Customer orders (Order_ID, UID, Total, Status, etc.)
- **CONTAIN**: Order items (Order_ID, Product_ID, Quantity)

---

## 🚀 Installation

### Prerequisites
- XAMPP (Apache + MySQL + PHP 7.4+)
- Web browser
- Text editor (VS Code recommended)

### Steps

1. **Clone/Download Project**
   ```bash
   cd C:\xampp\htdocs
   # Extract or clone project to 'volta' folder
   ```

2. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create database: `book_store`
   - Import schema: `config/create_db.sql`
   - Import sample data: `config/init_db.sql`

3. **Configure Database**
   - Edit `config/database.php` if needed (default: localhost, root, no password)

4. **Start XAMPP**
   - Start Apache
   - Start MySQL

5. **Access Application**
   - Homepage: `http://localhost/volta/public/`
   - Admin Panel: `http://localhost/volta/public/users`
   - Shop: `http://localhost/volta/public/shop`

### Default Accounts
```
Admin:
- Email: admin@bookstore.com
- Password: password123

Customer:
- Email: user1@example.com
- Password: password123
```

---

## 📂 File Structure

```
volta/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php              # Login/Signup logic
│   │   ├── UserController.php              # User CRUD (Admin)
│   │   ├── ProductController.php           # Product CRUD (Admin)
│   │   ├── DiscountController.php          # Discount CRUD (Admin)
│   │   ├── CartController.php              # Order management (Admin)
│   │   ├── CustomerCartController.php      # Shopping cart (Customer)
│   │   ├── ShopController.php              # Shop browsing
│   │   └── ProfileController.php           # Customer profile
│   ├── dao/
│   │   ├── UserDAO.php                     # User database operations
│   │   ├── ProductDAO.php                  # Product database operations
│   │   ├── DiscountDAO.php                 # Discount database operations
│   │   ├── CartDAO.php                     # Order database operations
│   │   └── CustomerDAO.php                 # Customer profile operations
│   ├── models/
│   │   ├── User.php                        # User model
│   │   ├── Product.php                     # Product model
│   │   └── Discount.php                    # Discount model
│   ├── views/
│   │   ├── admin/                          # Admin views
│   │   │   ├── users/                      # User management
│   │   │   ├── products/                   # Product management
│   │   │   ├── discounts/                  # Discount management
│   │   │   └── carts/                      # Order management
│   │   ├── auth/                           # Authentication
│   │   │   ├── login.php                   # Login page
│   │   │   └── signup.php                  # Signup page
│   │   ├── shop/                           # Shopping
│   │   │   ├── shop.php                    # Product listing
│   │   │   ├── product_detail.php          # Product details
│   │   │   ├── cart.php                    # Shopping cart
│   │   │   ├── checkout.php                # Checkout form
│   │   │   └── order_success.php           # Order confirmation
│   │   ├── profile/
│   │   │   └── edit.php                    # Customer profile
│   │   ├── public/
│   │   │   ├── home.php                    # Homepage
│   │   │   ├── 404.php                     # Not found error
│   │   │   └── 401.php                     # Unauthorized error
│   │   └── layouts/
│   │       ├── admin_header.php            # Admin header
│   │       ├── admin_footer.php            # Admin footer
│   │       ├── public_header.php           # Public header (with SEO)
│   │       └── public_footer.php           # Public footer
│   ├── helpers/
│   │   ├── Auth.php                        # Authentication helper
│   │   └── Icons.php                       # SVG icons library
│   └── services/                           # Business logic
├── config/
│   ├── database.php                        # PDO connection
│   ├── create_db.sql                       # Database schema
│   └── init_db.sql                         # Sample data
├── public/
│   ├── index.php                           # Router (front controller)
│   ├── css/                                # Stylesheets
│   │   ├── tailwind.min.css               # Tailwind CSS
│   │   ├── admin.css                       # Admin styles
│   │   ├── auth.css                        # Login/Signup styles
│   │   ├── homepage.css                    # Homepage styles
│   │   └── shop.css                        # Shop styles
│   ├── javascript/                         # Scripts
│   │   ├── shop.js                         # Shop functionality
│   │   └── notyf.min.js                   # Notifications
│   ├── image/                              # Images
│   │   ├── WebLogo.png                    # Site logo
│   │   └── product/                        # Product images
│   ├── sitemap.xml                         # SEO sitemap
│   └── robots.txt                          # SEO robots file
└── README.md                               # This file
```

---

## 🔐 Security Features

- ✅ **Password Hashing**: bcrypt with `PASSWORD_DEFAULT`
- ✅ **SQL Injection Prevention**: PDO prepared statements
- ✅ **XSS Protection**: `htmlspecialchars()` on all outputs
- ✅ **CSRF Protection**: Session-based authentication
- ✅ **Role-based Access**: Admin/Customer separation
- ✅ **Session Timeout**: 30-minute inactivity logout
- ✅ **Secure Logout**: Proper session destruction
- ✅ **Input Validation**: Server-side validation on all forms

---

## 🛣️ Routing

### Public Routes
- `/` - Homepage
- `/shop` - Product catalog
- `/shop/product/{id}` - Product details
- `/cart` - Shopping cart
- `/checkout` - Checkout page
- `/login` - Login page
- `/signup` - Signup page
- `/logout` - Logout action
- `/profile` - Customer profile
- `/order-success/{id}` - Order confirmation

### Admin Routes (Requires Admin Role)
- `/users` - User management
- `/users/create` - Create user
- `/users/edit/{id}` - Edit user
- `/products` - Product management
- `/products/create` - Create product
- `/products/edit/{id}` - Edit product
- `/products/{id}/images` - Manage product images
- `/discounts` - Discount management
- `/discounts/create` - Create discount
- `/discounts/edit/{id}` - Edit discount
- `/carts` - Order management
- `/carts/view/{id}` - View order details
- `/carts/edit/{id}` - Edit order status

---

## 🎯 Key Technologies

- **Backend**: PHP 7.4+ (procedural & OOP)
- **Database**: MySQL (PDO with prepared statements)
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **CSS Framework**: Tailwind CSS
- **Architecture**: MVC Pattern, DAO Pattern
- **Session Management**: PHP Sessions
- **AJAX**: Fetch API for cart operations
- **Icons**: SVG (Heroicons style)
- **SEO**: Meta tags, Open Graph, Schema.org, Sitemap

---

## 📊 Database Optimizations

- ✅ Indexed foreign keys for fast joins
- ✅ ENUM types for status fields
- ✅ Proper data types (INT, DECIMAL, TEXT, TIMESTAMP)
- ✅ CASCADE updates for discount coupons
- ✅ Unique constraints on email and coupon codes
- ✅ Auto-increment primary keys

---

## 🧪 Testing Checklist

### User Authentication
- [x] Sign up new customer account
- [x] Login with valid credentials
- [x] Login with invalid credentials (error handling)
- [x] Session timeout after 30 minutes
- [x] Logout clears session
- [x] 401 page for unauthorized access

### Shopping Flow
- [x] Browse products with pagination
- [x] Search products by keyword
- [x] View product details
- [x] Add product to cart (AJAX)
- [x] Update cart quantities
- [x] Remove items from cart
- [x] Apply discount coupon
- [x] Complete checkout
- [x] View order confirmation

### Admin Features
- [x] Create/Edit/Delete users
- [x] Create/Edit/Delete products
- [x] Upload/Delete product images
- [x] Create/Edit/Delete discounts
- [x] View order list
- [x] Update order status
- [x] Update payment status

---

## 🐛 Known Issues & Future Enhancements

### Future Features
- [ ] Customer order history page
- [ ] Product reviews and ratings
- [ ] Wishlist functionality
- [ ] Advanced search filters
- [ ] Email notifications for orders
- [ ] Payment gateway integration
- [ ] Multi-language support
- [ ] Product recommendations
- [ ] Analytics dashboard for admin

### Optimization Opportunities
- [ ] Image optimization (WebP format)
- [ ] Lazy loading for product images
- [ ] Redis/Memcached for session storage
- [ ] CDN for static assets
- [ ] Full-text search for products
- [ ] API endpoints for mobile app

---

## 📝 License

This project is created for educational purposes. All rights reserved.

---

## 👥 Credits

- **Developer**: Book Store Team
- **Framework**: Tailwind CSS
- **Icons**: Heroicons (SVG)
- **Database**: MySQL
- **Server**: XAMPP

---

## 📞 Support

For issues or questions:
- 📧 Email: contact@bookstore.com
- 📞 Phone: (028) 1234-5678
- 📍 Address: 123 Nguyen Hue St, District 1, HCMC

---

## 🔄 Version History

### v2.0.0 (Current) - Major Update
- ✅ Complete authentication system with 401 error handling
- ✅ Customer profile management
- ✅ Shopping cart with AJAX operations
- ✅ Checkout process with discount coupons
- ✅ Order management system
- ✅ SEO optimization (12+ improvements)
- ✅ Migrated from mysqli to PDO
- ✅ Improved security (password hashing, input validation)
- ✅ Modern UI with Tailwind CSS
- ✅ Responsive design for mobile/tablet/desktop

### v1.0.0 - Initial Release
- Basic CRUD operations
- User and product management
- Simple authentication

---

**Built with ❤️ for book lovers**