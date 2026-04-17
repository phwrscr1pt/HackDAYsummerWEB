<?php
/**
 * PTPetho Admin - Login Page
 * Challenge 4: Header spoofing required to access
 * Challenge 7: SQLi filter bypass on login
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// If already logged in, redirect to dashboard
if (isLoggedIn()) {
    header('Location: /ptpetho-admin/dashboard.php');
    exit;
}

// Check access policy (Challenge 4)
$isInternal = isInternalRequest();
$hasValidReferer = hasValidSSOReferer();
$accessAllowed = $isInternal && $hasValidReferer;

// Get client IP for display
$clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';

// Handle login attempt
$error = '';
$showLoginForm = $accessAllowed;

if ($accessAllowed && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน';
    } else {
        $result = authenticateUser($username, $password);

        if ($result['success']) {
            // Login successful - redirect to dashboard
            header('Location: /ptpetho-admin/dashboard.php');
            exit;
        } else {
            if ($result['error'] === 'blocked') {
                $error = $result['message'];
            } else {
                $error = 'Invalid credentials';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | PTPetho</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php if (!$accessAllowed): ?>
    <!-- 403 Forbidden Page (Challenge 4) -->
    <div class="forbidden-page">
        <div class="forbidden-content">
            <div class="forbidden-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1>403</h1>
            <h2>Access Forbidden</h2>
            <p>This page is restricted to internal network only.</p>

            <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 1.5rem; margin: 2rem 0; text-align: left;">
                <strong style="color: #721c24;">Access Denied Details:</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem; color: #721c24;">
                    <li>Detected IP: <code><?= htmlspecialchars($clientIP) ?></code> (<?= $isInternal ? 'Internal' : 'External' ?>)</li>
                    <li>Internal Network: <?= $isInternal ? '✅ Yes' : '❌ No' ?></li>
                    <li>Valid SSO Referer: <?= $hasValidReferer ? '✅ Yes' : '❌ No' ?></li>
                </ul>
            </div>

            <p style="color: var(--medium-gray); font-size: 0.875rem;">
                If you believe this is an error, please contact IT support.<br>
                Reference: ERR_ACCESS_DENIED_<?= time() ?>
            </p>

            <a href="/" class="btn btn-primary" style="margin-top: 1rem;">กลับหน้าแรก</a>
        </div>
    </div>

    <?php else: ?>
    <!-- Login Form (Challenge 7) -->
    <div class="login-page">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-logo">PT</div>
                    <h1>PTPetho Admin</h1>
                    <p>Internal Staff Portal</p>
                </div>

                <div class="login-body">
                    <?php if ($error): ?>
                    <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                        <pre style="margin: 0; white-space: pre-wrap; font-family: monospace; font-size: 0.8125rem;"><?= htmlspecialchars($error) ?></pre>
                    </div>
                    <?php endif; ?>

                    <form method="POST" class="login-form">
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                placeholder="Enter username"
                                value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                                required
                                autofocus
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Enter password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            เข้าสู่ระบบ
                        </button>
                    </form>
                </div>

                <div class="login-footer">
                    <p>Powered by PTPetho SecureLogin v1.2 (MySQL)</p>
                    <p style="margin-top: 0.5rem;">
                        <a href="/" style="color: var(--primary-green);">กลับหน้าแรก</a>
                    </p>
                </div>
            </div>

            <!-- FLAG 1 appears here when access is granted -->
            <?php if ($isInternal && $hasValidReferer): ?>
            <div style="margin-top: 1.5rem; background: rgba(40, 167, 69, 0.1); border: 1px solid var(--success); border-radius: 8px; padding: 1rem; text-align: center;">
                <strong style="color: var(--success);">🚩 FLAG 1: SMC{h34d3r_trust_1ssu3}</strong>
                <p style="margin: 0.5rem 0 0; font-size: 0.875rem; color: var(--medium-gray);">
                    Access granted! You bypassed the header checks.
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
