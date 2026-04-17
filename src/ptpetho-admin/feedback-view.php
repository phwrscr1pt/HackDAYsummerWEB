<?php
/**
 * PTPetho Admin - View Feedback
 * Challenge 8 & 9: XSS payload executes here when CEO views feedback
 * This page renders HTML without sanitization
 */

$pageTitle = 'View Feedback';
$currentPage = 'feedback-inbox';

require_once __DIR__ . '/../includes/admin-header.php';

// Get feedback ID
$feedbackId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($feedbackId <= 0) {
    header('Location: /ptpetho-admin/feedback-inbox.php');
    exit;
}

// Get feedback details
$feedback = getFeedback($feedbackId);

if (!$feedback) {
    echo '<div class="alert alert-danger">Feedback not found</div>';
    require_once __DIR__ . '/../includes/admin-footer.php';
    exit;
}

// Check if XSS payload was in the message (for flag detection)
$hasXSSPayload = (
    strpos($feedback['message'], '<script') !== false ||
    strpos($feedback['message'], 'onerror') !== false ||
    strpos($feedback['message'], 'onload') !== false ||
    strpos($feedback['message'], 'javascript:') !== false
);
?>

<!-- Page Header -->
<div class="content-header">
    <div>
        <a href="/ptpetho-admin/feedback-inbox.php" class="text-muted" style="font-size: 0.875rem;">
            ← Back to Inbox
        </a>
        <h1 style="margin-top: 0.5rem;">View Feedback</h1>
    </div>
    <span class="badge priority-<?= $feedback['priority'] ?>" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
        <?= strtoupper($feedback['priority']) ?> PRIORITY
    </span>
</div>

<!-- FLAG 4 Display (if XSS detected) -->
<?php if ($hasXSSPayload): ?>
<div class="alert alert-success" style="margin-bottom: 1.5rem;">
    <strong>🚩 FLAG 4: SMC{st0r3d_xss_c00k13_th3ft}</strong>
    <p style="margin: 0.5rem 0 0;">Stored XSS payload detected in feedback message!</p>
</div>
<?php endif; ?>

<!-- Feedback Message (VULNERABLE - renders raw HTML) -->
<div class="feedback-message">
    <div class="feedback-header">
        <div class="feedback-sender">
            <div class="feedback-avatar">
                <?= getInitials($feedback['sender_name']) ?>
            </div>
            <div class="feedback-meta">
                <strong><?= htmlspecialchars($feedback['sender_name']) ?></strong>
                <span><?= htmlspecialchars($feedback['sender_role']) ?></span>
                <span><?= formatThaiDate($feedback['created_at']) ?> (<?= date('H:i', strtotime($feedback['created_at'])) ?>)</span>
            </div>
        </div>
        <div>
            <?php if ($feedback['is_read']): ?>
            <span class="badge badge-success">Read</span>
            <?php else: ?>
            <span class="badge badge-warning">Unread</span>
            <?php endif; ?>
        </div>
    </div>

    <div style="margin-bottom: 1rem;">
        <h3 style="margin: 0;"><?= htmlspecialchars($feedback['subject']) ?></h3>
    </div>

    <hr style="border: none; border-top: 1px solid var(--light-gray); margin: 1rem 0;">

    <!-- VULNERABLE: Message rendered without XSS sanitization -->
    <div class="feedback-content" style="line-height: 1.8; min-height: 100px;">
        <?= $feedback['message'] ?>
    </div>
</div>

<!-- Actions -->
<div class="panel">
    <div class="panel-body" style="display: flex; gap: 1rem; justify-content: flex-end;">
        <a href="/ptpetho-admin/feedback-inbox.php" class="btn btn-outline">
            Back to Inbox
        </a>
        <button class="btn btn-primary" onclick="alert('Reply feature coming soon!')">
            Reply
        </button>
    </div>
</div>

<!-- Debug Info (for educational purposes) -->
<div class="panel" style="margin-top: 1.5rem;">
    <div class="panel-header">
        <h3 class="panel-title">📋 Message Details (Debug)</h3>
    </div>
    <div class="panel-body">
        <table style="width: 100%; font-size: 0.875rem;">
            <tr>
                <td style="padding: 0.5rem; width: 150px;"><strong>Message ID:</strong></td>
                <td style="padding: 0.5rem;"><?= $feedback['id'] ?></td>
            </tr>
            <tr>
                <td style="padding: 0.5rem;"><strong>Sender ID:</strong></td>
                <td style="padding: 0.5rem;"><?= $feedback['sender_id'] ?></td>
            </tr>
            <tr>
                <td style="padding: 0.5rem;"><strong>Created:</strong></td>
                <td style="padding: 0.5rem;"><?= $feedback['created_at'] ?></td>
            </tr>
            <tr>
                <td style="padding: 0.5rem;"><strong>Read:</strong></td>
                <td style="padding: 0.5rem;"><?= $feedback['is_read'] ? 'Yes' : 'No' ?> <?= $feedback['read_at'] ? '(' . $feedback['read_at'] . ')' : '' ?></td>
            </tr>
            <tr>
                <td style="padding: 0.5rem;"><strong>Raw Message Length:</strong></td>
                <td style="padding: 0.5rem;"><?= strlen($feedback['message']) ?> characters</td>
            </tr>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/admin-footer.php'; ?>
