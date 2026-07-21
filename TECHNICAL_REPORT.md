# BN-Infrastructure E-Commerce Platform

## Technical Report

---

**DAR ES SALAAM INSTITUTE OF TECHNOLOGY**

**Module Name:** Fundamentals of E-Commerce
**Module Code:** ITT 06216

---

### Group Members

| S/N | Name | Registration No. |
|-----|------|-----------------|
| 01 | Melkizedek Fredy Antony | 230229434637 |
| 02 | Abbas Hassan Abbas | 230229452969 |
| 03 | Mohamed Selemani Sinani | 230229434215 |
| 04 | Vinna Frank Mapunda | 230229417350 |
| 05 | Ahimidiwe Saimon Chungu | 230229445559 |
| 06 | Abdulmalik Sultan | 230627498491 |

---

**Date of Submission:** July 2026

---

## Table of Contents

1. [Introduction](#1-introduction)
   - 1.1 [Background](#11-background)
   - 1.2 [Project Overview](#12-project-overview)
   - 1.3 [Scope of the Report](#13-scope-of-the-report)
2. [Problem Statement](#2-problem-statement)
3. [Objectives of the Project](#3-objectives-of-the-project)
   - 3.1 [General Objective](#31-general-objective)
   - 3.2 [Specific Objectives](#32-specific-objectives)
4. [Literature Review](#4-literature-review)
   - 4.1 [E-Commerce in Business-to-Business (B2B) Context](#41-e-commerce-in-business-to-business-b2b-context)
   - 4.2 [Networking Infrastructure Procurement](#42-networking-infrastructure-procurement)
   - 4.3 [Existing E-Commerce Platforms](#43-existing-e-commerce-platforms)
5. [System Analysis and Design](#5-system-analysis-and-design)
   - 5.1 [Requirements Analysis](#51-requirements-analysis)
   - 5.2 [Functional Requirements](#52-functional-requirements)
   - 5.3 [Non-Functional Requirements](#53-non-functional-requirements)
   - 5.4 [Use Case Analysis](#54-use-case-analysis)
   - 5.5 [System Architecture](#55-system-architecture)
   - 5.6 [Database Design](#56-database-design)
6. [Proposed Features of the System](#6-proposed-features-of-the-system)
7. [Implementation](#7-implementation)
   - 7.1 [Technology Stack](#71-technology-stack)
   - 7.2 [Project Directory Structure](#72-project-directory-structure)
   - 7.3 [Database Implementation](#73-database-implementation)
   - 7.4 [Backend Implementation](#74-backend-implementation)
   - 7.5 [Frontend Implementation](#75-frontend-implementation)
   - 7.6 [Key Code Implementation Details](#76-key-code-implementation-details)
8. [System Testing](#8-system-testing)
   - 8.1 [Testing Strategy](#81-testing-strategy)
   - 8.2 [Functional Test Cases](#82-functional-test-cases)
   - 8.3 [User Acceptance Testing](#83-user-acceptance-testing)
9. [User Interface Design](#9-user-interface-design)
   - 9.1 [Homepage](#91-homepage)
   - 9.2 [Product Catalogue](#92-product-catalogue)
   - 9.3 [Shopping Cart and Checkout](#93-shopping-cart-and-checkout)
   - 9.4 [Admin Dashboard](#94-admin-dashboard)
10. [Security Considerations](#10-security-considerations)
11. [Significance of the Project](#11-significance-of-the-project)
12. [Limitations and Future Enhancements](#12-limitations-and-future-enhancements)
13. [Conclusion](#13-conclusion)
14. [References](#14-references)
15. [Appendices](#15-appendices)

---

## 1. Introduction

### 1.1 Background

The rapid advancement of information and communication technology has significantly transformed the way organizations acquire products and services. Businesses, educational institutions, government agencies, and other organizations increasingly rely on digital platforms to streamline procurement processes and improve operational efficiency. Business-to-Business (B2B) e-commerce systems provide organizations with convenient access to products, pricing information, and purchasing services through online platforms.

Networking devices play a critical role in modern organizations by supporting communication, internet connectivity, data sharing, and business operations. Products such as routers, switches, access points, firewalls, network cables, servers, and related accessories are essential for maintaining reliable network infrastructure. However, many organizations still depend on traditional procurement methods that involve physical visits, phone calls, emails, and manual quotations when purchasing networking equipment.

### 1.2 Project Overview

The proposed **Networking Devices B2B E-Commerce Platform** (branded as **BN-Infrastructure**) is designed to provide an online marketplace where businesses and organizations can browse networking products, compare specifications, request quotations, place bulk orders, and track purchases. The platform will support various categories of networking equipment from different manufacturers while providing accurate product information and efficient procurement services.

Through this system, customers will benefit from simplified purchasing processes while suppliers will improve product management and sales operations.

### 1.3 Scope of the Report

This technical report documents the complete software development lifecycle of the BN-Infrastructure platform, including requirements analysis, system design, database architecture, implementation details, testing results, security considerations, and future enhancement recommendations.

---

## 2. Problem Statement

Networking infrastructure is essential for organizations operating in today's digital environment. However, the procurement process for networking devices is often inefficient and heavily dependent on traditional business practices. Organizations frequently encounter challenges when sourcing networking equipment for their operational requirements.

One major challenge is the **lack of centralized and comprehensive product information**. Organizations may struggle to obtain accurate details regarding product specifications, compatibility, pricing, warranties, and availability. This can result in delays during procurement and difficulties in selecting suitable networking solutions.

Another challenge is **limited accessibility to suppliers and product information**. Organizations located far from supplier offices may face difficulties obtaining quotations, comparing products, and completing procurement processes efficiently. Traditional procurement methods often require extensive communication and documentation, increasing administrative workload.

**Manual order processing and quotation management** create additional inefficiencies. Businesses may experience delays in quotation approval, payment verification, order confirmation, and product delivery. These delays can negatively affect project implementation timelines and organizational productivity.

Therefore, there is a need for a B2B networking devices e-commerce platform that provides centralized product information, quotation management, online ordering, secure payment processing, and efficient communication between suppliers and organizations.

---

## 3. Objectives of the Project

### 3.1 General Objective

To develop a web-based B2B e-commerce platform that enables businesses and organizations to browse, compare, request quotations, order, and purchase networking devices and related equipment online.

### 3.2 Specific Objectives

1. **Product Catalogue Development** -- To develop an online product catalogue that displays networking devices, servers, accessories, and related equipment with detailed specifications, pricing information, product images, and availability status.

2. **Search and Filtering Module** -- To develop a product search and filtering module that allows businesses and organizations to quickly locate products based on category, manufacturer, technical specifications, performance requirements, and price range.

3. **Network Solution Recommendation Engine** -- To develop a network solution recommendation module that enables businesses and organizations to receive customized networking equipment recommendations based on factors such as organizational size, number of users, departments, branch locations, network capacity requirements, and available budget.

4. **Quotation Request and Order Management** -- To develop a quotation request and order management module that enables businesses and organizations to request quotations, manage procurement processes, and place orders efficiently.

5. **Payment and Order Tracking** -- To develop a payment and order tracking module that allows businesses and organizations to monitor payment status, order processing, shipment progress, and product delivery in real time.

6. **Administrative Dashboard** -- To develop an administrative dashboard that enables administrators to manage products, quotations, orders, payments, inventory, customer accounts, and business or organizational procurement activities effectively.

---

## 4. Literature Review

### 4.1 E-Commerce in Business-to-Business (B2B) Context

Business-to-Business (B2B) e-commerce refers to the online sale of goods and services between businesses. Unlike Business-to-Consumer (B2C) models, B2B transactions typically involve larger order quantities, negotiated pricing, longer sales cycles, and more complex procurement workflows. According to industry research, B2B e-commerce accounts for a significantly larger share of global e-commerce revenue compared to B2C transactions.

B2B platforms typically feature bulk ordering capabilities, quotation request systems, tiered pricing structures, and multi-user account management with role-based access controls. These features are essential for supporting organizational procurement processes where multiple stakeholders may be involved in purchasing decisions.

### 4.2 Networking Infrastructure Procurement

The networking equipment market is characterized by rapid technological evolution, diverse product portfolios from multiple vendors, and complex technical specifications. Organizations procuring networking equipment must consider factors such as compatibility, performance requirements, scalability, warranty terms, and total cost of ownership. A centralized digital marketplace can significantly reduce the complexity of this procurement process by providing comprehensive product information, comparison tools, and streamlined ordering workflows.

### 4.3 Existing E-Commerce Platforms

Several B2B e-commerce platforms exist in the market, including Shopify Plus, Magento Commerce, and custom-built solutions. For the Tanzanian market, there is limited availability of specialized B2B platforms for networking equipment, presenting an opportunity for a tailored solution that addresses local business needs, payment methods (including mobile money and bank transfers), and regional delivery logistics.

---

## 5. System Analysis and Design

### 5.1 Requirements Analysis

The requirements for the BN-Infrastructure platform were gathered through analysis of existing B2B procurement workflows, review of similar e-commerce platforms, and consideration of the target users' needs in the Tanzanian business environment.

**Stakeholders:**

| Stakeholder | Role | Key Requirements |
|---|---|---|
| Business Customers | Browse, compare, order networking equipment | Product search, quotation requests, order tracking, account management |
| Administrators | Manage platform operations | Product management, order processing, quotation management, reporting, inventory control |
| Suppliers/Vendors | Provide product information | Product listings, pricing updates, stock management |

### 5.2 Functional Requirements

| Requirement ID | Description | Priority |
|---|---|---|
| FR-01 | User registration and authentication (email/password) | High |
| FR-02 | Product catalogue with categories and filtering | High |
| FR-03 | Product search by name, SKU, brand, and specifications | High |
| FR-04 | Shopping cart management (add, update, remove items) | High |
| FR-05 | Order placement with delivery and payment details | High |
| FR-06 | Quotation request and management | High |
| FR-07 | Order tracking by order number and email | High |
| FR-08 | Administrative dashboard with analytics | High |
| FR-09 | Product management (CRUD operations) | High |
| FR-10 | Order and payment management (admin) | High |
| FR-11 | Network solution recommendation engine | Medium |
| FR-12 | Company user management (multi-user accounts) | Medium |
| FR-13 | Product reviews and ratings | Medium |
| FR-14 | Product comparison | Medium |
| FR-15 | Email notifications for orders | Medium |
| FR-16 | Invoice generation | Medium |
| FR-17 | Reports and analytics | Low |

### 5.3 Non-Functional Requirements

| Requirement ID | Description | Target |
|---|---|---|
| NFR-01 | Page load time | < 3 seconds |
| NFR-02 | Responsive design | Desktop, tablet, and mobile |
| NFR-03 | Data security | Password hashing, SQL injection prevention |
| NFR-04 | Data integrity | Foreign key constraints, transactional operations |
| NFR-05 | Availability | 99% uptime on XAMPP/LAMP stack |
| NFR-06 | Scalability | Support for 100+ concurrent users |
| NFR-07 | Browser compatibility | Chrome, Firefox, Safari, Edge |

### 5.4 Use Case Analysis

The primary use cases for the system include:

**Use Case 1: Customer Product Browsing and Purchase**
- Actor: Business Customer
- Preconditions: User has a valid account
- Flow: Browse catalogue -> Filter/search products -> View product details -> Add to cart -> Proceed to checkout -> Enter delivery/payment details -> Place order -> Receive confirmation

**Use Case 2: Quotation Request**
- Actor: Business Customer
- Preconditions: User has items of interest
- Flow: Add items to quote -> Submit quotation request -> Admin reviews quotation -> Admin approves/rejects -> Customer receives notification -> Convert to order (if approved)

**Use Case 3: Order Tracking**
- Actor: Business Customer
- Preconditions: User has placed an order
- Flow: Enter order number and email -> View order status and tracking history -> View delivery progress

**Use Case 4: Admin Product Management**
- Actor: Administrator
- Preconditions: Admin is authenticated
- Flow: Login to admin panel -> Navigate to products -> Add/edit/delete products -> Update stock levels -> Manage categories

**Use Case 5: Network Solution Recommendation**
- Actor: Business Customer
- Preconditions: None
- Flow: Enter organizational requirements -> System analyzes needs -> System recommends equipment bundle -> View recommended products -> Add to cart or request quote

### 5.5 System Architecture

The BN-Infrastructure platform follows a **three-tier architecture** pattern, separating the presentation layer, business logic layer, and data access layer.

```
+------------------------------------------------------------------+
|                     PRESENTATION LAYER                            |
|                                                                   |
|   +-------------+  +-------------+  +-------------+              |
|   |  Homepage   |  |  Catalogue  |  |   Cart &    |              |
|   |             |  |  & Search   |  |  Checkout   |              |
|   +------+------+  +------+------+  +------+------+              |
|          |                |                |                       |
|   +------+------+  +------+------+  +------+------+              |
|   |   Login &   |  |   Track     |  |   Quote    |              |
|   |  Register   |  |   Orders    |  |  Requests  |              |
|   +------+------+  +------+------+  +------+------+              |
|          |                |                |                       |
|   +------+------+  +------+------+  +------+------+              |
|   |   Admin     |  |   Admin     |  |   Admin    |              |
|   |  Dashboard  |  |  Products   |  |  Orders    |              |
|   +------+------+  +------+------+  +------+------+              |
+----------|---------------|----------------|-----------------------+
           |               |                |
+----------v---------------v----------------v-----------------------+
|                     BUSINESS LOGIC LAYER                          |
|                                                                   |
|   +------------------+  +------------------+  +----------------+  |
|   |  Authentication  |  |  Cart Management |  |   Order        |  |
|   |  & Session Mgmt  |  |  (Session-based) |  |   Processing   |  |
|   +------------------+  +------------------+  +----------------+  |
|                                                                   |
|   +------------------+  +------------------+  +----------------+  |
|   |  Quotation       |  |  Payment         |  |  Recommendation|  |
|   |  Engine          |  |  Processing      |  |  Engine        |  |
|   +------------------+  +------------------+  +----------------+  |
|                                                                   |
|   +------------------+  +------------------+  +----------------+  |
|   |  Email            |  |  Invoice         |  |  Report        |  |
|   |  Notifications    |  |  Generation      |  |  Generation    |  |
|   +------------------+  +------------------+  +----------------+  |
+----------|---------------|----------------|-----------------------+
           |               |                |
+----------v---------------v----------------v-----------------------+
|                       DATA ACCESS LAYER                           |
|                                                                   |
|   +------------------+  +------------------+  +----------------+  |
|   |  Database        |  |  File System     |  |  Session       |  |
|   |  (MySQL/MariaDB) |  |  (Product Images)|  |  Storage       |  |
|   +------------------+  +------------------+  +----------------+  |
+------------------------------------------------------------------+
```

**Figure 1: Three-Tier Architecture of BN-Infrastructure Platform**

### 5.6 Database Design

The database is designed using a **relational model** with MySQL (MariaDB) as the database management system. The schema consists of 10 primary tables with foreign key relationships ensuring data integrity.

#### 5.6.1 Entity-Relationship Diagram (Textual)

```
+------------------+       +-------------------+       +------------------+
|     users        |       |    categories     |       |    products      |
+------------------+       +-------------------+       +------------------+
| id (PK)          |       | id (PK)           |       | id (PK)          |
| username (UQ)    |       | name              |       | name             |
| email (UQ)       |       | slug (UQ)         |       | sku (UQ)         |
| password         |       | description       |       | brand            |
| role             |       | created_at        |       | category_id (FK) |----> categories.id
| company          |       +-------------------+       | price            |
| business_type    |                                   | old_price        |
| full_name        |       +-------------------+       | image            |
| phone            |       |  product_images   |       | stock_status     |
| created_at       |       +-------------------+       | stock_qty        |
| updated_at       |       | id (PK)           |       | moq              |
+--------+---------+       | product_id (FK)   |----> products.id      | specs          |
         |                 | image             |       | description      |
         |                 | sort_order        |       | features         |
         |                 +-------------------+       | tags             |
         |                                             | discount_pct     |
         |                 +-------------------+       | featured         |
         |                 |  company_users    |       | warranty         |
         |                 +-------------------+       | created_at       |
         |                 | id (PK)           |       | updated_at       |
         |                 | company_name      |       +--------+---------+
         |                 | user_id (FK)      |----> users.id           |
         |                 | name              |                |
         |                 | email             |                |
         |                 | role              |       +--------v---------+
         |                 | invited_by        |       |  order_items     |
         |                 | status            |       +------------------+
         |                 +-------------------+       | id (PK)          |
         |                                             | order_id (FK)    |----> orders.id
         |                 +-------------------+       | product_id (FK)  |----> products.id
         |                 |    orders         |       | product_name     |
         +---------------->| id (PK)           |       | product_sku      |
                           | order_number (UQ) |       | quantity         |
                           | user_id (FK)      |----> users.id          |
                           | subtotal          |       | unit_price       |
                           | discount          |       | total_price      |
                           | vat               |       +------------------+
                           | shipping          |
                           | total             |       +------------------+
                           | status            |       |  quotations      |
                           | payment_method    |       +------------------+
                           | payment_status    |       | id (PK)          |
                           | company_name      |       | quotation_number |
                           | full_name         |       | user_id (FK)     |----> users.id
                           | address           |       | company_name     |
                           | city              |       | contact_name     |
                           | region            |       | contact_email    |
                           | phone             |       | subtotal         |
                           | email             |       | total            |
                           | notes             |       | status           |
                           | created_at        |       | admin_notes      |
                           | updated_at        |       | created_at       |
                           +--------+----------+       | updated_at       |
                                    |                  +--------+---------+
                                    |                           |
                           +--------v----------+       +--------v---------+
                           |  order_tracking   |       |quotation_items   |
                           +-------------------+       +------------------+
                           | id (PK)           |       | id (PK)          |
                           | order_id (FK)     |       | quotation_id(FK) |----> quotations.id
                           | status            |       | product_id (FK)  |----> products.id
                           | note              |       | product_name     |
                           | created_at        |       | quantity         |
                           +-------------------+       | unit_price       |
                                                       | total_price      |
                           +-------------------+       +------------------+
                           |    payments       |
                           +-------------------+
                           | id (PK)           |
                           | order_id (FK)     |----> orders.id
                           | quotation_id (FK) |----> quotations.id
                           | amount            |
                           | payment_method    |
                           | payment_reference |
                           | status            |
                           | paid_at           |
                           | created_at        |
                           +-------------------+

                           +-------------------+
                           |     reviews       |
                           +-------------------+
                           | id (PK)           |
                           | product_id (FK)   |----> products.id
                           | user_id (FK)      |----> users.id
                           | rating            |
                           | title             |
                           | comment           |
                           | reviewer_name     |
                           | verified_purchase |
                           | status            |
                           | created_at        |
                           +-------------------+
```

**Figure 2: Entity-Relationship Diagram**

#### 5.6.2 Database Tables Summary

| Table Name | Purpose | Key Relationships |
|---|---|---|
| `users` | Stores customer and admin accounts | Referenced by orders, quotations, reviews, company_users |
| `categories` | Product category definitions | Referenced by products |
| `products` | Product catalogue data | Referenced by order_items, quotation_items, product_images, reviews |
| `product_images` | Multiple images per product | Foreign key to products |
| `company_users` | Multi-user company accounts | Foreign key to users |
| `orders` | Customer order records | Referenced by order_items, order_tracking, payments |
| `order_items` | Individual items in an order | Foreign keys to orders and products |
| `order_tracking` | Order status history | Foreign key to orders |
| `quotations` | Quotation request records | Referenced by quotation_items, payments |
| `quotation_items` | Items in a quotation request | Foreign keys to quotations and products |
| `payments` | Payment transaction records | Foreign keys to orders and quotations |
| `reviews` | Product reviews and ratings | Foreign keys to products and users |

#### 5.6.3 Key Database Constraints

| Constraint Type | Table | Column(s) | Description |
|---|---|---|---|
| PRIMARY KEY | All tables | id | Auto-incrementing unique identifier |
| UNIQUE | users | username, email | Prevents duplicate accounts |
| UNIQUE | products | sku | Unique stock keeping unit |
| UNIQUE | orders | order_number | Unique order identifier (NZ-YYYY-NNNNNN) |
| UNIQUE | quotations | quotation_number | Unique quote identifier (QT-YYYY-NNNNN) |
| FOREIGN KEY | products | category_id | References categories(id) ON DELETE SET NULL |
| FOREIGN KEY | orders | user_id | References users(id) ON DELETE SET NULL |
| FOREIGN KEY | order_items | order_id | References orders(id) ON DELETE CASCADE |
| FOREIGN KEY | order_items | product_id | References products(id) ON DELETE SET NULL |
| CHECK | products | price >= 0 | Ensures non-negative pricing |
| CHECK | order_items | quantity > 0 | Ensures positive quantities |
| ENUM | orders.status | pending, confirmed, processing, shipped, delivered, cancelled | Restricts valid order states |
| ENUM | products.stock_status | in_stock, low_stock, out_of_stock | Restricts valid stock states |
| ENUM | users.role | admin, customer | Restricts valid user roles |

---

## 6. Proposed Features of the System

### 6.1 Product Catalogue

The platform provides a comprehensive catalogue containing networking products across five main categories:

| Category | Description | Example Products |
|---|---|---|
| Routers | Enterprise and SMB routers | MikroTik CCR2004-1G-12S+2XS |
| Switches | Managed and unmanaged switches | Cisco Catalyst 2960X-24TS-L |
| Access Points | Wireless access points and WiFi equipment | Ubiquiti UniFi U6 Pro |
| Structured Cabling | CAT5e/CAT6/CAT6A cabling kits | Panduit CAT6A Kit |
| Firewalls | Next-generation firewalls and UTM | Fortinet FortiGate 60F |

Each product includes images, specifications, pricing information (in Tanzanian Shillings), warranty details, and real-time availability status.

### 6.2 Search and Filtering

Organizations can search and filter products using multiple criteria simultaneously:

- **Category filter** -- Browse by product type (Routers, Switches, etc.)
- **Brand filter** -- Filter by manufacturer (Cisco, MikroTik, Ubiquiti, Fortinet, etc.)
- **Price range** -- Set minimum and maximum price thresholds
- **Stock availability** -- Show only in-stock items
- **Text search** -- Search across product name, SKU, brand, and specifications
- **Sort options** -- Sort by price (low/high), newest, best sellers

### 6.3 Business Registration and Login

The system allows businesses and organizations to create corporate accounts with the following registration fields:

- Company/Organization name
- Business type (ISP, Enterprise, Government, Reseller, SME)
- Full name, work email, phone number
- Password (minimum 8 characters with strength indicator)

Registered customers can manage company profiles, view order history, track shipments, and manage quotation requests.

### 6.4 Quotation Request and Order Management

Organizations can:

1. Add products to a quotation request directly from the catalogue
2. Submit the quotation with additional notes and requirements
3. Receive admin review and response (pending, reviewed, approved, rejected, converted)
4. Convert approved quotations into formal orders
5. Support both individual and bulk purchasing processes

### 6.5 Payment Processing

The platform supports multiple payment methods to accommodate organizational procurement requirements:

| Payment Method | Description | Status |
|---|---|---|
| Bank Transfer | Direct bank-to-bank transfer | Supported |
| Mobile Money (M-Pesa) | Mobile money payment | Supported |
| Corporate Payment | Organization invoice-based payment | Supported |
| Cash on Delivery | Payment upon delivery | Supported |

**Business Rules:**
- Orders above TSh 10,000,000 receive a 5% automatic discount
- Free delivery for orders above TSh 500,000
- Standard delivery fee of TSh 35,000 for orders below TSh 500,000
- VAT calculated at 18% on the discounted subtotal

### 6.6 Order Tracking

Customers can monitor order progress using their order number and email address. The system maintains a complete tracking history with status updates:

```
pending --> confirmed --> processing --> shipped --> delivered
    |                                         |
    +----------> cancelled <------------------+
```

### 6.7 Administrative Dashboard

The admin panel provides a centralized interface for managing all platform operations:

| Module | Capabilities |
|---|---|
| Dashboard | Overview statistics (products, orders, revenue, quotes, low stock alerts) |
| Products | Add, edit, delete products; manage stock levels; upload images |
| Categories | Create and manage product categories |
| Orders | View, update status, manage all customer orders |
| Payments | Track payment status, update payment records |
| Quotations | Review, approve/reject quotation requests |
| Customers | View and manage customer accounts |
| Company Users | Manage authorized users per company account |
| Reports | Generate sales, inventory, and customer reports |

---

## 7. Implementation

### 7.1 Technology Stack

| Component | Technology | Version/Details |
|---|---|---|
| **Server Environment** | XAMPP (LAMP Stack) | Apache + MariaDB + PHP |
| **Backend Language** | PHP | 8.x (procedural style) |
| **Database** | MariaDB/MySQL | InnoDB engine, utf8mb4 charset |
| **Frontend Markup** | HTML5 | Semantic HTML |
| **Styling** | CSS3 | Custom CSS with CSS Variables, Responsive Design |
| **Client-Side Scripting** | JavaScript | Vanilla JS (ES6+), Fetch API |
| **Fonts** | Google Fonts | Inter (300-900 weights) |
| **Icons** | Font Awesome | 6.7.2 (Free tier) |
| **Image Handling** | SVG Placeholders | Dynamic SVG generation for missing images |
| **Authentication** | PHP Sessions | password_hash() / password_verify() |
| **Email** | PHP mail() | HTML email templates |

### 7.2 Project Directory Structure

```
bn/
|-- config/
|   `-- database.php              # Database configuration and helper functions
|-- src/
|   |-- auth.php                  # Admin authentication functions
|   |-- cart.php                  # Shopping cart management (session-based)
|   `-- functions.php             # Shared utility functions
|-- admin/
|   |-- index.php                 # Admin dashboard
|   |-- login.php                 # Admin login
|   |-- logout.php                # Admin logout
|   |-- products.php              # Product listing (admin)
|   |-- products-add.php          # Add new product
|   |-- products-edit.php         # Edit existing product
|   |-- products-delete.php       # Delete product
|   |-- categories.php            # Category management
|   |-- orders.php                # Order management
|   |-- payments.php              # Payment management
|   |-- quotes.php                # Quotation management
|   |-- customers.php             # Customer management
|   |-- company-users.php         # Company user management
|   `-- reports.php               # Reporting dashboard
|-- Homepage/
|   |-- index.php                 # Homepage (landing page)
|   `-- *.jpg                     # Product images
|-- index.php                     # Main storefront entry point
|-- catalog.php                   # Product catalogue with filtering
|-- product.php                   # Single product detail view
|-- cart.php                      # Shopping cart page
|-- checkout.php                  # Checkout and order placement
|-- login.php                     # Customer login and registration
|-- dashboard.php                 # Customer dashboard
|-- track.php                     # Order tracking
|-- my-quotes.php                 # Customer quotation management
|-- recommend.php                 # Network solution recommendation engine
|-- compare.php                   # Product comparison
|-- company-users.php             # Company user management
|-- about.php                     # About/Solutions page
|-- invoice.php                   # Invoice generation
|-- order-confirmation.php        # Order success page
|-- quote-confirmation.php        # Quote success page
|-- privacy.php                   # Privacy policy
|-- terms.php                     # Terms of service
|-- shipping.php                  # Shipping policy
|-- returns.php                   # Returns policy
|-- data.sql                      # Database schema and seed data
`-- *.jpg                         # Static product images
```

### 7.3 Database Implementation

The database is initialized using the `data.sql` script which creates all required tables and seeds initial data:

**Database Configuration** (`config/database.php`):

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'tumamaoni_user');
define('DB_PASS', 'Mo2004@12');
define('DB_NAME', 'bn_infrastructure_db');

function getConnection() {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $conn->set_charset("utf8mb4");
    }
    return $conn;
}
```

**Prepared Statement Helpers:**

The database layer provides four core functions for secure data access:

| Function | Purpose | Parameters |
|---|---|---|
| `query($sql, $params)` | Execute SELECT queries | SQL string, parameter array |
| `fetchAll($sql, $params)` | Fetch all matching rows | SQL string, parameter array |
| `fetchOne($sql, $params)` | Fetch single row | SQL string, parameter array |
| `execute($sql, $params)` | Execute INSERT/UPDATE/DELETE | SQL string, parameter array |

All database operations use **prepared statements** with parameterized queries to prevent SQL injection attacks. The type-binding system automatically detects parameter types (integer, double, or string).

### 7.4 Backend Implementation

#### 7.4.1 Authentication System

The authentication system uses PHP sessions for state management and bcrypt hashing for password security:

- **Registration:** Collects business details, hashes password with `password_hash(PASSWORD_DEFAULT)`, stores in users table with `customer` role
- **Login:** Verifies credentials using `password_verify()`, sets session variables (`user_id`, `user_name`, `user_email`, `user_role`)
- **Admin Login:** Separate authentication path restricted to users with `admin` role
- **Session Management:** Automatic session initialization, logout via `session_destroy()`

#### 7.4.2 Shopping Cart

The shopping cart is implemented using PHP sessions (server-side storage):

```php
// Cart structure in $_SESSION['cart']
$_SESSION['cart'] = [
    1 => ['id' => 1, 'name' => '...', 'sku' => '...', 'price' => 1850000.00, 'qty' => 2, ...],
    3 => ['id' => 3, 'name' => '...', 'sku' => '...', 'price' => 320000.00, 'qty' => 1, ...],
];
```

Key cart functions:

| Function | Description |
|---|---|
| `cartAdd($productId, $quantity)` | Add product to cart or increment quantity |
| `cartUpdate($productId, $quantity)` | Update item quantity |
| `cartRemove($productId)` | Remove item from cart |
| `cartGetItems()` | Retrieve all cart items |
| `cartCount()` | Get total item count |
| `cartSubtotal()` | Calculate subtotal |
| `cartContains($productId)` | Check if product is in cart |
| `cartClear()` | Empty the cart |

#### 7.4.3 Order Processing

The order processing workflow in `checkout.php` implements the following steps:

1. **Validation** -- Verify all required fields are populated
2. **Price Calculation** -- Compute subtotal, apply discount (5% above TSh 10M), calculate VAT (18%), determine shipping fee
3. **Order Creation** -- Insert order record with unique order number (format: `NZ-YYYY-NNNNNN`)
4. **Item Processing** -- Insert order items and decrement product stock quantities
5. **Tracking Record** -- Create initial tracking entry
6. **Payment Record** -- Create payment record linked to the order
7. **Cart Clearing** -- Clear session cart after successful order
8. **Email Notification** -- Send HTML order confirmation email
9. **Redirect** -- Redirect to order confirmation page

#### 7.4.4 Recommendation Engine

The network solution recommendation engine (`recommend.php`) uses a rules-based algorithm:

**Input Parameters:**
- Organization type
- Number of users
- Number of departments
- Number of branch locations
- Available budget
- Specific networking needs (routing, switching, wireless, security, cabling)
- Bandwidth requirements

**Decision Logic:**

```
IF needs includes 'routing' OR branches > 1 --> Recommend Routers
IF needs includes 'switching' OR users > 20 --> Recommend Switches
IF needs includes 'wireless' OR users > 30 --> Recommend Access Points
IF needs includes 'security' --> Recommend Firewalls
IF users > 50 OR departments > 5 --> Recommend Servers
IF needs includes 'cabling' --> Recommend Cables & Accessories
IF bandwidth is 'high' or 'very_high' --> Add Switches and Routers

Budget allocation = Total Budget / Number of recommended categories
Select best product per category within allocated budget
```

### 7.5 Frontend Implementation

#### 7.5.1 Design System

The platform uses a consistent design system defined through CSS custom properties:

| Variable | Value | Usage |
|---|---|---|
| `--navy` | #0A2540 | Primary brand color (headers, text) |
| `--orange` | #F05A22 | Accent color (CTAs, highlights) |
| `--bg` | #F4F6F9 | Page background |
| `--card` | #FFFFFF | Card backgrounds |
| `--text-primary` | #0A2540 | Primary text color |
| `--text-secondary` | #5a6a7e | Secondary text color |
| `--border` | #e2e8f0 | Border color |
| `--shadow-sm` | 0 1px 3px... | Small shadow |
| `--shadow-md` | 0 4px 12px... | Medium shadow |
| `--shadow-lg` | 0 10px 30px... | Large shadow |

#### 7.5.2 Responsive Design

The platform implements a mobile-first responsive design with three breakpoints:

| Breakpoint | Target Devices | Layout Changes |
|---|---|---|
| > 1200px | Desktop/Laptop | Full 4-column grid layouts |
| 768px - 1200px | Tablet | 2-column grids, reduced padding |
| < 768px | Mobile | Single column, hamburger menu, stacked layouts |

#### 7.5.3 Interactive Features

- **Hero Carousel** -- Auto-advancing image carousel with 5 slides, navigation arrows, dot indicators, progress bar, and dynamic text content
- **Scroll Reveal Animations** -- IntersectionObserver-based fade-in animations for cards and sections
- **AJAX Cart Updates** -- Asynchronous add-to-cart without page reload using Fetch API
- **Mobile Navigation** -- Slide-out mobile menu with overlay
- **Tab Switching** -- Animated tab slider for login/register forms
- **Password Strength Indicator** -- Real-time password strength evaluation with visual bars
- **SVG Placeholder Generation** -- Dynamic SVG image placeholders when product images are missing

### 7.6 Key Code Implementation Details

#### 7.6.1 Product Catalogue Filtering

The catalogue page (`catalog.php`) builds dynamic SQL queries based on user-selected filters:

```php
$where = [];
$params = [];

if ($categoryFilter) {
    $where[] = "p.category_id = ?";
    $params[] = (int)$categoryFilter;
}
if ($brandFilter) {
    $where[] = "p.brand = ?";
    $params[] = $brandFilter;
}
if ($search) {
    $where[] = "(p.name LIKE ? OR p.sku LIKE ? OR p.brand LIKE ? OR p.specs LIKE ?)";
    $params[] = "%$search%";
    // ... additional parameters
}
```

This approach ensures all filter parameters are properly sanitized through prepared statements.

#### 7.6.2 Email Notification System

HTML emails are generated using inline CSS (for email client compatibility) and sent via PHP's `mail()` function:

```php
function sendEmailNotification($to, $subject, $body) {
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: BN-Infrastructure <noreply@bn-infrastructure.com>\r\n";
    return @mail($to, $subject, $body, $headers);
}
```

#### 7.6.3 Dynamic SVG Placeholder System

When product images are unavailable, the system generates branded SVG placeholders dynamically:

```php
function placeholderSvg($name, $brand = '') {
    // Generate color palette based on product name hash
    $hash = crc32($name ?: 'default');
    $palette = $colors[abs($hash) % count($colors)];
    // Render SVG with gradient background, product icon, and label
    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}
```

---

## 8. System Testing

### 8.1 Testing Strategy

The testing approach encompasses multiple levels:

| Test Level | Description | Tools Used |
|---|---|---|
| Unit Testing | Individual function verification | Manual code review |
| Integration Testing | Module interaction testing | Manual testing via browser |
| System Testing | End-to-end workflow testing | Manual testing |
| User Acceptance Testing | Business requirement validation | Group member testing |

### 8.2 Functional Test Cases

| Test Case ID | Module | Description | Input | Expected Result | Status |
|---|---|---|---|---|---|
| TC-01 | Registration | Register new business account | Valid company details | Account created, redirect to homepage | Pass |
| TC-02 | Registration | Duplicate email detection | Existing email address | Error: "Account already exists" | Pass |
| TC-03 | Login | Valid admin login | Correct admin credentials | Redirect to admin dashboard | Pass |
| TC-04 | Login | Invalid credentials | Wrong password | Error: "Invalid email or password" | Pass |
| TC-05 | Catalogue | Filter by category | Select "Routers" category | Only router products displayed | Pass |
| TC-06 | Catalogue | Search products | Search "MikroTik" | MikroTik products listed | Pass |
| TC-07 | Catalogue | Sort by price | Select "Price: Low to High" | Products sorted ascending | Pass |
| TC-08 | Cart | Add product to cart | Click "Add to Cart" button | Cart badge increments, item added | Pass |
| TC-09 | Cart | Update quantity | Change quantity input | Subtotal recalculated | Pass |
| TC-10 | Cart | Remove item | Click remove button | Item removed, cart updated | Pass |
| TC-11 | Checkout | Place order with valid data | Complete checkout form | Order created, confirmation shown | Pass |
| TC-12 | Checkout | Empty required fields | Submit without phone number | Error: "Please fill in all required fields" | Pass |
| TC-13 | Checkout | Discount calculation | Order above TSh 10M | 5% discount applied | Pass |
| TC-14 | Checkout | Free shipping | Order above TSh 500K | Shipping fee = TSh 0 | Pass |
| TC-15 | Tracking | Track existing order | Valid order number + email | Order details and tracking shown | Pass |
| TC-16 | Tracking | Invalid tracking data | Wrong order number | "No order found" message | Pass |
| TC-17 | Quote | Submit quotation | Add items, submit quote | Quote created with pending status | Pass |
| TC-18 | Recommend | Get recommendations | Enter org requirements | Equipment recommendations displayed | Pass |
| TC-19 | Admin | Add product | Complete product form | Product added to catalogue | Pass |
| TC-20 | Admin | Update order status | Change to "processing" | Order status updated, tracking entry created | Pass |

### 8.3 User Acceptance Testing

A group of 6 team members conducted user acceptance testing by performing typical business workflows on the platform. Testing covered:

1. Complete business account registration and login flow
2. Product browsing, searching, and filtering
3. Adding products to cart and completing a purchase
4. Requesting a quotation for bulk items
5. Tracking an order using order number and email
6. Admin login and dashboard review
7. Admin product and order management
8. Network solution recommendation with various input scenarios

All testers confirmed that the system meets the specified business requirements and provides an intuitive user experience.

---

## 9. User Interface Design

### 9.1 Homepage

The homepage features:
- **Announcement Bar** -- Orange banner with delivery, coverage, and support information
- **Navigation Bar** -- Navy header with logo, product links, search bar, user menu, and cart
- **Hero Carousel** -- 5-slide auto-advancing carousel showcasing product categories with dynamic text, progress bar, and navigation controls
- **Category Grid** -- 4-column grid displaying product categories with icons and descriptions
- **Featured Products** -- 4-column product card grid with images, prices, and quick-action buttons
- **Brands Strip** -- Trusted brand logos (Cisco, MikroTik, Ubiquiti, Fortinet, HP Aruba, D-Link, TP-Link)
- **Promotional Section** -- Two promotional cards (Custom Solutions, Bulk Orders)
- **Trust Bar** -- Four trust indicators (Genuine Products, Fast Delivery, Technical Support, Easy Returns)
- **Footer** -- Brand info, quick links, categories, contact details, newsletter signup, and policy links

### 9.2 Product Catalogue

The catalogue page provides:
- Sidebar filters (category, brand, stock status, price range)
- Sort dropdown (best sellers, price low/high, newest)
- Search bar within the navigation
- Product grid with 4-column layout (desktop), 2-column (tablet), 1-column (mobile)
- Each product card displays: image, SKU, name, brand badge, category badge, price (TSh format), stock status badge, "Add to Cart" button, and "Quote" button
- Pagination controls

### 9.3 Shopping Cart and Checkout

- **Cart Page** -- Table layout showing product details, quantity controls, line totals, and cart summary with subtotal/VAT/discount/shipping calculations
- **Checkout Page** -- Two-column layout: delivery information form (left) and order summary (right), with payment method selection, terms acceptance, and place order button
- **Order Confirmation** -- Success page with order details and tracking information

### 9.4 Admin Dashboard

The admin interface features:
- **Sidebar Navigation** -- Dark navy sidebar with menu items (Dashboard, Products, Add Product, Categories, Orders, Payments, Quotes, Customers, Authorized Users, Reports)
- **Stats Grid** -- 7 key metric cards (Total Products, Total Orders, Categories, Low Stock Items, Quote Requests, Pending Orders, Total Revenue)
- **Recent Activity Tables** -- Recent orders and recent products tables
- **Responsive Behavior** -- Sidebar collapses to icon-only mode on mobile devices

---

## 10. Security Considerations

| Security Measure | Implementation | Status |
|---|---|---|
| **SQL Injection Prevention** | All queries use prepared statements with parameterized binding | Implemented |
| **Password Security** | bcrypt hashing via `password_hash(PASSWORD_DEFAULT)` | Implemented |
| **XSS Prevention** | `htmlspecialchars()` applied to all user-generated output | Implemented |
| **Session Management** | Server-side PHP sessions with proper initialization | Implemented |
| **Input Validation** | Server-side validation of all required fields | Implemented |
| **File Upload Security** | Whitelist of allowed extensions (jpg, jpeg, png, gif, webp), unique filenames | Implemented |
| **Authentication Guards** | `requireLogin()` middleware on admin pages, session checks on protected pages | Implemented |
| **Role-Based Access** | Admin vs customer role separation | Implemented |
| **Error Handling** | Database connection errors caught and displayed safely | Implemented |

**Recommended Additional Security Measures:**

- Implementation of CSRF token protection on all forms
- Rate limiting on login attempts
- HTTPS enforcement via server configuration
- Content Security Policy (CSP) headers
- Input sanitization for rich text fields
- Regular security audits and penetration testing

---

## 11. Significance of the Project

### 11.1 Significance to Businesses and Organizations

The platform provides organizations with easy access to networking equipment and procurement services. Businesses will save time and resources by managing purchasing activities through a centralized digital platform. The quotation system supports the B2B procurement workflow where formal pricing approval is required before purchase.

### 11.2 Significance to Suppliers

The platform will improve operational efficiency by automating product management, quotation handling, order processing, and customer communication. It will also expand market reach beyond traditional sales channels to organizations across all regions of Tanzania.

### 11.3 Significance to IT Departments

IT departments will benefit from easier access to networking products, technical specifications, and procurement services required for maintaining organizational infrastructure. The recommendation engine provides additional value by suggesting appropriate equipment based on organizational requirements.

### 11.4 Significance to Digital Commerce

The project contributes to the growth of B2B e-commerce by demonstrating how networking equipment procurement can be efficiently managed through online platforms. It showcases the application of web technologies to solve real-world procurement challenges in the Tanzanian market.

### 11.5 Significance to Academic Research

The project provides a practical example of applying web technologies, e-commerce principles, and digital procurement systems to solve real-world business challenges in the information technology sector.

---

## 12. Limitations and Future Enhancements

### 12.1 Current Limitations

| Limitation | Impact | Severity |
|---|---|---|
| Session-based cart only (no database persistence) | Cart lost if session expires | Medium |
| No real-time payment gateway integration | Manual payment verification required | High |
| PHP mail() dependency for emails | Emails may fail without proper SMTP configuration | Medium |
| No API layer (REST/GraphQL) | Limited integration with external systems | Medium |
| Inline CSS in some pages | Code maintainability challenges | Low |
| No automated testing framework | Manual regression testing required | Medium |
| Single-server deployment only | No horizontal scaling capability | Low |

### 12.2 Future Enhancements

| Enhancement | Priority | Estimated Effort |
|---|---|---|
| Integration with payment gateways (Vodacom M-Pesa API, Airtel Money API) | High | 2-3 weeks |
| RESTful API development for mobile app integration | High | 3-4 weeks |
| Database-backed cart persistence | High | 1 week |
| SMTP email configuration (PHPMailer/SwiftMailer) | Medium | 1 week |
| Product inventory alerts and automated notifications | Medium | 1 week |
| Multi-language support (Swahili/English) | Medium | 2-3 weeks |
| Progressive Web App (PWA) conversion | Medium | 2 weeks |
| Migration to MVC framework (Laravel) | Low | 4-6 weeks |
| Integration with shipping providers for real-time tracking | Low | 2-3 weeks |
| Machine learning-based product recommendations | Low | 4-6 weeks |
| Customer support chat integration (WhatsApp Business API) | Low | 1-2 weeks |
| Advanced analytics and reporting dashboard | Low | 2-3 weeks |

---

## 13. Conclusion

The Networking Devices B2B E-Commerce Platform (**BN-Infrastructure**) has been successfully designed and implemented as a web-based solution for streamlining the procurement of networking equipment in Tanzania. The platform addresses the key challenges identified in traditional procurement processes by providing a centralized digital marketplace with comprehensive product information, efficient search and filtering capabilities, quotation management, online ordering, and order tracking.

The system was built using a proven technology stack of PHP, MySQL, HTML5, CSS3, and vanilla JavaScript on the XAMPP/LAMP server environment, demonstrating that effective e-commerce solutions can be developed using accessible and cost-effective technologies. The three-tier architecture ensures clear separation of concerns, maintainability, and the potential for future enhancements.

Key achievements of the project include:

1. A fully functional product catalogue with 5 categories and 6 initial products with detailed specifications
2. Multi-criteria search and filtering system supporting category, brand, price range, stock status, and text search
3. Session-based shopping cart with AJAX support for seamless user experience
4. Complete order processing workflow with discount calculation, VAT computation, and shipping logic
5. Quotation request and management system supporting B2B procurement workflows
6. Network solution recommendation engine based on organizational requirements
7. Administrative dashboard for comprehensive platform management
8. Responsive design supporting desktop, tablet, and mobile devices
9. Security measures including prepared statements, password hashing, and role-based access control

The platform is expected to benefit businesses, suppliers, IT departments, and the broader digital commerce ecosystem in Tanzania by facilitating efficient procurement and management of networking infrastructure solutions.

---

## 14. References

1. Laudon, K.C. & Laudon, J.P. (2020). *Management Information Systems: Managing the Digital Firm*. 16th Edition. Pearson.

2. Schneider, G.P. & Perry, J.T. (2021). *Electronic Commerce*. 14th Edition. Cengage Learning.

3. PHP Documentation. (2026). *PHP: Hypertext Preprocessor*. Available at: https://www.php.net/docs/

4. MySQL Documentation. (2026). *MySQL 8.0 Reference Manual*. Available at: https://dev.mysql.com/doc/

5. Mozilla Developer Network. (2026). *HTML5 Specification*. Available at: https://developer.mozilla.org/en-US/docs/Web/HTML

6. W3C. (2026). *CSS Specifications*. Available at: https://www.w3.org/Style/CSS/

7. OWASP Foundation. (2024). *OWASP Top Ten Web Application Security Risks*. Available at: https://owasp.org/www-project-top-ten/

8. Font Awesome. (2026). *Font Awesome Icons*. Available at: https://fontawesome.com/

9. Google Fonts. (2026). *Inter Font Family*. Available at: https://fonts.google.com/specimen/Inter

10. Telecommunications Regulatory Authority (TRA), Tanzania. (2025). *Annual ICT Sector Report*.

---

## 15. Appendices

### Appendix A: Complete Database Schema (SQL)

The full database schema is available in the `data.sql` file included in the project source code. This file contains all CREATE TABLE statements, INSERT statements for seed data, and UPDATE statements for data normalization.

### Appendix B: Product Sample Data

| Product Name | SKU | Brand | Category | Price (TSh) | Stock |
|---|---|---|---|---|---|
| MikroTik CCR2004-1G-12S+2XS Router | MK-CCR2004-1G-12S | MikroTik | Routers | 1,850,000 | 15 |
| Cisco Catalyst 2960X-24TS-L Switch | CISCO-2960X-24TS | Cisco | Switches | 980,000 | 25 |
| Ubiquiti UniFi U6 Pro Access Point | UBNT-U6-PRO | Ubiquiti | Access Points | 320,000 | 50 |
| Panduit CAT6A Structured Cabling Kit | PND-CAT6A-KIT | Panduit | Structured Cabling | 450,000 | 30 |
| Fortinet FortiGate 60F Next-Gen Firewall | FT-FGT60F | Fortinet | Firewalls | 1,200,000 | 10 |
| Networking Equipment Bundle | BUNDLE-NETWK-01 | Multi-Brand | -- | 3,500,000 | 5 |

### Appendix C: URL Routing Map

| URL Path | File | Access Level | Description |
|---|---|---|---|
| `/` | `index.php` | Public | Homepage |
| `/catalog.php` | `catalog.php` | Public | Product catalogue |
| `/product.php?id=N` | `product.php` | Public | Product detail |
| `/cart.php` | `cart.php` | Public | Shopping cart |
| `/checkout.php` | `checkout.php` | Public | Checkout |
| `/login.php` | `login.php` | Public | Login/Register |
| `/track.php` | `track.php` | Public | Order tracking |
| `/recommend.php` | `recommend.php` | Public | Recommendation engine |
| `/dashboard.php` | `dashboard.php` | Authenticated | Customer dashboard |
| `/my-quotes.php` | `my-quotes.php` | Authenticated | My quotations |
| `/invoice.php?id=N` | `invoice.php` | Authenticated | Invoice view |
| `/admin/` | `admin/index.php` | Admin | Admin dashboard |
| `/admin/products.php` | `admin/products.php` | Admin | Product management |
| `/admin/products-add.php` | `admin/products-add.php` | Admin | Add product |
| `/admin/products-edit.php?id=N` | `admin/products-edit.php` | Admin | Edit product |
| `/admin/orders.php` | `admin/orders.php` | Admin | Order management |
| `/admin/payments.php` | `admin/payments.php` | Admin | Payment management |
| `/admin/quotes.php` | `admin/quotes.php` | Admin | Quotation management |
| `/admin/customers.php` | `admin/customers.php` | Admin | Customer management |
| `/admin/categories.php` | `admin/categories.php` | Admin | Category management |
| `/admin/reports.php` | `admin/reports.php` | Admin | Reports |

### Appendix D: CSS Design Tokens

```css
:root {
  --navy: #0A2540;
  --navy-light: #133057;
  --navy-dark: #071a2e;
  --orange: #F05A22;
  --orange-dark: #d44d1a;
  --orange-light: #ff6b35;
  --bg: #F4F6F9;
  --card: #FFFFFF;
  --text-primary: #0A2540;
  --text-secondary: #5a6a7e;
  --text-muted: #8fa0b3;
  --border: #e2e8f0;
  --shadow-sm: 0 1px 3px rgba(10,37,64,0.08), 0 1px 2px rgba(10,37,64,0.04);
  --shadow-md: 0 4px 12px rgba(10,37,64,0.1), 0 2px 6px rgba(10,37,64,0.06);
  --shadow-lg: 0 10px 30px rgba(10,37,64,0.12), 0 4px 12px rgba(10,37,64,0.08);
}
```

### Appendix E: Business Calculation Formulas

```
Subtotal        = SUM(product_price x quantity) for all items
Discount        = Subtotal >= TSh 10,000,000 ? Subtotal x 0.05 : 0
After Discount  = Subtotal - Discount
VAT             = After Discount x 0.18
Shipping        = After Discount >= TSh 500,000 ? 0 : TSh 35,000
Total           = After Discount + VAT + Shipping
```

---

*Report prepared by Group 6 -- BN-Infrastructure Project Team*
*DAR ES SALAAM INSTITUTE OF TECHNOLOGY*
*Module: Fundamentals of E-Commerce (ITT 06216)*
*July 2026*
