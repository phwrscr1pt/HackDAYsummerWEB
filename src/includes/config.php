<?php
/**
 * PTPetho CTF - Configuration File
 * Database connection and global settings
 */

// Error reporting (enabled for educational purposes)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration (intentionally insecure for CTF)
ini_set('session.cookie_httponly', 0);  // Allow JavaScript access to cookies
ini_set('session.cookie_samesite', ''); // No SameSite restriction
session_start();

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_NAME', getenv('DB_NAME') ?: 'ptpetho_internal');
define('DB_USER', getenv('DB_USER') ?: 'ptpetho');
define('DB_PASS', getenv('DB_PASS') ?: 'ptpetho_secret');

// Application settings
define('APP_NAME', 'PTPetho');
define('APP_NAME_FULL', 'PTPetho Energy Corporation');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost');

// Paths
define('BASE_PATH', dirname(__DIR__));
define('ASSETS_URL', '/assets');

// Database connection
function getDB() {
    static $conn = null;

    if ($conn === null) {
        try {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if ($conn->connect_error) {
                // Show detailed error for educational purposes
                die("Database Connection Failed: " . $conn->connect_error);
            }

            $conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    return $conn;
}

// Test database connection on include
try {
    $db = getDB();
} catch (Exception $e) {
    // Silently fail on connection test
}

/**
 * Security Note for Instructors:
 * ==============================
 * This configuration is INTENTIONALLY INSECURE for educational purposes.
 *
 * Vulnerabilities included:
 * 1. session.cookie_httponly = 0 (allows XSS to steal cookies)
 * 2. Error messages displayed (information disclosure)
 * 3. No CSRF protection
 * 4. No prepared statements in some queries (SQLi)
 */
