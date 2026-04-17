<?php
/**
 * PTPetho Admin - Staff Search
 * Challenge 5: Error-based SQLi discovery
 * Challenge 6: Union-based SQLi extraction
 */

$pageTitle = 'Staff Directory';
$currentPage = 'search';

require_once __DIR__ . '/../includes/admin-header.php';

// Handle search
$searchTerm = $_GET['q'] ?? '';
$searchResult = null;
$showFlag = false;

if (!empty($searchTerm)) {
    $searchResult = searchStaff($searchTerm);

    // Check if superadmin credentials were extracted (for FLAG 2)
    if ($searchResult['success'] && !empty($searchResult['data'])) {
        foreach ($searchResult['data'] as $row) {
            // Check if password hash is visible (indicates successful SQLi)
            if (isset($row['password_hash']) || isset($row['password'])) {
                $showFlag = true;
            }
        }
    }
}
?>

<!-- Page Header -->
<div class="content-header">
    <h1>Staff Directory</h1>
    <p class="text-muted">ค้นหาข้อมูลพนักงานในระบบ</p>
</div>

<!-- Search Box -->
<div class="search-box">
    <form method="GET" action="" style="display: flex; gap: 1rem; width: 100%;">
        <input
            type="text"
            name="q"
            class="form-control"
            placeholder="ค้นหาด้วยชื่อ, รหัสพนักงาน, หรือแผนก..."
            value="<?= htmlspecialchars($searchTerm) ?>"
            style="flex: 1;"
        >
        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            ค้นหา
        </button>
    </form>
</div>

<!-- FLAG 2 Display -->
<?php if ($showFlag): ?>
<div class="alert alert-success" style="margin-bottom: 1.5rem;">
    <strong>🚩 FLAG 2: FLAG{uni0n_b4s3d_extr4ct10n}</strong>
    <p style="margin: 0.5rem 0 0;">Congratulations! You successfully extracted data using SQL Injection.</p>
</div>
<?php endif; ?>

<!-- Search Results -->
<?php if ($searchResult !== null): ?>
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">
            ผลการค้นหา
            <?php if ($searchResult['success']): ?>
                <span class="badge badge-primary" style="margin-left: 0.5rem;"><?= $searchResult['count'] ?> รายการ</span>
            <?php endif; ?>
        </h3>
    </div>
    <div class="panel-body">
        <?php if (!$searchResult['success']): ?>
            <!-- SQL Error Display (Challenge 5) -->
            <div class="alert alert-danger">
                <strong>⚠️ Error Message จากระบบ</strong>
                <pre style="margin: 1rem 0 0; padding: 1rem; background: #f8f9fa; border-radius: 4px; overflow-x: auto; font-size: 0.8125rem;">MySQL Error: <?= htmlspecialchars($searchResult['error']) ?>

Query: <?= htmlspecialchars($searchResult['query']) ?></pre>
            </div>

            <p class="text-muted" style="font-size: 0.875rem; margin-top: 1rem;">
                System notice: Query executed against database: <code>ptpetho_internal</code>
            </p>

        <?php elseif (empty($searchResult['data'])): ?>
            <p class="text-center text-muted" style="padding: 3rem 0;">
                ไม่พบข้อมูลที่ตรงกับ "<?= htmlspecialchars($searchTerm) ?>"
            </p>

        <?php else: ?>
            <!-- Results Table -->
            <div class="table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <?php
                            // Dynamic headers based on returned columns
                            $firstRow = $searchResult['data'][0];
                            foreach (array_keys($firstRow) as $column):
                            ?>
                            <th><?= htmlspecialchars($column) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResult['data'] as $row): ?>
                        <tr>
                            <?php foreach ($row as $key => $value): ?>
                            <td>
                                <?php if ($key === 'status'): ?>
                                    <span class="badge badge-<?= $value === 'active' ? 'success' : 'warning' ?>">
                                        <?= htmlspecialchars($value) ?>
                                    </span>
                                <?php elseif ($key === 'role'): ?>
                                    <span class="badge badge-<?= $value === 'ceo' ? 'danger' : ($value === 'superadmin' ? 'warning' : 'info') ?>">
                                        <?= htmlspecialchars($value) ?>
                                    </span>
                                <?php else: ?>
                                    <?= htmlspecialchars($value ?? '-') ?>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<!-- Default View - Show All Staff -->
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">พนักงานทั้งหมด</h3>
    </div>
    <div class="panel-body">
        <?php
        $allStaff = searchStaff('');
        if ($allStaff['success'] && !empty($allStaff['data'])):
        ?>
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                        <th>อีเมล</th>
                        <th>แผนก</th>
                        <th>ตำแหน่ง</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allStaff['data'] as $staff): ?>
                    <tr>
                        <td><code><?= htmlspecialchars($staff['employee_id']) ?></code></td>
                        <td><?= htmlspecialchars($staff['name']) ?></td>
                        <td><?= htmlspecialchars($staff['email']) ?></td>
                        <td><?= htmlspecialchars($staff['department']) ?></td>
                        <td><?= htmlspecialchars($staff['position']) ?></td>
                        <td>
                            <span class="badge badge-<?= $staff['status'] === 'active' ? 'success' : 'warning' ?>">
                                <?= $staff['status'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Help Section -->
<div class="panel" style="margin-top: 1.5rem;">
    <div class="panel-header">
        <h3 class="panel-title">วิธีใช้งาน</h3>
    </div>
    <div class="panel-body">
        <p>คุณสามารถค้นหาพนักงานได้ด้วย:</p>
        <ul>
            <li><strong>ชื่อพนักงาน</strong> - เช่น "Somchai", "Kim"</li>
            <li><strong>รหัสพนักงาน</strong> - เช่น "PTP001", "PTP002"</li>
            <li><strong>แผนก</strong> - เช่น "IT", "Finance", "Executive"</li>
        </ul>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/admin-footer.php'; ?>
