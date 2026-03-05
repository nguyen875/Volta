# Volta — E-commerce REST API

A backend-only REST API for an electronics e-commerce platform, built with PHP and MySQL. All responses are JSON; there is no server-rendered HTML.

---

## Architecture

```
app/
├── controllers/     # API endpoint handlers (JSON responses)
├── dao/             # Data Access Objects (PDO queries)
├── dto/             # Data Transfer Objects (mapping & serialization)
├── models/          # Domain models
├── services/        # Business logic layer
└── helpers/
    ├── Auth.php         # Session-based auth guards
    ├── ApiResponse.php  # JSON response helpers
    └── Router.php       # Front-controller router
config/
├── db.php           # PDO singleton + session start
├── routes.php       # All route definitions
├── create_db.sql    # Database schema
└── init_db.sql      # Sample data
public/
└── index.php        # Entry point (CORS + dispatch)
```

### Layers

| Layer | Responsibility |
|---|---|
| **Controller** | Parse request, call service, return JSON |
| **Service** | Business logic, orchestrates DAOs |
| **DAO** | Raw SQL via PDO, returns plain arrays |
| **DTO** | Maps arrays ↔ typed objects, `toArray()` for serialization |

---

## Installation

### Prerequisites
- XAMPP (Apache + MySQL + PHP 8.0+)
- Composer (for `vlucas/phpdotenv`)

### Steps

1. **Clone into XAMPP**
   ```bash
   cd C:\xampp\htdocs
   git clone <repo> volta
   cd volta
   composer install
   ```

2. **Environment**
   ```bash
   cp .env.example .env
   # Edit .env with your DB credentials
   ```
   ```ini
   DB_HOST=localhost
   DB_NAME=volta
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create database: `volta`
   - Import schema: `config/create_db.sql`
   - Import sample data: `config/init_db.sql`

4. **Start XAMPP** — Apache + MySQL

5. **Base URL**: `http://localhost/volta/public`

### Default Accounts
```
Admin:    admin@volta.com   / password123
Customer: user@volta.com    / password123
```

---

## File Structure

```
volta/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php            # Login, signup, logout, /me
│   │   ├── UserController.php            # User CRUD (Admin)
│   │   ├── ProductController.php         # Product CRUD + images + relations (Admin)
│   │   ├── CategoryController.php        # Category CRUD
│   │   ├── DiscountController.php        # Discount CRUD (Admin)
│   │   ├── CartController.php            # Admin order management
│   │   ├── OrderController.php           # Full order CRUD + stats (Admin)
│   │   ├── CustomerCartController.php    # Cart + checkout (Customer)
│   │   ├── ShopController.php            # Public storefront endpoints
│   │   ├── ProfileController.php         # Profile + address management
│   │   └── BundleController.php          # Bundle CRUD + items (Admin)
│   ├── dao/
│   │   ├── BaseDAO.php                   # Generic CRUD (findAll, findById, insert, update, delete, paginate)
│   │   ├── UserDAO.php
│   │   ├── ProductDAO.php
│   │   ├── ProductImageDAO.php
│   │   ├── ProductRelationDAO.php
│   │   ├── CategoryDAO.php
│   │   ├── DiscountDAO.php
│   │   ├── OrderDAO.php
│   │   ├── OrderItemDAO.php
│   │   ├── CartDAO.php
│   │   ├── AddressDAO.php
│   │   ├── BundleDAO.php
│   │   └── BundleItemDAO.php
│   ├── dto/
│   │   ├── UserDTO.php
│   │   ├── ProductDTO.php
│   │   ├── ProductImageDTO.php
│   │   ├── ProductRelationDTO.php
│   │   ├── CategoryDTO.php
│   │   ├── DiscountDTO.php
│   │   ├── OrderDTO.php
│   │   ├── OrderItemDTO.php
│   │   ├── CartItemDTO.php
│   │   ├── AddressDTO.php
│   │   ├── BundleDTO.php
│   │   └── BundleItemDTO.php
│   ├── models/
│   │   └── (domain models)
│   ├── services/
│   │   ├── UserService.php
│   │   ├── ProductService.php
│   │   ├── CategoryService.php
│   │   ├── DiscountService.php
│   │   ├── ShopService.php
│   │   ├── CartService.php
│   │   ├── CustomerCartService.php
│   │   ├── OrderService.php
│   │   ├── AddressService.php
│   │   └── BundleService.php
│   └── helpers/
│       ├── Auth.php
│       ├── ApiResponse.php
│       └── Router.php
├── config/
│   ├── db.php
│   ├── routes.php
│   ├── create_db.sql
│   └── init_db.sql
├── public/
│   ├── index.php
│   └── image/product/                    # Uploaded product images
├── .env
└── composer.json
```

---

## API Reference

All endpoints are prefixed with `/volta/public`. All responses follow this envelope:

```json
{ "success": true, "message": "...", "data": { ... } }
{ "success": false, "message": "...", "errors": { ... } }
```

Paginated responses include a `pagination` object: `{ page, limit, total }`.

### Auth

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/login` | — | Login. Body: `{ email, password }` |
| POST | `/api/signup` | — | Register. Body: `{ email, password, confirm_password, full_name, phone }` |
| POST | `/api/logout` | Session | Destroy session |
| GET | `/api/me` | Session | Get current user info |

### Users (Admin)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/users` | List users (`?search=&page=&limit=`) |
| GET | `/api/users/{id}` | Get user |
| POST | `/api/users` | Create user |
| PUT | `/api/users/{id}` | Update user |
| DELETE | `/api/users/{id}` | Delete user |

### Products (Admin)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/products` | List products (`?search=&page=&limit=`) |
| GET | `/api/products/{id}` | Get product + images |
| POST | `/api/products` | Create product (form-data, supports `image` file) |
| PUT | `/api/products/{id}` | Update product |
| DELETE | `/api/products/{id}` | Delete product |
| GET | `/api/products/{id}/images` | List images |
| POST | `/api/products/{id}/images` | Upload image (form-data `image`) |
| DELETE | `/api/products/{id}/images/{imageId}` | Delete image |
| PUT | `/api/products/{id}/images/{imageId}/primary` | Set primary image |
| GET | `/api/products/{id}/relations` | Get relations (`?type=upsell\|crosssell`) |
| POST | `/api/products/{id}/relations` | Add relation |
| DELETE | `/api/products/{id}/relations/{relationId}` | Remove relation |

### Categories

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/categories` | — | List all categories |
| GET | `/api/categories/{id}` | — | Get category |
| POST | `/api/categories` | Admin | Create category |
| PUT | `/api/categories/{id}` | Admin | Update category |
| DELETE | `/api/categories/{id}` | Admin | Delete category |

### Discounts (Admin)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/discounts` | List discounts (paginated) |
| GET | `/api/discounts/valid` | List currently valid discounts |
| GET | `/api/discounts/{id}` | Get discount |
| POST | `/api/discounts` | Create discount |
| PUT | `/api/discounts/{id}` | Update discount |
| DELETE | `/api/discounts/{id}` | Delete discount |

### Orders — Admin

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/admin/orders` | List orders (`?status=&page=&limit=`) |
| GET | `/api/admin/orders/stats` | Revenue & count stats (`?start_date=&end_date=`) |
| GET | `/api/admin/orders/{id}` | Get order + items |
| POST | `/api/admin/orders` | Create order manually |
| PUT | `/api/admin/orders/{id}` | Update order |
| PUT | `/api/admin/orders/{id}/status` | Update status only. Body: `{ status }` |
| DELETE | `/api/admin/orders/{id}` | Delete order |

### Cart & Checkout (Customer)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/cart` | Get cart contents |
| POST | `/api/cart/items` | Add item. Body: `{ product_id, quantity? }` |
| PUT | `/api/cart/items` | Update quantity. Body: `{ product_id, quantity }` |
| DELETE | `/api/cart/items/{productId}` | Remove item |
| DELETE | `/api/cart` | Clear cart |
| GET | `/api/cart/checkout` | Get checkout data (items + addresses) |
| POST | `/api/cart/apply-discount` | Validate discount. Body: `{ discount_code, subtotal }` |
| POST | `/api/cart/place-order` | Place order. Body: `{ address_id?, discount_code? }` |
| GET | `/api/orders/my` | Customer's order history |
| GET | `/api/orders/my/{id}` | Customer's order detail |

### Shop (Public)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/shop/products` | Paginated active products (`?search=&category_id=&page=&limit=`) |
| GET | `/api/shop/products/{id}` | Product detail + images |
| GET | `/api/shop/categories` | All categories |
| GET | `/api/shop/featured` | Featured products (`?badge=hot&limit=8`) |

### Bundles (Admin)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/bundles` | List bundles |
| GET | `/api/bundles/active` | Active bundles only |
| GET | `/api/bundles/{id}` | Get bundle + items |
| POST | `/api/bundles` | Create bundle (accepts `product_ids[]`) |
| PUT | `/api/bundles/{id}` | Update bundle (accepts `product_ids[]` to sync) |
| DELETE | `/api/bundles/{id}` | Delete bundle |
| GET | `/api/bundles/{id}/items` | List bundle items |
| POST | `/api/bundles/{id}/items` | Add item. Body: `{ product_id }` |
| DELETE | `/api/bundles/{id}/items/{itemId}` | Remove item |

### Profile (Authenticated)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/profile` | Get profile + addresses |
| PUT | `/api/profile` | Update profile. Body: `{ full_name?, phone?, password? }` |
| GET | `/api/profile/addresses` | List addresses |
| POST | `/api/profile/addresses` | Add address |
| PUT | `/api/profile/addresses/{id}` | Update address |
| DELETE | `/api/profile/addresses/{id}` | Delete address |

---

## Security

- **Password hashing**: bcrypt via `PASSWORD_DEFAULT`
- **SQL injection**: PDO prepared statements throughout
- **Auth guards**: `Auth::requireLogin()` / `Auth::requireAdmin()` return JSON 401/403
- **Session timeout**: 30-minute inactivity
- **CORS**: Configured in `public/index.php` — restrict `Access-Control-Allow-Origin` in production
- **Input validation**: Service layer throws typed exceptions (`InvalidArgumentException`, `RuntimeException`)

---

## Version History

### v3.0.0 (Current) — Backend API rewrite
- Converted from full-stack MVC to backend-only REST API
- All endpoints return JSON (no HTML views)
- New layered architecture: Controller → Service → DAO → DTO
- Added `ApiResponse` helper for consistent response envelope
- Added `CategoryController`, `OrderController`, `BundleController`
- Session-based auth with JSON 401/403 responses
- CORS headers for cross-origin frontend consumption

### v2.0.0 — Full-stack MVC
- PHP + Tailwind CSS server-rendered app
- PDO migration, session auth, AJAX cart

### v1.0.0 — Initial Release
- Basic CRUD, mysqli, simple auth