<?php
$currentUser = getCurrentUser();
$unreadFeedback = $stats['unread_feedback'] ?? 0;
?>
<!-- Sidebar -->
<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">PT</div>
        <div class="sidebar-brand">PTPetho <span>Admin</span></div>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <?= getInitials($currentUser['full_name']) ?>
        </div>
        <div class="user-info">
            <div class="user-name"><?= htmlspecialchars($currentUser['full_name']) ?></div>
            <div class="user-role"><?= strtoupper($currentUser['role']) ?></div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Main Menu</div>

        <ul>
            <li class="nav-item">
                <a href="/ptpetho-admin/dashboard.php" class="nav-link <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/ptpetho-admin/search.php" class="nav-link <?= ($currentPage ?? '') === 'search' ? 'active' : '' ?>">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Staff Directory</span>
                </a>
            </li>
        </ul>

        <div class="nav-section">Communication</div>

        <ul>
            <li class="nav-item">
                <a href="/ptpetho-admin/feedback.php" class="nav-link <?= ($currentPage ?? '') === 'feedback' ? 'active' : '' ?>">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <span>Send Feedback</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/ptpetho-admin/feedback-inbox.php" class="nav-link <?= ($currentPage ?? '') === 'feedback-inbox' ? 'active' : '' ?>">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <span>Feedback Inbox</span>
                    <?php if ($unreadFeedback > 0): ?>
                        <span class="nav-badge"><?= $unreadFeedback ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>

        <?php if (hasRole(['superadmin', 'ceo'])): ?>
        <div class="nav-section">Management</div>

        <ul>
            <li class="nav-item">
                <a href="/ptpetho-admin/reports.php" class="nav-link <?= ($currentPage ?? '') === 'reports' ? 'active' : '' ?>">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Reports</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>

        <?php if (isCEO()): ?>
        <div class="nav-section">Executive</div>

        <ul>
            <li class="nav-item">
                <a href="/ptpetho-admin/fuel-cost.php" class="nav-link <?= ($currentPage ?? '') === 'fuel-cost' ? 'active' : '' ?>">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Fuel Cost Analysis</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>

        <div class="nav-section">Account</div>

        <ul>
            <li class="nav-item">
                <a href="/ptpetho-admin/profile.php" class="nav-link <?= ($currentPage ?? '') === 'profile' ? 'active' : '' ?>">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>My Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/ptpetho-admin/logout.php" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
