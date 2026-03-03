-- ── CATEGORIES ──────────────────────────────────────────────
CREATE TABLE categories (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(100) NOT NULL UNIQUE
);

-- ── PRODUCTS ────────────────────────────────────────────────
CREATE TABLE products (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name        VARCHAR(200) NOT NULL,
    slug        VARCHAR(200) NOT NULL UNIQUE,
    description TEXT,
    price       DECIMAL(10,2) NOT NULL,
    stock       INT NOT NULL DEFAULT 0,
    badge       ENUM('none','new','hot','sale') DEFAULT 'none',
    is_active   BOOLEAN DEFAULT TRUE,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- ── PRODUCT IMAGES ──────────────────────────────────────────
CREATE TABLE product_images (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    product_id  INT NOT NULL,
    url         VARCHAR(500) NOT NULL,
    is_primary  BOOLEAN DEFAULT FALSE,

    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ── UPSELL / CROSS-SELL LINKS ────────────────────────────────
-- Covers both "Upsell" (upgrade suggestion) and
-- "Cross-sell" (Frequently Bought Together)
CREATE TABLE product_relations (
    id              INT PRIMARY KEY AUTO_INCREMENT,
    product_id      INT NOT NULL,               -- the source product
    related_id      INT NOT NULL,               -- the suggested product
    type            ENUM('upsell','crosssell') NOT NULL,
    discount_amount DECIMAL(10,2) DEFAULT 0,    -- bundle discount offered
    sort_order      INT DEFAULT 0,

    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (related_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE (product_id, related_id, type)
);

-- ── BUNDLES ──────────────────────────────────────────────────
CREATE TABLE bundles (
    id            INT PRIMARY KEY AUTO_INCREMENT,
    name          VARCHAR(200) NOT NULL,
    description   TEXT,
    bundle_price  DECIMAL(10,2) NOT NULL,       -- discounted total price
    is_active     BOOLEAN DEFAULT TRUE
);

CREATE TABLE bundle_items (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    bundle_id   INT NOT NULL,
    product_id  INT NOT NULL,

    FOREIGN KEY (bundle_id) REFERENCES bundles(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- ── USERS ───────────────────────────────────────────────────
CREATE TABLE users (
    id            INT PRIMARY KEY AUTO_INCREMENT,
    email         VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name     VARCHAR(200),
    phone         VARCHAR(20),
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ── ADDRESSES ───────────────────────────────────────────────
CREATE TABLE addresses (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    user_id     INT NOT NULL,
    label       VARCHAR(50),                    -- e.g. "Home", "Work"
    street      VARCHAR(300) NOT NULL,
    city        VARCHAR(100) NOT NULL,
    country     VARCHAR(100) NOT NULL,
    is_default  BOOLEAN DEFAULT FALSE,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ── ORDERS ──────────────────────────────────────────────────
CREATE TABLE orders (
    id              INT PRIMARY KEY AUTO_INCREMENT,
    user_id         INT NOT NULL,
    address_id      INT,
    status          ENUM('pending','paid','shipped','delivered','cancelled') DEFAULT 'pending',
    total_price     DECIMAL(10,2) NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (address_id) REFERENCES addresses(id)
);

CREATE TABLE order_items (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    order_id    INT NOT NULL,
    product_id  INT NOT NULL,
    quantity    INT NOT NULL DEFAULT 1,
    unit_price  DECIMAL(10,2) NOT NULL,         -- price at time of purchase

    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- ── CART ────────────────────────────────────────────────────
CREATE TABLE cart_items (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    user_id     INT NOT NULL,
    product_id  INT NOT NULL,
    quantity    INT NOT NULL DEFAULT 1,
    added_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- ── DISCOUNTS / PROMO CODES ──────────────────────────────────
CREATE TABLE discounts (
    id              INT PRIMARY KEY AUTO_INCREMENT,
    code            VARCHAR(50) NOT NULL UNIQUE,
    type            ENUM('percent','fixed') NOT NULL,
    value           DECIMAL(10,2) NOT NULL,
    min_order       DECIMAL(10,2) DEFAULT 0,
    uses_remaining  INT DEFAULT NULL,           -- NULL = unlimited
    expires_at      TIMESTAMP DEFAULT NULL
);
