<?php
/**
 * PTPetho Admin - Dashboard
 * Main admin dashboard with stats and charts
 */

$pageTitle = 'Dashboard';
$currentPage = 'dashboard';

require_once __DIR__ . '/../includes/admin-header.php';

// Get dashboard data
$stats = getDashboardStats();
$recentFeedback = getFeedbackList();
$recentFeedback = array_slice($recentFeedback, 0, 5);
?>

<!-- FLAG 3 Display - SQLi Filter Bypass -->
<?php if (!empty($_SESSION['sqli_bypass'])): ?>
<div class="alert alert-success" style="margin-bottom: 1.5rem;">
    <strong>🚩 FLAG 3: SMC{f1lt3r_byp4ss_succ3ss}</strong>
    <p style="margin: 0.5rem 0 0;">Congratulations! You bypassed the login filter using SQL injection.</p>
</div>
<?php unset($_SESSION['sqli_bypass']); ?>
<?php endif; ?>

<!-- Page Header -->
<div class="content-header">
    <h1>Dashboard</h1>
    <div>
        <span class="text-muted">วันที่: <?= formatThaiDate(date('Y-m-d')) ?></span>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div class="stat-info">
            <h3><?= number_format($stats['total_staff']) ?></h3>
            <p>พนักงานทั้งหมด</p>
            <span class="stat-change positive">↑ 12% จากเดือนก่อน</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon gold">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="stat-info">
            <h3><?= $stats['total_revenue'] ?></h3>
            <p>รายได้รวม Q1/2569</p>
            <span class="stat-change positive">↑ 15% YoY</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
        </div>
        <div class="stat-info">
            <h3><?= number_format($stats['today_logins']) ?></h3>
            <p>เข้าสู่ระบบวันนี้</p>
            <span class="stat-change">ปกติ</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon red">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </div>
        <div class="stat-info">
            <h3><?= number_format($stats['unread_feedback']) ?></h3>
            <p>Feedback รอดู</p>
            <?php if ($stats['unread_feedback'] > 0): ?>
            <span class="stat-change negative">ต้องดำเนินการ</span>
            <?php else: ?>
            <span class="stat-change positive">ดูครบแล้ว</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="dashboard-grid">
    <!-- Revenue Chart -->
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">รายได้รายไตรมาส (พันล้านบาท)</h3>
            <select class="form-control" style="width: auto; padding: 0.375rem 0.75rem; font-size: 0.875rem;">
                <option>ปี 2569</option>
                <option>ปี 2568</option>
                <option>ปี 2567</option>
            </select>
        </div>
        <div class="panel-body">
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">Feedback ล่าสุด</h3>
            <a href="/ptpetho-admin/feedback-inbox.php" class="btn btn-sm btn-outline">ดูทั้งหมด</a>
        </div>
        <div class="panel-body" style="padding: 0;">
            <ul class="activity-feed" style="padding: 0 1.5rem;">
                <?php if (empty($recentFeedback)): ?>
                <li class="activity-item">
                    <p class="text-muted text-center" style="padding: 2rem 0;">ไม่มี feedback</p>
                </li>
                <?php else: ?>
                <?php foreach ($recentFeedback as $feedback): ?>
                <li class="activity-item">
                    <div class="activity-icon" style="background: <?= $feedback['is_read'] ? 'var(--light-gray)' : 'rgba(220, 53, 69, 0.1)' ?>;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="<?= $feedback['is_read'] ? 'var(--medium-gray)' : 'var(--danger)' ?>">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text">
                            <strong><?= htmlspecialchars($feedback['sender_name']) ?></strong>
                            <br>
                            <a href="/ptpetho-admin/feedback-view.php?id=<?= $feedback['id'] ?>">
                                <?= htmlspecialchars(mb_substr($feedback['subject'], 0, 40)) ?>...
                            </a>
                        </p>
                        <span class="activity-time"><?= timeAgo($feedback['created_at']) ?></span>
                    </div>
                    <span class="badge priority-<?= $feedback['priority'] ?>"><?= $feedback['priority'] ?></span>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<!-- Second Row -->
<div class="dashboard-grid" style="margin-top: 1.5rem;">
    <!-- Fuel Types Chart -->
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">ยอดขายตามประเภทน้ำมัน</h3>
        </div>
        <div class="panel-body">
            <div class="chart-container" style="height: 250px;">
                <canvas id="fuelTypeChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">การดำเนินการด่วน</h3>
        </div>
        <div class="panel-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <a href="/ptpetho-admin/search.php" class="btn btn-outline" style="padding: 1.25rem; flex-direction: column; height: auto;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 0.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    ค้นหาพนักงาน
                </a>

                <a href="/ptpetho-admin/feedback.php" class="btn btn-outline" style="padding: 1.25rem; flex-direction: column; height: auto;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 0.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    ส่ง Feedback
                </a>

                <a href="/ptpetho-admin/reports.php" class="btn btn-outline" style="padding: 1.25rem; flex-direction: column; height: auto;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 0.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    ดูรายงาน
                </a>

                <a href="/ptpetho-admin/profile.php" class="btn btn-outline" style="padding: 1.25rem; flex-direction: column; height: auto;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 0.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    โปรไฟล์
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: ['Q1/68', 'Q2/68', 'Q3/68', 'Q4/68', 'Q1/69'],
        datasets: [{
            label: 'รายได้ (พันล้านบาท)',
            data: [95.2, 102.5, 98.8, 115.3, 125.8],
            backgroundColor: [
                'rgba(13, 110, 63, 0.7)',
                'rgba(13, 110, 63, 0.7)',
                'rgba(13, 110, 63, 0.7)',
                'rgba(13, 110, 63, 0.7)',
                'rgba(212, 167, 32, 0.9)'
            ],
            borderColor: [
                'rgb(13, 110, 63)',
                'rgb(13, 110, 63)',
                'rgb(13, 110, 63)',
                'rgb(13, 110, 63)',
                'rgb(212, 167, 32)'
            ],
            borderWidth: 2,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Fuel Type Chart
const fuelCtx = document.getElementById('fuelTypeChart').getContext('2d');
new Chart(fuelCtx, {
    type: 'doughnut',
    data: {
        labels: ['Diesel', 'Benzine 95', 'Gasohol E20', 'Gasohol E85', 'NGV'],
        datasets: [{
            data: [45, 25, 15, 10, 5],
            backgroundColor: [
                'rgba(13, 110, 63, 0.9)',
                'rgba(212, 167, 32, 0.9)',
                'rgba(23, 162, 184, 0.9)',
                'rgba(255, 193, 7, 0.9)',
                'rgba(108, 117, 125, 0.9)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});
</script>

<?php require_once __DIR__ . '/../includes/admin-footer.php'; ?>
