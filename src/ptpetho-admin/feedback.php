<?php
/**
 * PTPetho Admin - Send Feedback
 * Challenge 8: Stored XSS in feedback form
 */

$pageTitle = 'Send Feedback';
$currentPage = 'feedback';

require_once __DIR__ . '/../includes/admin-header.php';

// Handle form submission
$message = '';
$messageType = '';
$submittedFeedback = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'] ?? '';
    $feedbackMessage = $_POST['message'] ?? '';

    if (empty($subject) || empty($feedbackMessage)) {
        $message = 'กรุณากรอกข้อมูลให้ครบถ้วน';
        $messageType = 'danger';
    } else {
        $result = submitFeedback($subject, $feedbackMessage);

        if ($result['success']) {
            $message = 'ส่ง Feedback สำเร็จ! CEO จะตรวจสอบภายใน 24 ชั่วโมง';
            $messageType = 'success';

            // Store submitted feedback for preview (XSS will trigger here)
            $submittedFeedback = [
                'subject' => $subject,
                'message' => $feedbackMessage
            ];
        } else {
            $message = 'เกิดข้อผิดพลาด: ' . $result['error'];
            $messageType = 'danger';
        }
    }
}
?>

<!-- Page Header -->
<div class="content-header">
    <h1>Send Feedback</h1>
    <p class="text-muted">ส่งข้อเสนอแนะหรือรายงานปัญหาไปยัง CEO โดยตรง</p>
</div>

<!-- Alert Messages -->
<?php if ($message): ?>
<div class="alert alert-<?= $messageType ?>">
    <?= htmlspecialchars($message) ?>
</div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- Feedback Form -->
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">📝 Admin Feedback System</h3>
        </div>
        <div class="panel-body">
            <form method="POST" class="admin-form">
                <div class="form-group">
                    <label class="form-label">Subject / หัวข้อ</label>
                    <input
                        type="text"
                        name="subject"
                        class="form-control"
                        placeholder="หัวข้อของ Feedback"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Message / ข้อความ</label>
                    <textarea
                        name="message"
                        class="form-control"
                        rows="8"
                        placeholder="เขียนข้อความ Feedback ของคุณที่นี่..."
                        required
                    ></textarea>
                    <p class="form-hint">รองรับ HTML formatting สำหรับการจัดรูปแบบข้อความ</p>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Send Feedback
                </button>
            </form>
        </div>
        <div class="panel-footer">
            <p style="margin: 0; font-size: 0.875rem; color: var(--medium-gray);">
                ⚠️ Note: CEO reviews all feedback personally
            </p>
        </div>
    </div>

    <!-- Preview Section -->
    <div>
        <?php if ($submittedFeedback): ?>
        <!-- Feedback Preview (XSS triggers here) -->
        <div class="panel">
            <div class="panel-header" style="background: rgba(40, 167, 69, 0.1);">
                <h3 class="panel-title" style="color: var(--success);">✅ Feedback Submitted!</h3>
            </div>
            <div class="panel-body">
                <p><strong>Preview of your feedback:</strong></p>

                <div style="border: 1px solid var(--light-gray); border-radius: 8px; padding: 1.5rem; margin-top: 1rem; background: var(--off-white);">
                    <h4 style="margin-bottom: 0.5rem;">
                        <?= $submittedFeedback['subject'] ?>
                    </h4>
                    <hr style="margin: 1rem 0; border: none; border-top: 1px solid var(--light-gray);">
                    <div class="feedback-content">
                        <?= $submittedFeedback['message'] ?>
                    </div>
                </div>

                <p style="margin-top: 1rem; color: var(--medium-gray); font-size: 0.875rem;">
                    ⏱️ CEO will review this within 24 hours.
                </p>
            </div>
        </div>
        <?php else: ?>
        <!-- Info Panel -->
        <div class="panel">
            <div class="panel-header">
                <h3 class="panel-title">📋 Guidelines</h3>
            </div>
            <div class="panel-body">
                <h4>Feedback ที่ดีควรประกอบด้วย:</h4>
                <ul style="margin-top: 1rem;">
                    <li>หัวข้อที่ชัดเจนและกระชับ</li>
                    <li>รายละเอียดของปัญหาหรือข้อเสนอแนะ</li>
                    <li>ขั้นตอนการเกิดปัญหา (ถ้ามี)</li>
                    <li>ข้อมูลติดต่อกลับ</li>
                </ul>

                <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(212, 167, 32, 0.1); border-radius: 8px;">
                    <strong style="color: var(--accent-gold-dark);">💡 Tip:</strong>
                    <p style="margin: 0.5rem 0 0; font-size: 0.875rem;">
                        Feedback ที่มีรายละเอียดครบถ้วนจะได้รับการตอบกลับเร็วขึ้น
                    </p>
                </div>
            </div>
        </div>

        <div class="panel" style="margin-top: 1rem;">
            <div class="panel-header">
                <h3 class="panel-title">📊 Statistics</h3>
            </div>
            <div class="panel-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; text-align: center;">
                    <div>
                        <h3 style="color: var(--primary-green); margin: 0;">98%</h3>
                        <p style="margin: 0; font-size: 0.875rem; color: var(--medium-gray);">ตอบกลับภายใน 24 ชม.</p>
                    </div>
                    <div>
                        <h3 style="color: var(--accent-gold); margin: 0;">4.8/5</h3>
                        <p style="margin: 0; font-size: 0.875rem; color: var(--medium-gray);">ความพึงพอใจ</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/admin-footer.php'; ?>
