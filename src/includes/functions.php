<?php
/**
 * PTPetho CTF - Helper Functions
 */

require_once __DIR__ . '/config.php';

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get current user data
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }

    $db = getDB();
    $userId = (int)$_SESSION['user_id'];
    $result = $db->query("SELECT * FROM users WHERE id = $userId");

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

/**
 * Check if current user has specific role
 */
function hasRole($role) {
    $user = getCurrentUser();
    if (!$user) return false;

    if (is_array($role)) {
        return in_array($user['role'], $role);
    }

    return $user['role'] === $role;
}

/**
 * Check if user is CEO
 */
function isCEO() {
    return hasRole('ceo');
}

/**
 * Check if user is admin or higher
 */
function isAdmin() {
    return hasRole(['admin', 'superadmin', 'ceo']);
}

/**
 * Require login - redirect if not authenticated
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /ptpetho-admin/');
        exit;
    }
}

/**
 * Require specific role
 */
function requireRole($role) {
    requireLogin();
    if (!hasRole($role)) {
        header('HTTP/1.1 403 Forbidden');
        include BASE_PATH . '/ptpetho-admin/403.php';
        exit;
    }
}

/**
 * Authenticate user (VULNERABLE - for SQLi demo)
 * Challenge 7: Filter bypass
 */
function authenticateUser($username, $password) {
    $db = getDB();

    // Input validation filter (intentionally incomplete)
    $blocked = ['UNION', 'SELECT', '--', '#', 'DROP', 'INSERT', 'UPDATE', 'DELETE'];
    $upperUsername = strtoupper($username);

    foreach ($blocked as $pattern) {
        if (strpos($upperUsername, $pattern) !== false) {
            return [
                'success' => false,
                'error' => 'blocked',
                'message' => "INPUT VALIDATION ERROR\n\nBlocked pattern detected in username field.\nPatterns monitored: " . implode(', ', $blocked) . "\n\nYour input has been logged for security review."
            ];
        }
    }

    // VULNERABLE: SQL Injection possible with /* comment bypass
    $passwordHash = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password_hash='$passwordHash'";

    // Log the query for debugging (educational)
    error_log("Auth Query: $query");

    $result = $db->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];

        // Update last login
        $db->query("UPDATE users SET last_login = NOW() WHERE id = " . $user['id']);

        // Log successful login
        logAudit('LOGIN_SUCCESS', $user['id'], $user['username']);

        return ['success' => true, 'user' => $user];
    }

    // Log failed attempt
    logAudit('LOGIN_FAILED', null, $username);

    return [
        'success' => false,
        'error' => 'invalid',
        'message' => 'Invalid credentials'
    ];
}

/**
 * Search staff (VULNERABLE - for SQLi demo)
 * Challenges 5 & 6: Error-based and Union-based SQLi
 */
function searchStaff($searchTerm) {
    $db = getDB();

    // VULNERABLE: No input sanitization - direct concatenation
    $query = "SELECT employee_id, name, email, department, position, status FROM ptpetho_staff WHERE name LIKE '%$searchTerm%' OR employee_id LIKE '%$searchTerm%' OR department LIKE '%$searchTerm%'";

    // Log query for educational purposes
    error_log("Search Query: $query");

    $result = $db->query($query);

    if ($result === false) {
        // Return error message (information disclosure)
        return [
            'success' => false,
            'error' => $db->error,
            'query' => $query
        ];
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return [
        'success' => true,
        'data' => $data,
        'count' => count($data)
    ];
}

/**
 * Submit feedback (VULNERABLE - for XSS demo)
 * Challenge 8 & 9: Stored XSS
 */
function submitFeedback($subject, $message) {
    $db = getDB();
    $user = getCurrentUser();

    // VULNERABLE: No XSS sanitization - stored XSS possible
    $senderId = $user ? $user['id'] : 0;
    $senderName = $user ? $db->real_escape_string($user['full_name']) : 'Anonymous';
    $senderRole = $user ? $db->real_escape_string($user['role']) : 'guest';

    // Only escape for SQL, not for XSS
    $subject = $db->real_escape_string($subject);
    $message = $db->real_escape_string($message);

    $query = "INSERT INTO admin_feedback (sender_id, sender_name, sender_role, subject, message, priority, created_at) VALUES ($senderId, '$senderName', '$senderRole', '$subject', '$message', 'medium', NOW())";

    if ($db->query($query)) {
        return ['success' => true, 'id' => $db->insert_id];
    }

    return ['success' => false, 'error' => $db->error];
}

/**
 * Get feedback messages
 */
function getFeedbackList($onlyUnread = false) {
    $db = getDB();

    $where = $onlyUnread ? "WHERE is_read = FALSE" : "";
    $query = "SELECT * FROM admin_feedback $where ORDER BY
        CASE priority
            WHEN 'urgent' THEN 1
            WHEN 'high' THEN 2
            WHEN 'medium' THEN 3
            ELSE 4
        END,
        created_at DESC";

    $result = $db->query($query);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}

/**
 * Get single feedback (VULNERABLE - outputs raw HTML)
 */
function getFeedback($id) {
    $db = getDB();
    $id = (int)$id;

    $result = $db->query("SELECT * FROM admin_feedback WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $feedback = $result->fetch_assoc();

        // Mark as read
        $db->query("UPDATE admin_feedback SET is_read = TRUE, read_at = NOW() WHERE id = $id");

        return $feedback;
    }

    return null;
}

/**
 * Get fuel cost analysis (CEO only)
 */
function getFuelCostAnalysis() {
    $db = getDB();

    $result = $db->query("SELECT * FROM fuel_cost_analysis ORDER BY year DESC, quarter DESC");
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}

/**
 * Log audit event
 */
function logAudit($action, $userId = null, $username = null, $details = null) {
    $db = getDB();

    $userId = $userId ? (int)$userId : 'NULL';
    $username = $username ? $db->real_escape_string($username) : '';
    $ip = $db->real_escape_string($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    $userAgent = $db->real_escape_string($_SERVER['HTTP_USER_AGENT'] ?? '');
    $uri = $db->real_escape_string($_SERVER['REQUEST_URI'] ?? '');
    $details = $details ? $db->real_escape_string($details) : '';

    $query = "INSERT INTO audit_log (action, user_id, username, ip_address, user_agent, request_uri, details) VALUES ('$action', $userId, '$username', '$ip', '$userAgent', '$uri', '$details')";

    $db->query($query);
}

/**
 * Check if request is from internal network
 * Challenge 4: Header spoofing
 */
function isInternalRequest() {
    // VULNERABLE: Trusts X-Forwarded-For header
    $forwardedFor = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
    $remoteAddr = $_SERVER['REMOTE_ADDR'] ?? '';

    // Check if internal IP
    $ip = $forwardedFor ?: $remoteAddr;
    $internalPrefixes = ['192.168.', '10.', '172.16.', '127.0.0.'];

    foreach ($internalPrefixes as $prefix) {
        if (strpos($ip, $prefix) === 0) {
            return true;
        }
    }

    return false;
}

/**
 * Check if request has valid SSO referrer
 * Challenge 4: Header spoofing
 */
function hasValidSSOReferer() {
    // VULNERABLE: Trusts Referer header
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    return strpos($referer, 'ptpetho-sso.local') !== false;
}

/**
 * Get dashboard stats
 */
function getDashboardStats() {
    $db = getDB();

    $stats = [];

    // Total staff
    $result = $db->query("SELECT COUNT(*) as count FROM ptpetho_staff WHERE status = 'active'");
    $stats['total_staff'] = $result->fetch_assoc()['count'];

    // Unread feedback
    $result = $db->query("SELECT COUNT(*) as count FROM admin_feedback WHERE is_read = FALSE");
    $stats['unread_feedback'] = $result->fetch_assoc()['count'];

    // Today's logins
    $result = $db->query("SELECT COUNT(*) as count FROM audit_log WHERE action = 'LOGIN_SUCCESS' AND DATE(created_at) = CURDATE()");
    $stats['today_logins'] = $result->fetch_assoc()['count'];

    // Total revenue (fake data)
    $stats['total_revenue'] = '฿125.8B';

    return $stats;
}

/**
 * Get initials from name
 */
function getInitials($name) {
    $words = explode(' ', $name);
    $initials = '';

    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= mb_substr($word, 0, 1);
        }
    }

    return mb_strtoupper(mb_substr($initials, 0, 2));
}

/**
 * Format Thai date
 */
function formatThaiDate($date) {
    $timestamp = strtotime($date);
    $thaiMonths = [
        1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
        5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
        9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
    ];

    $day = date('j', $timestamp);
    $month = $thaiMonths[(int)date('n', $timestamp)];
    $year = date('Y', $timestamp) + 543; // Convert to Buddhist Era

    return "$day $month $year";
}

/**
 * Format time ago
 */
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) return 'เมื่อสักครู่';
    if ($diff < 3600) return floor($diff / 60) . ' นาทีที่แล้ว';
    if ($diff < 86400) return floor($diff / 3600) . ' ชั่วโมงที่แล้ว';
    if ($diff < 604800) return floor($diff / 86400) . ' วันที่แล้ว';

    return formatThaiDate($datetime);
}
