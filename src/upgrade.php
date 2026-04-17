<?php
/**
 * PTPetho - Upgrade Page
 * Challenge 2: Hidden form fields can be manipulated
 */

$pageTitle = 'อัพเกรดบัญชี';
$currentPage = 'upgrade';

// Handle form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientTier = $_POST['client_tier'] ?? 'free';
    $price = $_POST['price'] ?? 0;

    // Check if tier was manipulated
    if ($clientTier !== 'free' && $price == 0) {
        // Suspicious activity detected - show security alert (hint for Challenge 3)
        $message = "PETRATHAI SECURITY ALERT

Unauthorized tier modification detected.
Your request has been logged.

If you are an authorized security researcher,
please verify your identity at /verify

System info logged:
  timestamp: " . date('Y-m-d H:i:s') . "
  server: Apache/2.4.54 (Ubuntu)
  backend: PHP/8.1.12
  monitoring: enabled";
        $messageType = 'warning';
    } elseif ($clientTier === 'free') {
        $message = 'กรุณาเลือกแพ็กเกจที่ต้องการอัพเกรด';
        $messageType = 'info';
    } else {
        $message = "การอัพเกรดไปยัง $clientTier สำเร็จ! (ทดสอบเท่านั้น)";
        $messageType = 'success';
    }
}

require_once __DIR__ . '/includes/header.php';
?>

    <!-- Page Header -->
    <section style="background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%); color: white; padding: 4rem 0;">
        <div class="container text-center">
            <h1 style="color: white; margin-bottom: 0.5rem;">อัพเกรดบัญชีของคุณ</h1>
            <p style="opacity: 0.9;">เลือกแพ็กเกจที่เหมาะกับความต้องการของคุณ</p>
        </div>
    </section>

    <!-- Message Alert -->
    <?php if ($message): ?>
    <div class="container" style="margin-top: 2rem;">
        <div class="alert alert-<?= $messageType ?>">
            <pre style="margin: 0; white-space: pre-wrap; font-family: var(--font-mono, monospace);"><?= htmlspecialchars($message) ?></pre>
        </div>
    </div>
    <?php endif; ?>

    <!-- Pricing Section -->
    <section class="section">
        <div class="container">
            <div class="pricing-grid">
                <!-- Free Tier -->
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Free</h3>
                        <div class="pricing-price">฿0 <span>/เดือน</span></div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li>ดูข้อมูลพื้นฐาน</li>
                            <li>ข่าวสารทั่วไป</li>
                            <li>สมัครสมาชิก</li>
                            <li style="color: var(--medium-gray); text-decoration: line-through;">รายงานราคาน้ำมัน</li>
                            <li style="color: var(--medium-gray); text-decoration: line-through;">API Access</li>
                        </ul>
                        <form action="/upgrade.php" method="POST">
                            <input type="hidden" name="client_tier" value="free">
                            <input type="hidden" name="price" value="0">
                            <button type="submit" class="btn btn-outline" style="width: 100%;">แพ็กเกจปัจจุบัน</button>
                        </form>
                    </div>
                </div>

                <!-- Basic Tier -->
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Basic</h3>
                        <div class="pricing-price">฿299 <span>/เดือน</span></div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li>ทุกอย่างใน Free</li>
                            <li>รายงานราคาน้ำมันรายวัน</li>
                            <li>แจ้งเตือนราคา</li>
                            <li>ประวัติราคา 30 วัน</li>
                            <li style="color: var(--medium-gray); text-decoration: line-through;">API Access</li>
                        </ul>
                        <form action="/upgrade.php" method="POST">
                            <input type="hidden" name="client_tier" value="basic">
                            <input type="hidden" name="price" value="299">
                            <button type="submit" class="btn btn-outline" style="width: 100%;">เลือกแพ็กเกจ</button>
                        </form>
                    </div>
                </div>

                <!-- Premium Tier (Featured) -->
                <div class="pricing-card featured">
                    <div class="pricing-header">
                        <h3>Premium</h3>
                        <div class="pricing-price">฿999 <span>/เดือน</span></div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li>ทุกอย่างใน Basic</li>
                            <li>รายงานวิเคราะห์ตลาด</li>
                            <li>ประวัติราคา 1 ปี</li>
                            <li>API Access (1,000 calls/day)</li>
                            <li>Priority Support</li>
                        </ul>
                        <form action="/upgrade.php" method="POST">
                            <input type="hidden" name="client_tier" value="premium">
                            <input type="hidden" name="price" value="999">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">เลือกแพ็กเกจ</button>
                        </form>
                    </div>
                </div>

                <!-- Enterprise Tier -->
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Enterprise</h3>
                        <div class="pricing-price">฿2,999 <span>/เดือน</span></div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li>ทุกอย่างใน Premium</li>
                            <li>API Access ไม่จำกัด</li>
                            <li>Dedicated Account Manager</li>
                            <li>Custom Reports</li>
                            <li>SLA 99.9%</li>
                        </ul>
                        <form action="/upgrade.php" method="POST">
                            <input type="hidden" name="client_tier" value="enterprise">
                            <input type="hidden" name="price" value="2999">
                            <button type="submit" class="btn btn-outline" style="width: 100%;">ติดต่อฝ่ายขาย</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section section-alt">
        <div class="container" style="max-width: 800px;">
            <h2 class="text-center mb-4">คำถามที่พบบ่อย</h2>

            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm);">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--light-gray);">
                    <h4 style="margin-bottom: 0.5rem;">สามารถเปลี่ยนแพ็กเกจได้หรือไม่?</h4>
                    <p style="margin: 0; color: var(--medium-gray);">ได้ครับ คุณสามารถอัพเกรดหรือดาวน์เกรดแพ็กเกจได้ตลอดเวลา การเปลี่ยนแปลงจะมีผลในรอบบิลถัดไป</p>
                </div>
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--light-gray);">
                    <h4 style="margin-bottom: 0.5rem;">รับชำระเงินผ่านช่องทางใดบ้าง?</h4>
                    <p style="margin: 0; color: var(--medium-gray);">รับชำระผ่านบัตรเครดิต/เดบิต, โอนเงินผ่านธนาคาร, และ PromptPay</p>
                </div>
                <div style="padding: 1.5rem;">
                    <h4 style="margin-bottom: 0.5rem;">มีการทดลองใช้ฟรีหรือไม่?</h4>
                    <p style="margin: 0; color: var(--medium-gray);">แพ็กเกจ Premium และ Enterprise มีทดลองใช้ฟรี 14 วัน โดยไม่ต้องผูกบัตร</p>
                </div>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
