<?php
/**
 * PTPetho Admin - Logout
 */

session_start();
session_destroy();

header('Location: /ptpetho-admin/');
exit;
