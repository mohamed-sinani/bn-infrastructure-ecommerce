# BN-Infrastructure Database Schema
# Run: /opt/lampp/bin/mysql -u root bn_infrastructure_db < data.sql

CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','customer') NOT NULL DEFAULT 'customer',
    company VARCHAR(255) DEFAULT NULL,
    business_type VARCHAR(100) DEFAULT NULL,
    full_name VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY (username),
    UNIQUE KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS categories (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS products (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    sku VARCHAR(100) NOT NULL,
    brand VARCHAR(100) DEFAULT NULL,
    category_id INT(11) DEFAULT NULL,
    price DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    old_price DECIMAL(15,2) DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    stock_status ENUM('in_stock','low_stock','out_of_stock') NOT NULL DEFAULT 'in_stock',
    stock_qty INT(11) NOT NULL DEFAULT 0,
    moq INT(11) NOT NULL DEFAULT 1,
    specs VARCHAR(500) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    features TEXT DEFAULT NULL,
    tags VARCHAR(500) DEFAULT NULL,
    discount_percentage INT(11) DEFAULT NULL,
    featured TINYINT(1) NOT NULL DEFAULT 0,
    warranty VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY (sku),
    KEY (category_id),
    CONSTRAINT FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS product_images (
    id INT(11) NOT NULL AUTO_INCREMENT,
    product_id INT(11) NOT NULL,
    image VARCHAR(255) NOT NULL,
    sort_order INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY (product_id),
    CONSTRAINT FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS company_users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    company_name VARCHAR(255) NOT NULL,
    user_id INT(11) DEFAULT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role ENUM('admin','editor','viewer') NOT NULL DEFAULT 'viewer',
    invited_by INT(11) DEFAULT NULL,
    status ENUM('active','inactive','pending') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_company (company_name),
    KEY idx_email (email),
    KEY idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS orders (
    id INT(11) NOT NULL AUTO_INCREMENT,
    order_number VARCHAR(50) NOT NULL,
    user_id INT(11) DEFAULT NULL,
    subtotal DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    discount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    vat DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    shipping DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    status ENUM('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
    payment_method VARCHAR(50) DEFAULT NULL,
    delivery_method VARCHAR(50) DEFAULT NULL,
    delivery_fee DECIMAL(15,2) DEFAULT 0.00,
    notes TEXT DEFAULT NULL,
    company_name VARCHAR(255) DEFAULT NULL,
    full_name VARCHAR(255) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    region VARCHAR(100) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    email VARCHAR(255) DEFAULT NULL,
    payment_status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY (order_number),
    KEY (user_id),
    CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_items (
    id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11) NOT NULL,
    product_id INT(11) DEFAULT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_sku VARCHAR(100) DEFAULT NULL,
    quantity INT(11) NOT NULL DEFAULT 1,
    unit_price DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    total_price DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (id),
    KEY (order_id),
    KEY (product_id),
    CONSTRAINT FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_tracking (
    id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11) NOT NULL,
    status VARCHAR(50) NOT NULL,
    note TEXT DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY (order_id),
    CONSTRAINT FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quotations (
    id INT(11) NOT NULL AUTO_INCREMENT,
    quotation_number VARCHAR(50) NOT NULL,
    user_id INT(11) DEFAULT NULL,
    company_name VARCHAR(255) DEFAULT NULL,
    contact_name VARCHAR(255) DEFAULT NULL,
    contact_email VARCHAR(255) DEFAULT NULL,
    contact_phone VARCHAR(50) DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    lpo_file VARCHAR(255) DEFAULT NULL,
    subtotal DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    discount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    vat DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    status ENUM('pending','reviewed','approved','rejected','converted') NOT NULL DEFAULT 'pending',
    admin_notes TEXT DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY (quotation_number),
    KEY (user_id),
    CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quotation_items (
    id INT(11) NOT NULL AUTO_INCREMENT,
    quotation_id INT(11) NOT NULL,
    product_id INT(11) DEFAULT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_sku VARCHAR(100) DEFAULT NULL,
    quantity INT(11) NOT NULL DEFAULT 1,
    unit_price DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    total_price DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (id),
    KEY (quotation_id),
    KEY (product_id),
    CONSTRAINT FOREIGN KEY (quotation_id) REFERENCES quotations(id) ON DELETE CASCADE,
    CONSTRAINT FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS payments (
    id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11) DEFAULT NULL,
    quotation_id INT(11) DEFAULT NULL,
    amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    payment_method VARCHAR(50) NOT NULL DEFAULT 'bank_transfer',
    payment_reference VARCHAR(255) DEFAULT NULL,
    status ENUM('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
    paid_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY (order_id),
    KEY (quotation_id),
    CONSTRAINT FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL,
    CONSTRAINT FOREIGN KEY (quotation_id) REFERENCES quotations(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS reviews (
    id INT(11) NOT NULL AUTO_INCREMENT,
    product_id INT(11) NOT NULL,
    user_id INT(11) DEFAULT NULL,
    rating TINYINT(1) NOT NULL DEFAULT 5,
    title VARCHAR(255) DEFAULT NULL,
    comment TEXT DEFAULT NULL,
    reviewer_name VARCHAR(255) DEFAULT NULL,
    reviewer_location VARCHAR(255) DEFAULT NULL,
    verified_purchase TINYINT(1) NOT NULL DEFAULT 0,
    status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'approved',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY (product_id),
    KEY (user_id),
    CONSTRAINT FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Categories
INSERT IGNORE INTO categories (id, name, slug, description) VALUES
(1, 'Routers', 'routers', 'Enterprise and SMB routers for network routing and connectivity'),
(2, 'Switches', 'switches', 'Managed and unmanaged network switches'),
(3, 'Access Points', 'access-points', 'Wireless access points and WiFi equipment'),
(4, 'Structured Cabling', 'structured-cabling', 'CAT5e/CAT6/CAT6A cabling kits and accessories'),
(5, 'Firewalls', 'firewalls', 'Next-generation firewalls and UTM appliances');

-- Products
INSERT IGNORE INTO products (id, name, sku, brand, category_id, price, old_price, image, stock_status, stock_qty, moq, specs, description, features, tags, discount_percentage, featured, warranty) VALUES
(1, 'MikroTik CCR2004-1G-12S+2XS Router', 'MK-CCR2004-1G-12S', 'MikroTik', 1, 1850000.00, 2100000.00, 'mikrotik_ccr2004_router.jpg', 'in_stock', 15, 1, 'CPU: AnnapurnaLabs AL324 4-core 1.7GHz, RAM: 4GB, Ports: 1x GbE, 12x SFP+, 2x 25GbE SFP28, OS: RouterOS v7', 'High-performance cloud core router with 25GbE uplinks, ideal for ISP and enterprise core routing.', 'Dual 25GbE SFP28, 12x SFP+, Hardware NAT, VPN acceleration, RouterOS v7', 'mikrotik,router,25gbe,sfp28,enterprise', 12, 1, '1 Year'),
(2, 'Cisco Catalyst 2960X-24TS-L Switch', 'CISCO-2960X-24TS', 'Cisco', 2, 980000.00, NULL, 'cisco_catalyst_2960x_switch.jpg', 'in_stock', 25, 1, 'Ports: 24x GbE, 4x SFP, Switching capacity: 176 Gbps, PoE: No, Stackable: Yes', 'Managed L2 switch with SmartNet support, ideal for campus and branch access layer deployments.', 'LAN Base, FlexStack-Plus, NetFlow, QoS, Energy Efficient Ethernet', 'cisco,switch,managed,24-port,enterprise', NULL, 1, 'Limited Lifetime'),
(3, 'Ubiquiti UniFi U6 Pro Access Point', 'UBNT-U6-PRO', 'Ubiquiti', 3, 320000.00, 380000.00, 'ubiquiti_unifi_ap_ax_access_point.jpg', 'in_stock', 50, 1, 'WiFi: 802.11ax (WiFi 6), Bands: Dual-band 2.4/5 GHz, Throughput: 5.3 Gbps, Coverage: 140m², PoE: 802.3af', 'WiFi 6 dual-band access point with 4x4 MIMO for high-density environments.', 'WiFi 6, OFDMA, MU-MIMO, BSS Coloring, Band Steering, Seamless Roaming', 'ubiquiti,wifi6,access-point,unifi,enterprise', 16, 1, '2 Years'),
(4, 'Panduit CAT6A Structured Cabling Kit', 'PND-CAT6A-KIT', 'Panduit', 4, 450000.00, NULL, 'panduit_cat6_structured_cabling_kit.jpg', 'in_stock', 30, 1, 'Cable: CAT6A U/UTP, Length: 305m (1000ft), Connectors: RJ45, Patches: 24x 2m, Panels: 2x 24-port', 'Complete structured cabling kit with CAT6A cable, patch panels, and RJ45 connectors for office installations.', 'CAT6A 10Gbps, PoE++ rated, Flame retardant, TIA-568-C.2 compliant, Blue jacket', 'panduit,cat6a,cabling,structured,infrastructure', NULL, 0, 'Lifetime'),
(5, 'Fortinet FortiGate 60F Next-Gen Firewall', 'FT-FGT60F', 'Fortinet', 5, 1200000.00, 1350000.00, 'fortinet_fortigate_60f.jpg', 'in_stock', 10, 1, 'Firewall: 10 Gbps, IPS: 1.4 Gbps, Interfaces: 10x GbE, VPN: 6.5 Gbps, Threat Protection: 1 Gbps', 'Compact next-generation firewall with SD-WAN and built-in wireless controller for small to medium branches.', 'FortiGuard AI, SD-WAN, IPS, SSL Inspection, Web Filtering, Application Control, Zero Trust', 'fortinet,firewall,utm,sdwan,security', 11, 1, '1 Year'),
(6, 'Networking Equipment Bundle', 'BUNDLE-NETWK-01', 'Multi-Brand', NULL, 3500000.00, 4200000.00, 'networking_equipment_collage.jpg', 'in_stock', 5, 1, 'Includes: Router, Switch, 2x Access Points, Firewall, Cabling Kit', 'Complete enterprise networking bundle — one stop for routers, switches, APs, firewalls, and structured cabling.', 'End-to-end network stack, volume pricing, pre-configured options available', 'bundle,enterprise,networking,complete-solution', 17, 1, 'Varies by component');

-- Homepage Images
INSERT IGNORE INTO product_images (product_id, image, sort_order) VALUES
(1, 'mikrotik_ccr2004_router.jpg', 1),
(2, 'cisco_catalyst_2960x_switch.jpg', 2),
(3, 'ubiquiti_unifi_ap_ax_access_point.jpg', 3),
(4, 'panduit_cat6_structured_cabling_kit.jpg', 4),
(5, 'fortinet_fortigate_60f.jpg', 5),
(6, 'networking_equipment_collage.jpg', 6);

# Fix existing product image paths (remove Homepage/ prefix)
UPDATE products SET image = 'mikrotik_ccr2004_router.jpg' WHERE image = 'Homepage/mikrotik_ccr2004_router.jpg';
UPDATE products SET image = 'cisco_catalyst_2960x_switch.jpg' WHERE image = 'Homepage/cisco_catalyst_2960x_switch.jpg';
UPDATE products SET image = 'ubiquiti_unifi_ap_ax_access_point.jpg' WHERE image = 'Homepage/ubiquiti_unifi_ap_ax_access_point.jpg';
UPDATE products SET image = 'panduit_cat6_structured_cabling_kit.jpg' WHERE image = 'Homepage/panduit_cat6_structured_cabling_kit.jpg';
UPDATE products SET image = 'fortinet_fortigate_60f.jpg' WHERE image = 'Homepage/fortinet_fortigate_60f.jpg';
UPDATE products SET image = 'networking_equipment_collage.jpg' WHERE image = 'Homepage/networking_equipment_collage.jpg';
