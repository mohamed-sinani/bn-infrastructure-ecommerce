<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$userId = (int)$_SESSION['user_id'];
$brandName = 'BN-Infrastructure';
$quotes = fetchAll("SELECT * FROM quotations WHERE user_id = ? ORDER BY created_at DESC", [$userId]);
$quoteItems = [];
foreach ($quotes as $q) {
    $quoteItems[$q['id']] = fetchAll("SELECT * FROM quotation_items WHERE quotation_id = ? ORDER BY id ASC", [$q['id']]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Quotes — <?php echo $brandName; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--navy:#0A2540;--navy-dark:#071a2e;--orange:#F05A22;--orange-dark:#d44d1a;--bg:#F4F6F9;--card:#FFF;--text-primary:#0A2540;--text-secondary:#5a6a7e;--text-muted:#8fa0b3;--border:#e2e8f0;--shadow-sm:0 1px 3px rgba(10,37,64,0.08),0 1px 2px rgba(10,37,64,0.04);--shadow-md:0 4px 12px rgba(10,37,64,0.1),0 2px 6px rgba(10,37,64,0.06)}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text-primary);font-size:15px;line-height:1.6}
.announcement-bar{background:var(--orange);color:#fff;text-align:center;padding:9px 24px;font-size:13px;font-weight:500;letter-spacing:.01em}
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
.cart-btn{background:var(--orange);border:none;color:#fff;width:40px;height:40px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:background .2s,transform .2s;font-size:15px;text-decoration:none}
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
.page-wrap{max-width:1100px;margin:0 auto;padding:36px 24px 64px}
.page-header{margin-bottom:28px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px}
.page-header h1{font-size:26px;font-weight:800;color:var(--navy);letter-spacing:-0.02em;display:flex;align-items:center;gap:12px}
.page-header h1 i{color:var(--orange);font-size:22px}
.page-header .quote-count{font-size:14px;font-weight:600;color:var(--text-secondary);background:var(--bg);border:1px solid var(--border);padding:3px 12px;border-radius:20px}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 20px;border-radius:9px;font-family:'Inter',sans-serif;font-size:14px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:all .2s}
.btn-primary{background:var(--orange);color:#fff}
.btn-primary:hover{background:var(--orange-dark);transform:translateY(-1px);box-shadow:0 4px 12px rgba(240,90,34,0.3)}
.btn-outline{background:transparent;color:var(--navy);border:2px solid var(--border);padding:10px 18px}
.btn-outline:hover{border-color:var(--navy);background:var(--navy);color:#fff}
.quote-card{background:var(--card);border:1px solid var(--border);border-radius:14px;overflow:hidden;box-shadow:var(--shadow-sm);margin-bottom:20px;transition:box-shadow .2s}
.quote-card:hover{box-shadow:var(--shadow-md)}
.quote-card-header{padding:20px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;cursor:pointer;transition:background .15s}
.quote-card-header:hover{background:#fafbfc}
.quote-left{display:flex;align-items:center;gap:16px;flex-wrap:wrap}
.quote-icon{width:44px;height:44px;background:rgba(10,37,64,0.06);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--navy);flex-shrink:0}
.quote-info h3{font-size:16px;font-weight:700;color:var(--navy);margin-bottom:2px}
.quote-info .quote-meta{font-size:12px;color:var(--text-muted);display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.quote-right{display:flex;align-items:center;gap:16px;flex-wrap:wrap}
.quote-total{font-size:18px;font-weight:800;color:var(--navy);white-space:nowrap}
.status-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap}
.status-badge .dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
.expand-btn{width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);transition:all .2s;font-size:13px}
.expand-btn:hover{border-color:var(--navy);color:var(--navy);background:rgba(10,37,64,0.04)}
.quote-card-body{display:none;padding:0}
.quote-card-body.open{display:block}
.quote-items-table{width:100%;border-collapse:collapse}
.quote-items-table th{background:#f8fafc;padding:12px 24px;text-align:left;font-size:11px;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em}
.quote-items-table td{padding:14px 24px;border-bottom:1px solid var(--border);font-size:13px;vertical-align:middle}
.quote-items-table tr:last-child td{border-bottom:none}
.quote-items-table tr:hover td{background:#fdfdfd}
.quote-admin-notes{margin:0 24px 20px;padding:16px;background:rgba(10,37,64,0.03);border:1px solid var(--border);border-left:3px solid var(--navy);border-radius:0 8px 8px 0}
.quote-admin-notes .admin-label{font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;display:flex;align-items:center;gap:5px}
.quote-admin-notes .admin-label i{color:var(--orange)}
.quote-admin-notes p{font-size:13px;color:var(--text-secondary);line-height:1.6}
.quote-financials{padding:16px 24px 20px;display:flex;justify-content:flex-end}
.quote-financials-inner{text-align:right}
.quote-financials .fin-row{font-size:13px;color:var(--text-secondary);margin-bottom:4px}
.quote-financials .fin-row.total{font-size:16px;font-weight:800;color:var(--navy);margin-top:6px;padding-top:6px;border-top:1px solid var(--border)}
.quote-footer{padding:14px 24px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:#fafbfd;flex-wrap:wrap;gap:10px}
.quote-footer a{font-size:13px;font-weight:600;color:var(--orange);text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:gap .2s,color .2s}
.quote-footer a:hover{gap:8px;color:var(--orange-dark)}
.empty-state{padding:60px 24px;text-align:center;color:var(--text-muted);background:var(--card);border:1px solid var(--border);border-radius:14px}
.empty-state i{font-size:48px;color:#cbd5e1;margin-bottom:20px}
.empty-state h3{font-size:18px;font-weight:700;color:var(--navy);margin-bottom:8px}
.empty-state p{margin-bottom:24px;font-size:14px}
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
@media(max-width:900px){.footer-grid{grid-template-columns:1fr 1fr}}
@media(max-width:768px){.navbar{padding:0 20px;height:60px}.nav-links{display:none}.hamburger{display:block}.page-wrap{padding:20px 16px 40px}.breadcrumb-bar{padding:12px 16px}.quote-card-header{padding:16px 18px}.quote-right{flex-direction:column;align-items:flex-start;gap:8px}.quote-items-table th,.quote-items-table td{padding:12px 16px}.footer-grid{grid-template-columns:1fr}.footer{padding:40px 20px 0}footer{padding:40px 20px 0}}
@media(max-width:480px){.quote-left{gap:10px}.quote-info .quote-meta{flex-direction:column;align-items:flex-start;gap:4px}}
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
  <a href="my-quotes.php" onclick="toggleMenu()" style="color:var(--orange);">Quotes</a>
  <a href="track.php" onclick="toggleMenu()">Track Order</a>
  <?php echo mobileAccountHtml(); ?>
  <a href="cart.php" onclick="toggleMenu()">Cart</a>
</div>

<div class="breadcrumb-bar">
  <div class="breadcrumb-inner">
    <a href="index.php">Home</a>
    <span class="sep"><i class="fas fa-chevron-right"></i></span>
    <a href="dashboard.php">Dashboard</a>
    <span class="sep"><i class="fas fa-chevron-right"></i></span>
    <span class="current">My Quotes</span>
  </div>
</div>

<div class="page-wrap">
  <div class="page-header reveal">
    <h1><i class="fas fa-file-alt"></i> My Quotes <span class="quote-count"><?php echo count($quotes); ?> Quote<?php echo count($quotes) !== 1 ? 's' : ''; ?></span></h1>
    <a href="catalog.php" class="btn btn-primary"><i class="fas fa-plus"></i> Request New Quote</a>
  </div>

  <?php if (empty($quotes)): ?>
  <div class="empty-state reveal">
    <i class="fas fa-file-alt"></i>
    <h3>No Quotes Yet</h3>
    <p>You haven't submitted any quote requests. Browse our catalog and add items to your cart to request a quote.</p>
    <a href="catalog.php" class="btn btn-primary" style="display:inline-flex;"><i class="fas fa-shopping-cart"></i> Browse Products</a>
  </div>
  <?php else: ?>
    <?php foreach ($quotes as $q): ?>
    <div class="quote-card reveal">
      <div class="quote-card-header" onclick="toggleQuote(<?php echo $q['id']; ?>)">
        <div class="quote-left">
          <div class="quote-icon"><i class="fas fa-file-alt"></i></div>
          <div class="quote-info">
            <h3><?php echo htmlspecialchars($q['quotation_number']); ?></h3>
            <div class="quote-meta">
              <span><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($q['created_at'])); ?></span>
              <span><i class="fas fa-box"></i> <?php echo count($quoteItems[$q['id']]); ?> item<?php echo count($quoteItems[$q['id']]) !== 1 ? 's' : ''; ?></span>
              <?php if (!empty($q['company_name'])): ?>
              <span><i class="fas fa-building"></i> <?php echo htmlspecialchars($q['company_name']); ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="quote-right">
          <?php
          $statusColors = [
            'pending' => ['#d97706', 'rgba(217,119,6,0.1)'],
            'reviewed' => ['#2563eb', 'rgba(37,99,235,0.1)'],
            'approved' => ['#059669', 'rgba(5,150,105,0.1)'],
            'rejected' => ['#dc2626', 'rgba(220,38,38,0.1)'],
            'converted' => ['#0A2540', 'rgba(10,37,64,0.1)'],
          ];
          $sc = $statusColors[$q['status']] ?? ['#888', 'rgba(136,136,136,0.1)'];
          ?>
          <span class="status-badge" style="color:<?php echo $sc[0]; ?>;background:<?php echo $sc[1]; ?>;">
            <span class="dot" style="background:<?php echo $sc[0]; ?>;"></span>
            <?php echo ucfirst($q['status']); ?>
          </span>
          <span class="quote-total">TSh <?php echo number_format($q['total'], 0, '.', ','); ?></span>
          <button class="expand-btn" id="expandBtn-<?php echo $q['id']; ?>"><i class="fas fa-chevron-down"></i></button>
        </div>
      </div>
      <div class="quote-card-body" id="quoteBody-<?php echo $q['id']; ?>">
        <table class="quote-items-table">
          <thead>
            <tr>
              <th>Product</th>
              <th>SKU</th>
              <th style="text-align:center;">Qty</th>
              <th style="text-align:right;">Unit Price</th>
              <th style="text-align:right;">Line Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($quoteItems[$q['id']] as $item): ?>
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
        <?php if (!empty($q['admin_notes'])): ?>
        <div class="quote-admin-notes">
          <div class="admin-label"><i class="fas fa-comment-dots"></i> Admin Notes</div>
          <p><?php echo nl2br(htmlspecialchars($q['admin_notes'])); ?></p>
        </div>
        <?php endif; ?>
        <div class="quote-financials">
          <div class="quote-financials-inner">
            <div class="fin-row">Subtotal: TSh <?php echo number_format($q['subtotal'], 0, '.', ','); ?></div>
            <?php if ($q['discount'] > 0): ?>
            <div class="fin-row">Discount: −TSh <?php echo number_format($q['discount'], 0, '.', ','); ?></div>
            <?php endif; ?>
            <div class="fin-row">VAT (18%): TSh <?php echo number_format($q['vat'], 0, '.', ','); ?></div>
            <div class="fin-row total">Total: TSh <?php echo number_format($q['total'], 0, '.', ','); ?></div>
          </div>
        </div>
        <div class="quote-footer">
          <span style="font-size:12px;color:var(--text-muted);"><i class="far fa-clock"></i> Submitted <?php echo date('M d, Y \a\t h:i A', strtotime($q['created_at'])); ?></span>
          <a href="quote-confirmation.php?quote=<?php echo urlencode($q['quotation_number']); ?>">View Details <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  <?php endif; ?>
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
function toggleQuote(id){
  var body=document.getElementById('quoteBody-'+id);
  var btn=document.getElementById('expandBtn-'+id);
  var icon=btn.querySelector('i');
  if(body.classList.contains('open')){
    body.classList.remove('open');
    icon.className='fas fa-chevron-down';
  }else{
    body.classList.add('open');
    icon.className='fas fa-chevron-up';
  }
}
document.addEventListener('click',function(e){var dd=document.getElementById('userDropdown');if(dd&&!e.target.closest('.user-menu'))dd.classList.remove('show')});
</script>
<script>
document.addEventListener('DOMContentLoaded',function(){var items=document.querySelectorAll('.reveal');if(items.length){var obs=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.style.opacity='1';e.target.style.transform='translateY(0)';obs.unobserve(e.target)}})},{threshold:0.1});items.forEach(function(el){el.style.opacity='0';el.style.transform='translateY(24px)';el.style.transition='opacity .6s ease, transform .6s ease';obs.observe(el)})}});
</script>
</body>
</html>
