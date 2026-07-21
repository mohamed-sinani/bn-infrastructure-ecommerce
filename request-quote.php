<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/functions.php';
require_once __DIR__ . '/src/cart.php';

$brandName = 'BN-Infrastructure';
$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyName = trim($_POST['company_name'] ?? '');
    $contactName = trim($_POST['contact_name'] ?? '');
    $contactEmail = trim($_POST['contact_email'] ?? '');
    $contactPhone = trim($_POST['contact_phone'] ?? '');
    $productNeeds = trim($_POST['product_needs'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    if (!$companyName) $errors[] = 'Company name is required.';
    if (!$contactName) $errors[] = 'Contact name is required.';
    if (!$contactEmail || !filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
    if (!$contactPhone) $errors[] = 'Phone number is required.';
    if (!$productNeeds) $errors[] = 'Please describe what products you need.';

    if (empty($errors)) {
        $fullNotes = "Products/Services Required: " . $productNeeds;
        if ($quantity) $fullNotes .= "\nEstimated Quantity: " . $quantity;
        if ($notes) $fullNotes .= "\nAdditional Notes: " . $notes;

        $lpoFile = null;
        if (!empty($_FILES['lpo_file']['name'])) {
            $ext = strtolower(pathinfo($_FILES['lpo_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                if ($_FILES['lpo_file']['size'] <= 10 * 1024 * 1024) {
                    $lpoFile = uniqid('lpo_') . '.' . $ext;
                    move_uploaded_file($_FILES['lpo_file']['tmp_name'], __DIR__ . '/uploads/' . $lpoFile);
                } else {
                    $errors[] = 'LPO file must be under 10MB.';
                }
            } else {
                $errors[] = 'LPO file must be PDF, DOC, DOCX, XLS, or XLSX.';
            }
        }

        if (empty($errors)) {
            $uid = $_SESSION['user_id'] ?? null;
            $qnum = 'QT-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

            execute(
                "INSERT INTO quotations (quotation_number, user_id, company_name, contact_name, contact_email, contact_phone, notes, lpo_file, subtotal, discount, vat, total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, 0, 0, 0, 'pending')",
                [$qnum, $uid, $companyName, $contactName, $contactEmail, $contactPhone, $fullNotes, $lpoFile]
            );

            $success = $qnum;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Request a Quote — <?php echo $brandName; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--navy:#0A2540;--navy-light:#133057;--navy-dark:#071a2e;--orange:#F05A22;--orange-dark:#d44d1a;--bg:#F4F6F9;--card:#FFF;--text-primary:#0A2540;--text-secondary:#5a6a7e;--text-muted:#8fa0b3;--border:#e2e8f0;--shadow-sm:0 1px 3px rgba(10,37,64,0.08),0 1px 2px rgba(10,37,64,0.04);--shadow-md:0 4px 12px rgba(10,37,64,0.1),0 2px 6px rgba(10,37,64,0.06)}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text-primary);font-size:15px;line-height:1.6}
.announcement-bar{background:var(--orange);color:#fff;text-align:center;padding:9px 24px;font-size:13px;font-weight:500;letter-spacing:.01em}
.announcement-bar i{margin-right:6px;opacity:.9}.announcement-bar span{margin:0 18px;opacity:.7}
.navbar{background:var(--navy);padding:0 48px;display:flex;align-items:center;height:70px;position:sticky;top:0;z-index:1000;box-shadow:0 2px 12px rgba(0,0,0,0.2)}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none;margin-right:40px;flex-shrink:0}
.nav-logo-icon{width:38px;height:38px;background:var(--orange);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff}
.nav-logo-text{display:flex;flex-direction:column;line-height:1.1}
.nav-logo-text .brand{font-size:18px;font-weight:800;color:#fff;letter-spacing:-.02em}
.nav-logo-text .tagline{font-size:10px;font-weight:400;color:rgba(255,255,255,0.5);letter-spacing:.08em;text-transform:uppercase}
.nav-links{display:flex;align-items:center;gap:4px;flex:1}
.nav-links a{text-decoration:none;color:rgba(255,255,255,0.75);font-size:14px;font-weight:500;padding:8px 14px;border-radius:6px;transition:color .2s,background .2s;white-space:nowrap}
.nav-links a:hover{color:#fff;background:rgba(255,255,255,0.08)}
.nav-links a.active{color:#fff;background:rgba(255,255,255,0.1)}
.nav-actions{display:flex;align-items:center;gap:12px;flex-shrink:0}
.user-menu{position:relative;display:inline-block}
.user-name{display:inline-flex;align-items:center;gap:6px;color:#fff;font-size:13px;font-weight:500;cursor:pointer;padding:6px 12px;border-radius:7px;transition:background .2s;white-space:nowrap}
.user-name:hover{background:rgba(255,255,255,0.08)}
.user-dropdown{display:none;position:absolute;top:100%;right:0;background:#fff;border:1px solid #e2e8f0;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.15);min-width:180px;z-index:100;overflow:hidden;margin-top:6px}
.user-dropdown.show{display:block}
.user-dropdown a{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#0A2540;font-size:13px;text-decoration:none;transition:background .15s}
.user-dropdown a:hover{background:#F4F6F9}
.user-dropdown a i{width:16px;color:#F05A22;font-size:12px}
.cart-btn{background:var(--orange);border:none;color:#fff;width:40px;height:40px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:background .2s;font-size:15px;text-decoration:none}
.cart-btn:hover{background:var(--orange-dark)}
.cart-badge{position:absolute;top:-5px;right:-5px;background:#fff;color:var(--orange);font-size:10px;font-weight:700;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--orange)}
.btn-signin{background:transparent;border:1.5px solid rgba(255,255,255,0.3);color:rgba(255,255,255,0.85);padding:7px 16px;border-radius:7px;font-family:'Inter',sans-serif;font-size:13px;font-weight:500;cursor:pointer;transition:all .2s;white-space:nowrap;text-decoration:none}
.btn-signin:hover{background:rgba(255,255,255,0.1);border-color:rgba(255,255,255,0.5);color:#fff}
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
.page-hero{background:var(--navy);padding:60px 48px;text-align:center;position:relative;overflow:hidden}
.page-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 50% 100%,rgba(240,90,34,0.1) 0%,transparent 60%)}
.page-hero h1{font-size:clamp(28px,3vw,44px);font-weight:800;color:#fff;letter-spacing:-.03em;position:relative;z-index:1}
.page-hero p{font-size:17px;color:rgba(255,255,255,0.65);max-width:600px;margin:12px auto 0;position:relative;z-index:1}
.page-hero h1 i{color:var(--orange);margin-right:10px}
.container{max-width:780px;margin:0 auto;padding:40px 24px 64px}
.success-box{background:#fff;border:1px solid rgba(5,150,105,0.25);border-left:4px solid #059669;border-radius:0 12px 12px 0;padding:32px;margin-bottom:32px;box-shadow:var(--shadow-sm)}
.success-box i{font-size:40px;color:#059669;margin-bottom:16px;display:block}
.success-box h2{font-size:22px;font-weight:800;color:var(--navy);margin-bottom:8px}
.success-box p{font-size:14px;color:var(--text-secondary);line-height:1.7;margin-bottom:6px}
.success-box .quote-num{display:inline-block;background:rgba(10,37,64,0.06);border:1px solid var(--border);padding:4px 14px;border-radius:8px;font-weight:700;color:var(--navy);font-size:15px;margin:8px 0 16px}
.success-box .btn{margin-top:12px}
.form-card{background:var(--card);border:1px solid var(--border);border-radius:16px;box-shadow:var(--shadow-md);overflow:hidden}
.form-header{background:linear-gradient(135deg,var(--navy),var(--navy-light));padding:32px 36px;color:#fff}
.form-header h2{font-size:22px;font-weight:800;margin-bottom:6px}
.form-header p{font-size:14px;color:rgba(255,255,255,0.6);line-height:1.6}
.form-body{padding:36px}
.form-group{margin-bottom:20px}
.form-label{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:var(--navy);margin-bottom:6px}
.form-label i{color:var(--orange);font-size:12px}
.form-label .req{color:var(--orange)}
.form-input,.form-textarea,.form-select{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:9px;font-family:'Inter',sans-serif;font-size:14px;color:var(--text-primary);background:#fff;transition:border-color .2s,box-shadow .2s}
.form-input:focus,.form-textarea:focus,.form-select:focus{outline:none;border-color:var(--orange);box-shadow:0 0 0 3px rgba(240,90,34,0.1)}
.form-textarea{min-height:120px;resize:vertical;line-height:1.6}
.form-hint{font-size:12px;color:var(--text-muted);margin-top:4px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.quick-tags{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px}
.quick-tag{background:rgba(10,37,64,0.04);border:1px solid var(--border);padding:5px 12px;border-radius:20px;font-size:12px;color:var(--text-secondary);cursor:pointer;transition:all .2s;user-select:none}
.quick-tag:hover{border-color:var(--orange);color:var(--orange);background:rgba(240,90,34,0.05)}
.error-list{background:rgba(220,38,38,0.05);border:1px solid rgba(220,38,38,0.2);border-left:4px solid #dc2626;border-radius:0 10px 10px 0;padding:16px 20px;margin-bottom:24px}
.error-list p{font-size:13px;color:#dc2626;font-weight:600;margin-bottom:4px}
.error-list ul{margin:0;padding-left:18px;list-style:disc}
.error-list li{font-size:13px;color:#991b1b;margin-bottom:2px}
.lpo-upload-zone{border:2px dashed var(--border);border-radius:12px;padding:32px 24px;text-align:center;cursor:pointer;transition:all .2s;position:relative}
.lpo-upload-zone:hover{border-color:var(--orange);background:rgba(240,90,34,0.02)}
.lpo-upload-zone input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer}
.lpo-upload-icon{font-size:32px;color:var(--text-muted);margin-bottom:10px}
.lpo-upload-text{font-size:14px;color:var(--text-secondary)}
.lpo-upload-text span{color:var(--orange);font-weight:600}
.lpo-upload-hint{font-size:12px;color:var(--text-muted);margin-top:4px}
.lpo-file-info{display:none;align-items:center;gap:10px;padding:10px 14px;background:rgba(5,150,105,0.05);border:1px solid rgba(5,150,105,0.2);border-radius:8px;margin-top:10px}
.lpo-file-info.show{display:flex}
.lpo-file-info i{color:#059669;font-size:16px}
.lpo-file-info span{flex:1;font-size:13px;font-weight:500;color:var(--navy)}
.lpo-file-remove{background:none;border:none;color:#dc2626;cursor:pointer;font-size:14px;padding:4px}
.btn-submit{display:inline-flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px 24px;background:var(--orange);color:#fff;border:none;border-radius:10px;font-family:'Inter',sans-serif;font-size:15px;font-weight:700;cursor:pointer;transition:all .2s;margin-top:8px}
.btn-submit:hover{background:var(--orange-dark);transform:translateY(-1px);box-shadow:0 4px 16px rgba(240,90,34,0.35)}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 20px;border-radius:9px;font-family:'Inter',sans-serif;font-size:14px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:all .2s}
.btn-primary{background:var(--orange);color:#fff}
.btn-primary:hover{background:var(--orange-dark);transform:translateY(-1px);box-shadow:0 4px 12px rgba(240,90,34,0.3)}
.btn-outline{background:transparent;color:var(--navy);border:2px solid var(--border);padding:10px 18px}
.btn-outline:hover{border-color:var(--navy);background:var(--navy);color:#fff}
.contact-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:32px}
.contact-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:24px;text-align:center;box-shadow:var(--shadow-sm)}
.contact-card i{font-size:24px;color:var(--orange);margin-bottom:10px}
.contact-card h4{font-size:14px;font-weight:700;color:var(--navy);margin-bottom:4px}
.contact-card p{font-size:13px;color:var(--text-secondary)}
.contact-card a{color:var(--orange);text-decoration:none;font-weight:600}
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
@media(max-width:900px){.footer-grid{grid-template-columns:1fr 1fr}.contact-strip{grid-template-columns:1fr}}
@media(max-width:768px){.navbar{padding:0 16px;height:56px}.nav-links{display:none}.hamburger{display:block;margin-left:auto}.search-bar{display:none}.page-hero{padding:32px 16px}.page-hero h1{font-size:22px}.container{padding:20px 16px 40px}.form-header,.form-body{padding:20px 16px}.form-row{grid-template-columns:1fr}.contact-strip{gap:12px}.footer-grid{grid-template-columns:1fr;gap:24px}footer{padding:40px 16px 0}.footer-bottom{flex-direction:column;gap:10px;text-align:center}}
@media(max-width:480px){.page-hero h1{font-size:20px}.form-body{padding:16px 12px}.contact-card{padding:14px}}
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
    <a href="request-quote.php" class="active">Request Quote</a>
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
  <a href="request-quote.php" onclick="toggleMenu()" style="color:var(--orange);">Request Quote</a>
  <a href="track.php" onclick="toggleMenu()">Track Order</a>
  <?php echo mobileAccountHtml(); ?>
  <a href="cart.php" onclick="toggleMenu()">Cart</a>
</div>

<section class="page-hero">
  <h1><i class="fas fa-file-invoice"></i> Request a Quote</h1>
  <p>Tell us what you need and we'll get back to you with pricing within 2-4 business hours.</p>
</section>

<div class="container">

  <?php if ($success): ?>
  <div class="success-box reveal">
    <i class="fas fa-check-circle"></i>
    <h2>Quote Request Submitted!</h2>
    <p>Your quote request has been received. Our team will review your requirements and respond with pricing.</p>
    <div class="quote-num"><?php echo htmlspecialchars($success); ?></div>
    <p>Estimated response time: <strong>2-4 business hours</strong>.</p>
    <a href="index.php" class="btn btn-primary"><i class="fas fa-home"></i> Back to Home</a>
    <a href="catalog.php" class="btn btn-outline" style="margin-left:8px;"><i class="fas fa-shopping-bag"></i> Browse Products</a>
  </div>
  <?php else: ?>

  <?php if (!empty($errors)): ?>
  <div class="error-list reveal">
    <p><i class="fas fa-exclamation-triangle"></i> Please fix the following:</p>
    <ul>
      <?php foreach ($errors as $err): ?>
      <li><?php echo htmlspecialchars($err); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>

  <div class="form-card reveal">
    <div class="form-header">
      <h2><i class="fas fa-clipboard-list"></i> Tell Us What You Need</h2>
      <p>Fill in your details and describe the networking equipment or services you require. We handle everything from enterprise routers to structured cabling projects.</p>
    </div>
    <div class="form-body">
      <form method="POST" enctype="multipart/form-data" id="quoteForm">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label"><i class="fas fa-building"></i> Company Name <span class="req">*</span></label>
            <input type="text" name="company_name" class="form-input" placeholder="e.g. Acme Communications Ltd" value="<?php echo htmlspecialchars($_POST['company_name'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label"><i class="fas fa-user"></i> Contact Name <span class="req">*</span></label>
            <input type="text" name="contact_name" class="form-input" placeholder="e.g. John Mwangi" value="<?php echo htmlspecialchars($_POST['contact_name'] ?? (isLoggedIn() ? currentUserName() : '')); ?>" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label"><i class="fas fa-envelope"></i> Email <span class="req">*</span></label>
            <input type="email" name="contact_email" class="form-input" placeholder="procurement@company.co.tz" value="<?php echo htmlspecialchars($_POST['contact_email'] ?? currentUserEmail()); ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label"><i class="fas fa-phone"></i> Phone <span class="req">*</span></label>
            <input type="tel" name="contact_phone" class="form-input" placeholder="+255 712 345 678" value="<?php echo htmlspecialchars($_POST['contact_phone'] ?? ''); ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label"><i class="fas fa-box-open"></i> Products / Services Required <span class="req">*</span></label>
          <div class="form-hint">Describe the equipment, brands, or solutions you need</div>
          <div class="quick-tags">
            <span class="quick-tag" onclick="addQuickTag(this,'Enterprise Router (MikroTik/Cisco)')">Enterprise Router</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Managed Network Switch')">Network Switch</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Wireless Access Points (WiFi 6/6E)')">WiFi Access Points</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Structured Cabling (CAT6A/CAT7)')">Structured Cabling</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Firewall / UTM Appliance')">Firewall / UTM</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Full Network Stack (Router + Switch + AP + Cabling)')">Full Network Stack</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Network Installation & Configuration')">Installation Service</span>
          </div>
          <textarea name="product_needs" class="form-textarea" id="productNeeds" placeholder="e.g. We need 5x Ubiquiti UniFi U6 Pro access points, 1x MikroTik CCR2004 router, and a structured cabling kit for our new office in Mikocheni."><?php echo htmlspecialchars($_POST['product_needs'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
          <label class="form-label"><i class="fas fa-hashtag"></i> Estimated Quantity</label>
          <input type="text" name="quantity" class="form-input" placeholder="e.g. 10 units, 500m cable, 1 full office setup" value="<?php echo htmlspecialchars($_POST['quantity'] ?? ''); ?>">
        </div>
        <div class="form-group">
          <label class="form-label"><i class="fas fa-comment-alt"></i> Additional Notes</label>
          <div class="form-hint">Delivery location, installation needs, bulk requirements, payment terms, etc.</div>
          <div class="quick-tags">
            <span class="quick-tag" onclick="addQuickTag(this,'Bulk order discount required')">Bulk discount</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Installation service needed')">Installation</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Credit terms 30 days')">Credit 30 days</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Urgent delivery required')">Urgent</span>
            <span class="quick-tag" onclick="addQuickTag(this,'Delivery to upcountry')">Upcountry delivery</span>
          </div>
          <textarea name="notes" class="form-textarea" id="quoteNotes" style="min-height:90px;" placeholder="e.g. Please confirm delivery to Mwanza. We require installation services for the access points."><?php echo htmlspecialchars($_POST['notes'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
          <label class="form-label"><i class="fas fa-file-upload"></i> Attach LPO / Tender Document</label>
          <div class="form-hint">Upload your Local Purchase Order, tender document, or project specs (PDF, DOC, XLS — max 10MB)</div>
          <div class="lpo-upload-zone" id="uploadZone">
            <input type="file" name="lpo_file" accept=".pdf,.doc,.docx,.xls,.xlsx" onchange="handleFileUpload(this)">
            <div class="lpo-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
            <div class="lpo-upload-text"><span>Click to upload</span> or drag and drop</div>
            <div class="lpo-upload-hint">PDF, DOC, DOCX, XLS, XLSX — max 10MB</div>
          </div>
          <div class="lpo-file-info" id="lpoFileInfo">
            <i class="fas fa-file-check"></i>
            <span id="lpoFileName">—</span>
            <button type="button" class="lpo-file-remove" onclick="removeFile()"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Submit Quote Request</button>
      </form>
    </div>
  </div>

  <div class="contact-strip reveal">
    <div class="contact-card">
      <i class="fas fa-phone-alt"></i>
      <h4>Call Us</h4>
      <p><a href="tel:+255763364721">+255 763 364 721</a></p>
    </div>
    <div class="contact-card">
      <i class="fas fa-envelope"></i>
      <h4>Email Us</h4>
      <p><a href="mailto:sales@bn-infrastructure.com">sales@bn-infrastructure.com</a></p>
    </div>
    <div class="contact-card">
      <i class="fas fa-map-marker-alt"></i>
      <h4>Visit Us</h4>
      <p>Plot 45, Mikocheni<br>Light Industrial Area, DSM</p>
    </div>
  </div>

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
          <li><a href="request-quote.php"><i class="fas fa-chevron-right"></i> Request a Quote</a></li>
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
function addQuickTag(el, text){
  var ta = el.closest('.form-group').querySelector('textarea');
  if(ta){
    var v = ta.value.trim();
    if(v && v.slice(-1)!=='\n') v+='\n';
    ta.value = v + text;
    ta.focus();
    el.style.borderColor='var(--orange)';el.style.color='var(--orange)';el.style.background='rgba(240,90,34,0.08)';
  }
}
function handleFileUpload(input){
  if(input.files && input.files[0]){
    var f=input.files[0];
    document.getElementById('lpoFileName').textContent=f.name+' ('+(f.size/1024/1024).toFixed(1)+'MB)';
    document.getElementById('lpoFileInfo').classList.add('show');
  }
}
function removeFile(){
  var z=document.querySelector('.lpo-upload-zone input[type="file"]');
  if(z)z.value='';
  document.getElementById('lpoFileInfo').classList.remove('show');
}
document.addEventListener('click',function(e){var dd=document.getElementById('userDropdown');if(dd&&!e.target.closest('.user-menu'))dd.classList.remove('show')});
</script>
<script>
document.addEventListener('DOMContentLoaded',function(){var items=document.querySelectorAll('.reveal');if(items.length){var obs=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.style.opacity='1';e.target.style.transform='translateY(0)';obs.unobserve(e.target)}})},{threshold:0.1});items.forEach(function(el){el.style.opacity='0';el.style.transform='translateY(24px)';el.style.transition='opacity .6s ease, transform .6s ease';obs.observe(el)})}});
</script>
</body>
</html>