<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/functions.php';

$brandName = 'BN-Infrastructure';
$quoteNumber = $_GET['quote'] ?? '';
$quote = null;
$quoteItems = [];

if ($quoteNumber && isLoggedIn()) {
    $quote = fetchOne("SELECT * FROM quotations WHERE quotation_number = ?", [$quoteNumber]);
    if ($quote && $quote['user_id'] != $_SESSION['user_id']) {
        $quote = null;
    }
    if ($quote) {
        $quoteItems = fetchAll("SELECT * FROM quotation_items WHERE quotation_id = ? ORDER BY id ASC", [$quote['id']]);
    }
}

if (!$quote) {
    header('Location: my-quotes.php');
    exit;
}

$itemCount = count($quoteItems);
$quoteDate = date('M d, Y', strtotime($quote['created_at']));
$statusColors = [
    'pending' => ['color' => '#d97706', 'bg' => 'rgba(217,119,6,0.1)', 'border' => 'rgba(217,119,6,0.25)'],
    'reviewed' => ['color' => '#2563eb', 'bg' => 'rgba(37,99,235,0.1)', 'border' => 'rgba(37,99,235,0.25)'],
    'approved' => ['color' => '#059669', 'bg' => 'rgba(5,150,105,0.1)', 'border' => 'rgba(5,150,105,0.25)'],
    'rejected' => ['color' => '#dc2626', 'bg' => 'rgba(220,38,38,0.1)', 'border' => 'rgba(220,38,38,0.25)'],
    'converted' => ['color' => '#0A2540', 'bg' => 'rgba(10,37,64,0.08)', 'border' => 'rgba(10,37,64,0.2)'],
];
$sc = $statusColors[$quote['status']] ?? ['color' => '#888', 'bg' => 'rgba(136,136,136,0.1)', 'border' => 'rgba(136,136,136,0.2)'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quote Confirmed — <?php echo $brandName; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--navy:#0A2540;--navy-light:#133057;--navy-dark:#071a2e;--orange:#F05A22;--orange-dark:#d44d1a;--bg:#F4F6F9;--card:#FFF;--text-primary:#0A2540;--text-secondary:#5a6a7e;--text-muted:#8fa0b3;--border:#e2e8f0;--green:#059669;--green-bg:rgba(5,150,105,0.08);--green-border:rgba(5,150,105,0.2);--shadow-sm:0 1px 3px rgba(10,37,64,0.08),0 1px 2px rgba(10,37,64,0.04);--shadow-md:0 4px 12px rgba(10,37,64,0.1),0 2px 6px rgba(10,37,64,0.06)}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text-primary);font-size:15px;line-height:1.6}
.announcement-bar{background:var(--orange);color:#fff;text-align:center;padding:9px 24px;font-size:13px;font-weight:500}
.announcement-bar i{margin-right:6px;opacity:.9}
.navbar{background:var(--navy);padding:0 48px;display:flex;align-items:center;height:70px;position:sticky;top:0;z-index:1000;box-shadow:0 2px 12px rgba(0,0,0,0.2)}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none;flex-shrink:0}
.nav-logo-icon{width:38px;height:38px;background:var(--orange);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff}
.nav-logo-text{display:flex;flex-direction:column;line-height:1.1}
.nav-logo-text .brand{font-size:18px;font-weight:800;color:#fff;letter-spacing:-0.02em}
.nav-logo-text .tagline{font-size:10px;font-weight:400;color:rgba(255,255,255,0.5);letter-spacing:.08em;text-transform:uppercase}
.nav-links{display:flex;align-items:center;gap:4px;flex:1}
.nav-links a{text-decoration:none;color:rgba(255,255,255,0.75);font-size:14px;font-weight:500;padding:8px 14px;border-radius:6px;transition:color .2s,background .2s;white-space:nowrap}
.nav-links a:hover{color:#fff;background:rgba(255,255,255,0.08)}
.nav-links a.active{color:#fff;background:rgba(255,255,255,0.1)}
.nav-actions{display:flex;align-items:center;gap:12px;flex-shrink:0}
.cart-btn{background:var(--orange);border:none;color:#fff;width:40px;height:40px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:background .2s;font-size:15px;text-decoration:none}
.cart-btn:hover{background:var(--orange-dark)}
.cart-badge{position:absolute;top:-5px;right:-5px;background:#fff;color:var(--orange);font-size:10px;font-weight:700;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--orange)}
.hamburger{display:none;background:none;border:none;color:#fff;font-size:22px;cursor:pointer;padding:6px;margin-left:auto}
.nav-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:999}
.nav-overlay.open{display:block}
.mobile-nav{position:fixed;top:0;right:-280px;width:280px;height:100vh;background:var(--navy);z-index:1001;transition:right .3s ease;padding:80px 24px 24px;overflow-y:auto}
.mobile-nav.open{right:0}
.mobile-nav a{display:block;color:rgba(255,255,255,0.8);text-decoration:none;padding:12px 0;font-size:15px;font-weight:500;border-bottom:1px solid rgba(255,255,255,0.06)}
.mobile-nav a:hover{color:var(--orange)}
.mobile-nav .close-btn{position:absolute;top:16px;right:16px;background:none;border:none;color:#fff;font-size:24px;cursor:pointer}
.mobile-nav .mobile-user{display:block;color:var(--orange);padding:12px 0;font-size:15px;font-weight:600;border-bottom:1px solid rgba(255,255,255,0.06)}
.mobile-nav .mobile-logout{color:#fff!important;font-size:13px!important}
.user-menu{position:relative;display:inline-block}
.user-name{display:inline-flex;align-items:center;gap:6px;color:#fff;font-size:13px;font-weight:500;cursor:pointer;padding:6px 12px;border-radius:7px;transition:background .2s;white-space:nowrap}
.user-name:hover{background:rgba(255,255,255,0.08)}
.user-dropdown{display:none;position:absolute;top:100%;right:0;background:#fff;border:1px solid #e2e8f0;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.15);min-width:180px;z-index:100;overflow:hidden;margin-top:6px}
.user-dropdown.show{display:block}
.user-dropdown a{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#0A2540;font-size:13px;text-decoration:none;transition:background .15s}
.user-dropdown a:hover{background:#F4F6F9}
.user-dropdown a i{width:16px;color:#F05A22;font-size:12px}
.breadcrumb-bar{background:var(--card);border-bottom:1px solid var(--border);padding:14px 48px}
.breadcrumb-inner{max-width:1100px;margin:0 auto;display:flex;align-items:center;gap:8px}
.breadcrumb-inner a{font-size:13px;color:var(--text-secondary);text-decoration:none;transition:color .2s}
.breadcrumb-inner a:hover{color:var(--orange)}
.breadcrumb-inner .sep{font-size:11px;color:var(--text-muted)}
.breadcrumb-inner .current{font-size:13px;font-weight:600;color:var(--navy)}
.main-wrapper{padding:36px 48px 64px}
.main-inner{max-width:1100px;margin:0 auto}
.success-hero{background:linear-gradient(135deg,rgba(5,150,105,0.07) 0%,rgba(5,150,105,0.04) 50%,rgba(16,185,129,0.06) 100%);border:1.5px solid var(--green-border);border-radius:18px;padding:40px 48px;display:flex;align-items:center;gap:32px;margin-bottom:28px;position:relative;overflow:hidden}
.success-hero::before{content:'';position:absolute;top:-60px;right:-60px;width:200px;height:200px;background:radial-gradient(circle,rgba(5,150,105,0.1) 0%,transparent 70%);border-radius:50%}
.success-checkmark{width:80px;height:80px;border-radius:50%;background:var(--green);display:flex;align-items:center;justify-content:center;font-size:34px;color:#fff;flex-shrink:0;box-shadow:0 8px 32px rgba(5,150,105,0.35);animation:checkPop .5s cubic-bezier(0.34,1.56,0.64,1) forwards}
@keyframes checkPop{0%{transform:scale(0);opacity:0}100%{transform:scale(1);opacity:1}}
.success-hero-text{flex:1}
.success-hero-text h1{font-size:30px;font-weight:900;color:var(--navy);letter-spacing:-0.03em;margin-bottom:8px;line-height:1.15;animation:fadeSlideUp .4s ease .15s both}
.success-hero-text p{font-size:15px;color:var(--text-secondary);margin-bottom:18px;animation:fadeSlideUp .4s ease .25s both}
@keyframes fadeSlideUp{0%{transform:translateY(12px);opacity:0}100%{transform:translateY(0);opacity:1}}
.success-badges{display:flex;align-items:center;gap:10px;flex-wrap:wrap;animation:fadeSlideUp .4s ease .35s both}
.quote-number-badge{display:inline-flex;align-items:center;gap:8px;background:var(--orange);color:#fff;padding:8px 16px;border-radius:8px;font-size:14px;font-weight:800;letter-spacing:0.02em}
.quote-number-badge i{font-size:12px;opacity:0.8}
.quote-date-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(10,37,64,0.06);color:var(--navy);border:1.5px solid var(--border);padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600}
.quote-status-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:700}
.section-card{background:var(--card);border-radius:14px;border:1px solid var(--border);box-shadow:var(--shadow-sm);overflow:hidden;margin-bottom:22px}
.section-card-header{padding:18px 24px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
.section-card-header h2{font-size:15px;font-weight:700;color:var(--navy);display:flex;align-items:center;gap:8px}
.section-card-header h2 i{color:var(--orange);font-size:14px}
.section-number{width:24px;height:24px;background:var(--orange);border-radius:50%;color:#fff;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.quote-items-table{width:100%;border-collapse:collapse}
.quote-items-table th{background:#f8fafc;padding:14px 24px;text-align:left;font-size:11px;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid var(--border)}
.quote-items-table td{padding:16px 24px;border-bottom:1px solid var(--border);font-size:14px;vertical-align:middle}
.quote-items-table tr:last-child td{border-bottom:none}
.quote-items-table tr:hover td{background:#fdfdfd}
.summary-body{padding:18px 24px}
.summary-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.summary-row:last-of-type{margin-bottom:0}
.summary-row .s-label{font-size:13px;color:var(--text-secondary);font-weight:500;display:flex;align-items:center;gap:6px}
.summary-row .s-value{font-size:13px;font-weight:600;color:var(--navy)}
.discount-row{background:var(--green-bg);border:1px solid var(--green-border);border-radius:8px;padding:9px 14px;margin:12px 0;display:flex;align-items:center;justify-content:space-between}
.discount-row .s-label{font-size:12px;font-weight:700;color:var(--green);display:flex;align-items:center;gap:6px}
.discount-row .s-value{font-size:13px;font-weight:800;color:var(--green)}
.summary-divider{height:1px;background:var(--border);margin:14px 0}
.summary-total-row{display:flex;align-items:center;justify-content:space-between;padding:12px 0 4px}
.summary-total-row .total-label{font-size:15px;font-weight:700;color:var(--navy)}
.summary-total-row .total-value{font-size:24px;font-weight:900;color:var(--navy);letter-spacing:-0.03em}
.summary-total-row .total-value .currency{font-size:13px;font-weight:600;color:var(--text-secondary)}
.summary-vat-note{font-size:11px;color:var(--text-muted);text-align:right;margin-top:4px}
.details-grid{padding:22px 24px;display:grid;grid-template-columns:1fr 1fr;gap:18px}
.detail-item{display:flex;flex-direction:column;gap:4px}
.detail-item.full{grid-column:1/-1}
.detail-label{font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em}
.detail-value{font-size:14px;font-weight:600;color:var(--navy);line-height:1.4}
.admin-notes-box{margin:0 24px 20px;padding:16px;background:rgba(10,37,64,0.03);border:1px solid var(--border);border-left:3px solid var(--navy);border-radius:0 8px 8px 0}
.admin-notes-box .label{font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;display:flex;align-items:center;gap:5px}
.admin-notes-box .label i{color:var(--orange)}
.admin-notes-box p{font-size:13px;color:var(--text-secondary);line-height:1.6}
.next-steps-card{background:var(--card);border-radius:14px;border:1px solid var(--border);box-shadow:var(--shadow-md);overflow:hidden}
.next-steps-header{padding:18px 22px 16px;border-bottom:1px solid var(--border);background:linear-gradient(135deg,var(--navy) 0%,var(--navy-light) 100%)}
.next-steps-header h3{font-size:15px;font-weight:700;color:#fff;display:flex;align-items:center;gap:8px}
.next-steps-header h3 i{color:rgba(255,255,255,0.6)}
.next-steps-list{padding:16px 22px;display:flex;flex-direction:column}
.next-step-item{display:flex;gap:14px;padding:14px 0;position:relative}
.next-step-item:not(:last-child)::after{content:'';position:absolute;left:18px;top:46px;width:2px;height:calc(100% - 16px);background:var(--border)}
.step-icon-circle{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;z-index:1}
.step-icon-circle.active{background:var(--orange);color:#fff;box-shadow:0 2px 10px rgba(240,90,34,0.35)}
.step-icon-circle.pending{background:#f0f3f7;color:var(--text-muted)}
.next-step-content{flex:1;padding-top:2px}
.next-step-name{font-size:13px;font-weight:700;margin-bottom:3px;line-height:1.2}
.next-step-name.active{color:var(--orange)}
.next-step-name.pending{color:var(--text-secondary)}
.next-step-desc{font-size:12px;color:var(--text-muted);line-height:1.5}
.step-status-pill{font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;display:inline-block;margin-bottom:4px}
.pill-active{background:rgba(240,90,34,0.1);color:var(--orange)}
.pill-pending{background:#f0f3f7;color:var(--text-muted)}
.right-actions{display:flex;flex-direction:column;gap:10px;padding:0 22px 20px}
.btn-track{width:100%;background:var(--orange);color:#fff;border:none;padding:13px 20px;border-radius:10px;font-family:'Inter',sans-serif;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .2s;text-decoration:none}
.btn-track:hover{background:var(--orange-dark);transform:translateY(-1px);box-shadow:0 6px 20px rgba(240,90,34,0.35)}
.btn-browse{width:100%;background:transparent;color:var(--navy);border:2px solid var(--border);padding:11px 20px;border-radius:10px;font-family:'Inter',sans-serif;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .2s;text-decoration:none}
.btn-browse:hover{border-color:var(--navy);background:var(--navy);color:#fff;transform:translateY(-1px)}
.manager-card{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-light) 100%);border-radius:14px;padding:22px;overflow:hidden;position:relative;margin-bottom:22px}
.manager-card::before{content:'';position:absolute;top:-30px;right:-30px;width:100px;height:100px;background:rgba(255,255,255,0.04);border-radius:50%}
.manager-card-top{display:flex;align-items:center;gap:12px;margin-bottom:14px}
.manager-avatar{width:44px;height:44px;border-radius:50%;border:2px solid rgba(255,255,255,0.2);flex-shrink:0;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;font-size:18px;color:rgba(255,255,255,0.6)}
.manager-info{flex:1}
.manager-label{font-size:10px;font-weight:600;color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:0.08em}
.manager-name{font-size:15px;font-weight:700;color:#fff}
.manager-role{font-size:12px;color:rgba(255,255,255,0.5)}
.manager-card p{font-size:12px;color:rgba(255,255,255,0.55);line-height:1.55;margin-bottom:14px}
.btn-whatsapp{width:100%;background:#25D366;color:#fff;border:none;padding:11px 16px;border-radius:9px;font-family:'Inter',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .2s;text-decoration:none}
.btn-whatsapp:hover{background:#1db954;transform:translateY(-1px);box-shadow:0 4px 14px rgba(37,211,102,0.4)}
.confirm-layout{display:grid;grid-template-columns:1fr 360px;gap:28px;align-items:start}
.left-col{display:flex;flex-direction:column;gap:22px}
.right-col{position:sticky;top:90px;display:flex;flex-direction:column;gap:16px}
.continue-bar{text-align:center;margin-top:8px}
.continue-bar a{font-size:13px;color:var(--text-secondary);text-decoration:none;display:inline-flex;align-items:center;gap:7px;font-weight:500;padding:10px 20px;border-radius:8px;transition:all .2s}
.continue-bar a:hover{color:var(--orange);background:rgba(240,90,34,0.06)}
footer{background:var(--navy-dark);padding:64px 48px 0;border-top:1px solid rgba(255,255,255,0.06)}
.footer-inner{max-width:1632px;margin:0 auto}
.footer-grid{display:grid;grid-template-columns:280px 1fr 1fr 300px;gap:48px;padding-bottom:48px;border-bottom:1px solid rgba(255,255,255,0.08)}
.footer-brand .logo{display:flex;align-items:center;gap:10px;margin-bottom:16px}
.footer-brand .logo .icon{width:36px;height:36px;background:var(--orange);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:17px;color:#fff}
.footer-brand .logo .name{font-size:18px;font-weight:800;color:#fff}
.footer-brand p{font-size:13px;color:rgba(255,255,255,0.5);line-height:1.7;margin-bottom:20px}
.footer-socials{display:flex;gap:8px}
.footer-social-btn{width:34px;height:34px;background:rgba(255,255,255,0.06);border-radius:7px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);font-size:14px;cursor:pointer;transition:all .2s;text-decoration:none}
.footer-social-btn:hover{background:var(--orange);color:#fff}
.footer-col h4{font-size:13px;font-weight:700;color:#fff;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:18px}
.footer-col ul{list-style:none;display:flex;flex-direction:column;gap:10px}
.footer-col ul li a{font-size:13px;color:rgba(255,255,255,0.5);text-decoration:none;display:flex;align-items:center;gap:7px;transition:color .2s}
.footer-col ul li a:hover{color:rgba(255,255,255,0.9)}
.footer-col ul li a i{font-size:11px;color:var(--orange);opacity:.7}
.contact-item{display:flex;gap:10px;margin-bottom:12px}
.contact-item i{color:var(--orange);font-size:14px;margin-top:2px;flex-shrink:0}
.contact-item span{font-size:13px;color:rgba(255,255,255,0.5);line-height:1.5}
.footer-bottom{padding:20px 0;display:flex;align-items:center;justify-content:space-between}
.footer-bottom p{font-size:12px;color:rgba(255,255,255,0.35)}
.footer-bottom-links{display:flex;gap:20px}
.footer-bottom-links a{font-size:12px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color .2s}
.footer-bottom-links a:hover{color:rgba(255,255,255,0.6)}
.reveal{opacity:0;transform:translateY(24px);transition:opacity .6s ease,transform .6s ease}
@media(max-width:1024px){.confirm-layout{grid-template-columns:1fr}.right-col{position:static}.details-grid{grid-template-columns:1fr}}
@media(max-width:768px){.navbar{padding:0 20px;height:60px}.nav-links{display:none}.hamburger{display:block}.main-wrapper{padding:20px 20px 40px}.breadcrumb-bar{padding:12px 20px}.success-hero{flex-direction:column;text-align:center;padding:28px 24px}.success-badges{justify-content:center}.footer-grid{grid-template-columns:1fr}}
</style>
</head>
<body>

<div class="announcement-bar"><i class="fas fa-truck"></i> Free delivery on orders above TSh 500,000 <span>|</span> Serving all regions in Tanzania</div>

<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <div class="nav-logo-icon"><i class="fas fa-network-wired"></i></div>
    <div class="nav-logo-text"><span class="brand">BN-Infrastructure</span><span class="tagline">Tanzania</span></div>
  </a>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="catalog.php">Products</a>
    <a href="about.php">Solutions</a>
    <a href="my-quotes.php" class="active">Quotes</a>
    <a href="track.php">Track Order</a>
  </div>
  <div class="nav-actions">
    <?php echo userNavHtml(); ?>
    <a href="cart.php" class="cart-btn"><i class="fas fa-shopping-cart"></i><span class="cart-badge"><?php echo cartCount(); ?></span></a>
    <button class="hamburger" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>
  </div>
</nav>
<div class="nav-overlay" id="navOverlay" onclick="toggleMenu()"></div>
<div class="mobile-nav" id="mobileNav">
  <button class="close-btn" onclick="toggleMenu()"><i class="fas fa-times"></i></button>
  <a href="index.php" onclick="toggleMenu()">Home</a>
  <a href="catalog.php" onclick="toggleMenu()">Products</a>
  <a href="about.php" onclick="toggleMenu()">Solutions</a>
  <a href="my-quotes.php" onclick="toggleMenu()">Quotes</a>
  <a href="track.php" onclick="toggleMenu()">Track Order</a>
  <?php echo mobileAccountHtml(); ?>
  <a href="cart.php" onclick="toggleMenu()">Cart</a>
</div>

<div class="breadcrumb-bar">
  <div class="breadcrumb-inner">
    <a href="index.php">Home</a>
    <span class="sep"><i class="fas fa-chevron-right"></i></span>
    <a href="catalog.php">Products</a>
    <span class="sep"><i class="fas fa-chevron-right"></i></span>
    <a href="cart.php">Cart</a>
    <span class="sep"><i class="fas fa-chevron-right"></i></span>
    <span class="current">Quote Confirmed</span>
  </div>
</div>

<div class="main-wrapper">
  <div class="main-inner">

    <div class="success-hero reveal">
      <div class="success-checkmark">
        <i class="fas fa-check"></i>
      </div>
      <div class="success-hero-text">
        <h1>Quote Request Submitted!</h1>
        <p>Thank you for your quote request. Our sales team will review your requirements and respond within 2–4 business hours.</p>
        <div class="success-badges">
          <div class="quote-number-badge">
            <i class="fas fa-hashtag"></i>
            <?php echo htmlspecialchars($quote['quotation_number']); ?>
          </div>
          <div class="quote-date-badge">
            <i class="far fa-calendar"></i>
            <?php echo $quoteDate; ?>
          </div>
          <span class="quote-status-badge" style="color:<?php echo $sc['color']; ?>;background:<?php echo $sc['bg']; ?>;border:1.5px solid <?php echo $sc['border']; ?>;">
            <span style="width:6px;height:6px;border-radius:50%;background:<?php echo $sc['color']; ?>;"></span>
            <?php echo ucfirst($quote['status']); ?>
          </span>
        </div>
      </div>
    </div>

    <div class="confirm-layout">

      <div class="left-col">

        <div class="section-card">
          <div class="section-card-header">
            <h2>
              <div class="section-number">1</div>
              <i class="fas fa-receipt"></i> Quote Items
            </h2>
            <span style="font-size:12px;color:var(--text-muted);font-weight:500;"><?php echo $itemCount; ?> item<?php echo $itemCount !== 1 ? 's' : ''; ?></span>
          </div>
          <table class="quote-items-table">
            <thead>
              <tr>
                <th>Product</th>
                <th>SKU</th>
                <th style="text-align:center;">Qty</th>
                <th style="text-align:right;">Unit Price</th>
                <th style="text-align:right;">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($quoteItems as $item): ?>
              <tr>
                <td style="font-weight:600;color:var(--navy);"><?php echo htmlspecialchars($item['product_name']); ?></td>
                <td style="color:var(--text-muted);font-size:12px;"><?php echo htmlspecialchars($item['product_sku']); ?></td>
                <td style="text-align:center;"><?php echo $item['quantity']; ?></td>
                <td style="text-align:right;">TSh <?php echo number_format($item['unit_price'], 0, '.', ','); ?></td>
                <td style="text-align:right;font-weight:700;color:var(--navy);">TSh <?php echo number_format($item['total_price'], 0, '.', ','); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <div class="summary-body">
            <div class="summary-row">
              <span class="s-label"><i class="fas fa-box" style="color:var(--text-muted);font-size:11px;"></i> Subtotal (<?php echo $itemCount; ?> item<?php echo $itemCount !== 1 ? 's' : ''; ?>)</span>
              <span class="s-value">TSh <?php echo number_format($quote['subtotal'], 0, '.', ','); ?></span>
            </div>
            <?php if ($quote['discount'] > 0): ?>
            <div class="discount-row">
              <span class="s-label"><i class="fas fa-tags"></i> Bulk Discount (5%)</span>
              <span class="s-value">−TSh <?php echo number_format($quote['discount'], 0, '.', ','); ?></span>
            </div>
            <?php endif; ?>
            <div class="summary-row">
              <span class="s-label"><i class="fas fa-receipt" style="color:var(--text-muted);font-size:11px;"></i> VAT (18%)</span>
              <span class="s-value">TSh <?php echo number_format($quote['vat'], 0, '.', ','); ?></span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-total-row">
              <span class="total-label">Grand Total</span>
              <span class="total-value"><span class="currency">TSh </span><?php echo number_format($quote['total'], 0, '.', ','); ?></span>
            </div>
            <div class="summary-vat-note">All prices in Tanzanian Shillings · 18% VAT included</div>
          </div>
        </div>

        <div class="section-card">
          <div class="section-card-header">
            <h2>
              <div class="section-number">2</div>
              <i class="fas fa-building"></i> Contact Details
            </h2>
          </div>
          <div class="details-grid">
            <?php if (!empty($quote['company_name'])): ?>
            <div class="detail-item">
              <span class="detail-label">Company Name</span>
              <span class="detail-value"><?php echo htmlspecialchars($quote['company_name']); ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($quote['contact_name'])): ?>
            <div class="detail-item">
              <span class="detail-label">Contact Person</span>
              <span class="detail-value"><?php echo htmlspecialchars($quote['contact_name']); ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($quote['contact_email'])): ?>
            <div class="detail-item">
              <span class="detail-label">Email Address</span>
              <span class="detail-value"><?php echo htmlspecialchars($quote['contact_email']); ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($quote['contact_phone'])): ?>
            <div class="detail-item">
              <span class="detail-label">Phone Number</span>
              <span class="detail-value"><?php echo htmlspecialchars($quote['contact_phone']); ?></span>
            </div>
            <?php endif; ?>
            <div class="detail-item">
              <span class="detail-label">Submission Date</span>
              <span class="detail-value"><?php echo date('M d, Y \a\t h:i A', strtotime($quote['created_at'])); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Status</span>
              <span class="detail-value" style="color:<?php echo $sc['color']; ?>;"><?php echo ucfirst($quote['status']); ?></span>
            </div>
          </div>
        </div>

        <?php if (!empty($quote['notes'])): ?>
        <div class="section-card">
          <div class="section-card-header">
            <h2>
              <div class="section-number">3</div>
              <i class="fas fa-comment-alt"></i> Your Notes
            </h2>
          </div>
          <div style="padding:20px 24px;">
            <p style="font-size:14px;color:var(--text-secondary);line-height:1.7;"><?php echo nl2br(htmlspecialchars($quote['notes'])); ?></p>
          </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($quote['admin_notes'])): ?>
        <div class="section-card">
          <div class="section-card-header">
            <h2>
              <i class="fas fa-comment-dots"></i> Team Response
            </h2>
          </div>
          <div class="admin-notes-box" style="margin:16px 20px 16px;">
            <div class="label"><i class="fas fa-headset"></i> Admin Notes</div>
            <p><?php echo nl2br(htmlspecialchars($quote['admin_notes'])); ?></p>
          </div>
        </div>
        <?php endif; ?>

      </div>

      <div class="right-col">

        <div class="next-steps-card reveal">
          <div class="next-steps-header">
            <h3><i class="fas fa-route"></i> What Happens Next?</h3>
          </div>
          <div class="next-steps-list">

            <div class="next-step-item">
              <div class="step-icon-circle active"><i class="fas fa-search"></i></div>
              <div class="next-step-content">
                <div class="step-status-pill pill-active">In Progress</div>
                <div class="next-step-name active">1. Our Team Reviews</div>
                <div class="next-step-desc">Our sales and technical team will review your quote request, verify product availability, and prepare the best pricing.</div>
              </div>
            </div>

            <div class="next-step-item">
              <div class="step-icon-circle pending"><i class="fas fa-envelope"></i></div>
              <div class="next-step-content">
                <div class="step-status-pill pill-pending">Upcoming</div>
                <div class="next-step-name pending">2. You Receive a Detailed Response</div>
                <div class="next-step-desc">We'll send you a detailed quotation via email and WhatsApp with final pricing, delivery estimates, and payment terms.</div>
              </div>
            </div>

            <div class="next-step-item">
              <div class="step-icon-circle pending"><i class="fas fa-shopping-cart"></i></div>
              <div class="next-step-content">
                <div class="step-status-pill pill-pending">Upcoming</div>
                <div class="next-step-name pending">3. Convert to Order</div>
                <div class="next-step-desc">Once approved, you can convert your quote into a purchase order with your preferred payment and delivery method.</div>
              </div>
            </div>

          </div>

          <div class="right-actions">
            <a href="my-quotes.php" class="btn-track">
              <i class="fas fa-file-alt"></i> View My Quotes
            </a>
            <a href="catalog.php" class="btn-browse">
              <i class="fas fa-store"></i> Continue Browsing
            </a>
          </div>
        </div>

        <div class="manager-card">
          <div class="manager-card-top">
            <div class="manager-avatar">
              <i class="fas fa-user-tie"></i>
            </div>
            <div class="manager-info">
              <div class="manager-label">Your Account Manager</div>
              <div class="manager-name">Sales Team</div>
              <div class="manager-role">B2B Account Support</div>
            </div>
          </div>
          <p>Have questions about your quote? Our team is available Monday–Friday, 8am–6pm EAT.</p>
          <a href="https://wa.me/255763364721" target="_blank" class="btn-whatsapp">
            <i class="fab fa-whatsapp" style="font-size:16px;"></i>
            Chat on WhatsApp
          </a>
        </div>

        <div class="continue-bar" style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
          <a href="catalog.php" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:var(--navy);color:#fff;border-radius:10px;font-weight:600;font-size:14px;">
            <i class="fas fa-store"></i> Continue Shopping
          </a>
          <a href="my-quotes.php" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border:2px solid var(--border);color:var(--navy);border-radius:10px;font-weight:600;font-size:14px;">
            <i class="fas fa-file-alt"></i> My Quotes
          </a>
        </div>

      </div>
    </div>

  </div>
</div>

<footer>
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="logo"><div class="icon"><i class="fas fa-network-wired"></i></div><span class="name">BN-Infrastructure</span></div>
        <p>Tanzania's leading B2B network infrastructure supplier. Empowering businesses with enterprise-grade connectivity solutions since 2012.</p>
        <div class="footer-socials">
          <a href="#" class="footer-social-btn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="footer-social-btn"><i class="fab fa-twitter"></i></a>
          <a href="#" class="footer-social-btn"><i class="fab fa-facebook-f"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="catalog.php"><i class="fas fa-chevron-right"></i> All Products</a></li>
          <li><a href="about.php"><i class="fas fa-chevron-right"></i> Solutions</a></li>
          <li><a href="track.php"><i class="fas fa-chevron-right"></i> Order Tracking</a></li>
          <li><a href="my-quotes.php"><i class="fas fa-chevron-right"></i> My Quotes</a></li>
          <li><a href="cart.php"><i class="fas fa-chevron-right"></i> Request a Quote</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="about.php"><i class="fas fa-chevron-right"></i> About BN-Infrastructure</a></li>
          <li><a href="catalog.php"><i class="fas fa-chevron-right"></i> Our Brands</a></li>
          <li><a href="about.php"><i class="fas fa-chevron-right"></i> Solutions</a></li>
          <li><a href="privacy.php"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Contact Us</h4>
        <div class="contact-item"><i class="fas fa-map-marker-alt"></i><span>Plot 45, Mikocheni Light Industrial Area, Dar es Salaam, Tanzania</span></div>
        <div class="contact-item"><i class="fas fa-phone-alt"></i><span>+255 763 364 721</span></div>
        <div class="contact-item"><i class="fas fa-envelope"></i><span>sales@bn-infrastructure.com</span></div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; <?php echo date('Y'); ?> BN-Infrastructure. All rights reserved.</p>
      <div class="footer-bottom-links">
        <a href="privacy.php">Privacy Policy</a>
        <a href="terms.php">Terms of Service</a>
        <a href="shipping.php">Shipping Policy</a>
        <a href="returns.php">Returns</a>
      </div>
    </div>
  </div>
</footer>

<script>
function toggleMenu(){document.getElementById('mobileNav').classList.toggle('open');document.getElementById('navOverlay').classList.toggle('open')}
document.addEventListener('click',function(e){var dd=document.getElementById('userDropdown');if(dd&&!e.target.closest('.user-menu'))dd.classList.remove('show')});
document.addEventListener('DOMContentLoaded',function(){var items=document.querySelectorAll('.reveal');if(items.length){var obs=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.style.opacity='1';e.target.style.transform='translateY(0)';obs.unobserve(e.target)}})},{threshold:0.1});items.forEach(function(el){el.style.opacity='0';el.style.transform='translateY(24px)';el.style.transition='opacity .6s ease, transform .6s ease';obs.observe(el)})}});
</script>
</body>
</html>
