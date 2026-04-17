<?php
require_once __DIR__ . '/functions.php';
requireLogin();

$currentUser = getCurrentUser();
$stats = getDashboardStats();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dashboard' ?> | PTPetho Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/admin.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <?php include __DIR__ . '/admin-sidebar.php'; ?>

        <main class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <div class="header-breadcrumb">
                        <a href="/ptpetho-admin/dashboard.php">Admin</a>
                        <span>/</span>
                        <span><?= $pageTitle ?? 'Dashboard' ?></span>
                    </div>
                </div>

                <div class="header-right">
                    <div class="header-search">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="ค้นหา...">
                    </div>

                    <div class="header-notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <?php if ($stats['unread_feedback'] > 0): ?>
                            <span class="badge"><?= $stats['unread_feedback'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div style="display:flex;align-items:center;gap:0.75rem;padding-left:1rem;border-left:1px solid var(--light-gray);">
                        <div class="user-avatar" style="width:36px;height:36px;font-size:0.875rem;">
                            <?= getInitials($currentUser['full_name']) ?>
                        </div>
                        <div>
                            <div style="font-size:0.875rem;font-weight:500;"><?= htmlspecialchars($currentUser['full_name']) ?></div>
                            <div style="font-size:0.75rem;color:var(--accent-gold);text-transform:uppercase;"><?= $currentUser['role'] ?></div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="admin-content">
