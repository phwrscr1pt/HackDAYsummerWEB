<?php
/**
 * PTPetho - Verification Page
 * Challenge 3: Network tab reveals config.json with sensitive info
 */

$pageTitle = 'ยืนยันตัวตน';
$currentPage = 'verify';

require_once __DIR__ . '/includes/header.php';
?>

    <!-- Page Header -->
    <section style="background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%); color: white; padding: 4rem 0;">
        <div class="container text-center">
            <h1 style="color: white; margin-bottom: 0.5rem;">ยืนยันตัวตน</h1>
            <p style="opacity: 0.9;">สำหรับทีม QA และ Security Researchers</p>
        </div>
    </section>

    <!-- Verification Section -->
    <section class="section">
        <div class="container" style="max-width: 600px;">
            <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: var(--shadow-md);">
                <div class="text-center mb-4">
                    <div style="width: 80px; height: 80px; background: rgba(13, 110, 63, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="var(--primary-green)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h2>ระบบยืนยันตัวตน</h2>
                    <p class="text-muted">กรุณากรอกข้อมูลเพื่อยืนยันว่าคุณเป็น Security Researcher</p>
                </div>

                <form id="verify-form" class="admin-form">
                    <div class="form-group">
                        <label class="form-label">ชื่อ-นามสกุล</label>
                        <input type="text" class="form-control" placeholder="กรอกชื่อ-นามสกุล" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">อีเมล</label>
                        <input type="email" class="form-control" placeholder="your@email.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">องค์กร / บริษัท</label>
                        <input type="text" class="form-control" placeholder="ชื่อองค์กรของคุณ">
                    </div>

                    <div class="form-group">
                        <label class="form-label">วัตถุประสงค์</label>
                        <select class="form-control">
                            <option value="">-- เลือกวัตถุประสงค์ --</option>
                            <option value="security_research">Security Research</option>
                            <option value="penetration_testing">Penetration Testing</option>
                            <option value="bug_bounty">Bug Bounty</option>
                            <option value="compliance_audit">Compliance Audit</option>
                            <option value="other">อื่นๆ</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">รายละเอียดเพิ่มเติม</label>
                        <textarea class="form-control" rows="4" placeholder="อธิบายวัตถุประสงค์ของคุณ..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                        ส่งคำขอยืนยัน
                    </button>
                </form>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--light-gray);">
                    <p class="text-muted text-center" style="font-size: 0.875rem;">
                        หากคุณเป็นพนักงาน PTPetho กรุณาเข้าสู่ระบบผ่าน<br>
                        <a href="/ptpetho-admin/">Staff Portal</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="section section-alt">
        <div class="container" style="max-width: 800px;">
            <h2 class="text-center mb-4">นโยบาย Responsible Disclosure</h2>

            <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: var(--shadow-sm);">
                <p>PTPetho ยินดีรับฟังรายงานช่องโหว่ด้านความปลอดภัยจาก Security Researchers ที่ปฏิบัติตามหลัก Responsible Disclosure</p>

                <h4 style="margin-top: 1.5rem;">สิ่งที่เราอนุญาต:</h4>
                <ul>
                    <li>ทดสอบช่องโหว่ในระบบทดสอบที่กำหนด</li>
                    <li>รายงานช่องโหว่ผ่านช่องทางที่กำหนด</li>
                    <li>ได้รับค่าตอบแทนตามความรุนแรงของช่องโหว่</li>
                </ul>

                <h4 style="margin-top: 1.5rem;">สิ่งที่ไม่อนุญาต:</h4>
                <ul>
                    <li>โจมตีระบบ Production โดยไม่ได้รับอนุญาต</li>
                    <li>เข้าถึงข้อมูลของผู้ใช้งานจริง</li>
                    <li>ทำลายหรือแก้ไขข้อมูลในระบบ</li>
                    <li>เปิดเผยช่องโหว่ก่อนได้รับอนุญาต</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- This script loads config (Challenge 3) -->
    <script>
        // Load configuration on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch internal configuration
            fetch('/api/internal/config.json')
                .then(response => response.json())
                .then(data => {
                    console.log('Config loaded:', data.environment);
                })
                .catch(err => console.error('Config error'));

            // Form submission handler
            document.getElementById('verify-form').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('คำขอของคุณถูกส่งแล้ว ทีมงานจะติดต่อกลับภายใน 3 วันทำการ');
            });
        });
    </script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
