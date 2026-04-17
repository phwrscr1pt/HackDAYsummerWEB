<?php
/**
 * PTPetho Admin - Fuel Cost Analysis (CEO ONLY)
 * Challenge 10: Session hijacking to access this page
 * Contains the final flag and secret fuel cost data
 */

$pageTitle = 'Fuel Cost Analysis';
$currentPage = 'fuel-cost';

require_once __DIR__ . '/../includes/functions.php';
requireLogin();

// CEO ONLY - Check access
if (!isCEO()) {
    header('HTTP/1.1 403 Forbidden');
    ?>
    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Access Denied | PTPetho Admin</title>
        <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/admin.css">
    </head>
    <body>
        <div class="forbidden-page">
            <div class="forbidden-content">
                <div class="forbidden-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1>403</h1>
                <h2>CEO Access Required</h2>
                <p>This page contains confidential information and is restricted to CEO level access only.</p>

                <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 1.5rem; margin: 2rem 0; text-align: left;">
                    <strong style="color: #721c24;">Your Access Level:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem; color: #721c24;">
                        <li>Current User: <code><?= htmlspecialchars($_SESSION['username'] ?? 'unknown') ?></code></li>
                        <li>Role: <code><?= htmlspecialchars($_SESSION['role'] ?? 'unknown') ?></code></li>
                        <li>Required Role: <code>ceo</code></li>
                    </ul>
                </div>

                <a href="/ptpetho-admin/dashboard.php" class="btn btn-primary">Back to Dashboard</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Get fuel cost data
$fuelData = getFuelCostAnalysis();
$latestData = $fuelData[0] ?? null;

require_once __DIR__ . '/../includes/admin-header.php';
?>

<!-- Confidential Banner -->
<div class="confidential-banner">
    <span class="icon">🔒</span>
    PETRATHAI CONFIDENTIAL - CEO ACCESS ONLY - DO NOT DISTRIBUTE
</div>

<!-- Page Header -->
<div class="content-header" style="margin-top: 1.5rem;">
    <div>
        <h1>Fuel Cost Analysis</h1>
        <p class="text-muted">ข้อมูลต้นทุนและกำไรที่แท้จริง - เอกสารลับสูงสุด</p>
    </div>
    <span class="badge badge-danger" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
        🔴 TOP SECRET
    </span>
</div>

<!-- FLAG 5 -->
<div class="alert alert-success" style="margin-bottom: 1.5rem; text-align: center; padding: 1.5rem;">
    <h3 style="margin: 0 0 0.5rem;">🚩 FLAG 5: FLAG{s3ss10n_h1j4ck_truth_r3v34l3d}</h3>
    <p style="margin: 0;">Congratulations! You successfully hijacked the CEO session and accessed classified data!</p>
</div>

<!-- Secret Data Reveal -->
<?php if ($latestData): ?>
<div class="secret-data">
    <h3>📊 ACTUAL REFINERY MARGIN DATA - Q1/2569</h3>
    <p>ข้อมูลที่แท้จริงที่ซ่อนจากสาธารณะ</p>

    <div class="data-comparison">
        <div class="data-box public">
            <h4>Public Statement</h4>
            <p>สิ่งที่บอกประชาชน</p>
            <div class="value"><?= number_format($latestData['public_margin'], 2) ?></div>
            <p>บาท/ลิตร</p>
        </div>

        <div class="data-box actual">
            <h4>Actual Cost</h4>
            <p>ต้นทุนจริง</p>
            <div class="value"><?= number_format($latestData['actual_margin'], 2) ?></div>
            <p>บาท/ลิตร</p>
        </div>
    </div>

    <div class="profit-highlight">
        <h4>💰 Hidden Profit / กำไรที่ซ่อนไว้</h4>
        <div class="value"><?= number_format($latestData['hidden_profit'], 2) ?> บาท/ลิตร</div>
        <p style="margin-top: 0.5rem; font-size: 1rem;">
            Total Hidden Profit: <strong>฿<?= number_format($latestData['total_hidden_profit'], 0) ?></strong>
        </p>
    </div>

    <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(139, 0, 0, 0.1); border-radius: 8px;">
        <p style="margin: 0; font-size: 0.9375rem;">
            <strong>Approved by:</strong> <?= htmlspecialchars($latestData['approved_by']) ?><br>
            <strong>Date:</strong> <?= formatThaiDate($latestData['approval_date']) ?><br>
            <strong>Notes:</strong> <?= htmlspecialchars($latestData['notes']) ?>
        </p>
    </div>
</div>
<?php endif; ?>

<!-- Full Data Table -->
<div class="panel" style="margin-top: 1.5rem;">
    <div class="panel-header">
        <h3 class="panel-title">Historical Data / ข้อมูลย้อนหลัง</h3>
    </div>
    <div class="panel-body">
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Quarter</th>
                        <th>Fuel Type</th>
                        <th>Public Margin</th>
                        <th>Actual Margin</th>
                        <th>Hidden Profit</th>
                        <th>Total Volume</th>
                        <th>Total Hidden Profit</th>
                        <th>Classification</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fuelData as $row): ?>
                    <tr>
                        <td><strong><?= $row['quarter'] ?>/<?= $row['year'] ?></strong></td>
                        <td><?= htmlspecialchars($row['fuel_type']) ?></td>
                        <td style="color: var(--success);">฿<?= number_format($row['public_margin'], 2) ?></td>
                        <td style="color: var(--danger);">฿<?= number_format($row['actual_margin'], 2) ?></td>
                        <td style="color: var(--accent-gold); font-weight: 600;">฿<?= number_format($row['hidden_profit'], 2) ?></td>
                        <td><?= number_format($row['total_volume_liters']) ?> L</td>
                        <td style="font-weight: 600;">฿<?= number_format($row['total_hidden_profit'], 0) ?></td>
                        <td>
                            <span class="badge badge-<?= $row['classification'] === 'top_secret' ? 'danger' : 'warning' ?>">
                                <?= strtoupper($row['classification']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Mission Complete Message -->
<div style="margin-top: 2rem; padding: 2rem; background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%); border-radius: 12px; text-align: center; color: white;">
    <h2 style="color: white; margin: 0 0 1rem;">🎯 MISSION COMPLETE!</h2>
    <p style="font-size: 1.125rem; margin: 0 0 1rem; opacity: 0.9;">
        คุณได้เปิดเผยความจริงเรื่องค่าการกลั่นน้ำมันสำเร็จแล้ว!
    </p>
    <p style="margin: 0; opacity: 0.8;">
        ค่าการกลั่นจริง: <strong>฿4.20/ลิตร</strong> (ไม่ใช่ ฿13.00 อย่างที่ประกาศ)<br>
        กำไรที่ซ่อนจากประชาชน: <strong>฿8.80/ลิตร</strong>
    </p>
</div>

<?php require_once __DIR__ . '/../includes/admin-footer.php'; ?>
