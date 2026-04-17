<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'PTPetho Energy' ?> | PTPetho</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">

    <!-- stack: PHP 8.1 + MySQL 8.0 + Apache -->
    <!-- TODO: disable /secret-panel before go-live -->
    <!-- contact dev-ops@ptpetho.local for issues -->
    <!-- DEBUG: session cookie set without HttpOnly flag -->
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-brand">
                <div class="navbar-logo" style="width:40px;height:40px;background:var(--accent-gold);border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:700;color:#1a2e1a;">PT</div>
                <span class="navbar-title">PTPetho <span>Energy</span></span>
            </a>

            <ul class="navbar-nav">
                <li><a href="/" class="<?= ($currentPage ?? '') === 'home' ? 'active' : '' ?>">หน้าแรก</a></li>
                <li><a href="/about.php" class="<?= ($currentPage ?? '') === 'about' ? 'active' : '' ?>">เกี่ยวกับเรา</a></li>
                <li><a href="/services.php" class="<?= ($currentPage ?? '') === 'services' ? 'active' : '' ?>">บริการ</a></li>
                <li><a href="/news.php" class="<?= ($currentPage ?? '') === 'news' ? 'active' : '' ?>">ข่าวสาร</a></li>
                <li><a href="/contact.php" class="<?= ($currentPage ?? '') === 'contact' ? 'active' : '' ?>">ติดต่อเรา</a></li>
            </ul>

            <div class="navbar-actions">
                <div class="lang-switch">
                    <a href="?lang=th" class="active">TH</a>
                    <a href="?lang=en">EN</a>
                </div>
                <a href="/ptpetho-admin/" class="btn btn-primary btn-sm">Staff Portal</a>
            </div>
        </div>
    </nav>
