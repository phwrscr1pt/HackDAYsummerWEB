<?php
/**
 * PTPetho Admin - Feedback Inbox
 * Lists all feedback messages
 */

$pageTitle = 'Feedback Inbox';
$currentPage = 'feedback-inbox';

require_once __DIR__ . '/../includes/admin-header.php';

// Get all feedback
$feedbackList = getFeedbackList();
$unreadCount = 0;
foreach ($feedbackList as $f) {
    if (!$f['is_read']) $unreadCount++;
}
?>

<!-- Page Header -->
<div class="content-header">
    <h1>Feedback Inbox</h1>
    <div>
        <span class="badge badge-danger" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
            <?= $unreadCount ?> unread
        </span>
    </div>
</div>

<!-- Feedback List -->
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">All Feedback Messages</h3>
        <a href="/ptpetho-admin/feedback.php" class="btn btn-primary btn-sm">
            + New Feedback
        </a>
    </div>
    <div class="panel-body" style="padding: 0;">
        <?php if (empty($feedbackList)): ?>
        <p class="text-center text-muted" style="padding: 3rem;">ไม่มี feedback</p>
        <?php else: ?>
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Priority</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbackList as $feedback): ?>
                    <tr style="<?= !$feedback['is_read'] ? 'background: rgba(220, 53, 69, 0.03);' : '' ?>">
                        <td>
                            <?php if (!$feedback['is_read']): ?>
                            <span style="display: inline-block; width: 10px; height: 10px; background: var(--danger); border-radius: 50%;"></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    <?= getInitials($feedback['sender_name']) ?>
                                </div>
                                <div>
                                    <strong><?= htmlspecialchars($feedback['sender_name']) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= htmlspecialchars($feedback['sender_role']) ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="/ptpetho-admin/feedback-view.php?id=<?= $feedback['id'] ?>" style="<?= !$feedback['is_read'] ? 'font-weight: 600;' : '' ?>">
                                <?= htmlspecialchars(mb_substr($feedback['subject'], 0, 50)) ?>
                                <?= mb_strlen($feedback['subject']) > 50 ? '...' : '' ?>
                            </a>
                        </td>
                        <td>
                            <span class="badge priority-<?= $feedback['priority'] ?>">
                                <?= $feedback['priority'] ?>
                            </span>
                        </td>
                        <td>
                            <span title="<?= $feedback['created_at'] ?>">
                                <?= timeAgo($feedback['created_at']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($feedback['is_read']): ?>
                            <span class="badge badge-success">Read</span>
                            <?php else: ?>
                            <span class="badge badge-warning">Unread</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/ptpetho-admin/feedback-view.php?id=<?= $feedback['id'] ?>" class="btn btn-sm btn-outline">
                                View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/admin-footer.php'; ?>
