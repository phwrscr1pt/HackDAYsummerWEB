<?php
$pageTitle = 'ติดต่อเรา';
$currentPage = 'contact';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <h1>ติดต่อเรา</h1>
        <p>พร้อมให้บริการและรับฟังความคิดเห็นจากท่าน</p>
    </div>
</section>

<!-- Contact Content -->
<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2>ข้อมูลติดต่อ</h2>

                <div class="contact-item">
                    <div class="contact-icon">🏢</div>
                    <div>
                        <h4>สำนักงานใหญ่</h4>
                        <p>555 ถนนวิภาวดีรังสิต แขวงจตุจักร<br>เขตจตุจักร กรุงเทพฯ 10900</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">📞</div>
                    <div>
                        <h4>โทรศัพท์</h4>
                        <p>02-XXX-XXXX (สำนักงานใหญ่)<br>1365 (Call Center 24 ชม.)</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">📧</div>
                    <div>
                        <h4>อีเมล</h4>
                        <p>info@ptpetho.co.th<br>customer@ptpetho.co.th</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">🕐</div>
                    <div>
                        <h4>เวลาทำการ</h4>
                        <p>จันทร์ - ศุกร์: 08:00 - 17:00 น.<br>เสาร์: 08:00 - 12:00 น.</p>
                    </div>
                </div>
            </div>

            <div class="contact-form-wrapper">
                <h2>ส่งข้อความถึงเรา</h2>
                <form class="contact-form" onsubmit="return false;">
                    <div class="form-group">
                        <label for="name">ชื่อ-นามสกุล</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">อีเมล</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">เบอร์โทรศัพท์</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="subject">หัวข้อ</label>
                        <select id="subject" name="subject">
                            <option value="">-- เลือกหัวข้อ --</option>
                            <option value="general">สอบถามทั่วไป</option>
                            <option value="complaint">ร้องเรียน</option>
                            <option value="suggestion">ข้อเสนอแนะ</option>
                            <option value="business">ติดต่อธุรกิจ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">ข้อความ</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">ส่งข้อความ</button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.page-hero {
    background: linear-gradient(135deg, var(--primary-green) 0%, #0a5a33 100%);
    color: white;
    padding: 4rem 0;
    text-align: center;
}
.page-hero h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    margin-top: 2rem;
}
@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
    }
}
.contact-info h2,
.contact-form-wrapper h2 {
    color: var(--primary-green);
    margin-bottom: 1.5rem;
}
.contact-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.contact-icon {
    font-size: 1.5rem;
    width: 40px;
}
.contact-item h4 {
    margin-bottom: 0.25rem;
    color: var(--text-dark);
}
.contact-item p {
    color: var(--text-muted);
    font-size: 0.95rem;
}
.contact-form {
    background: var(--background-light);
    padding: 2rem;
    border-radius: 12px;
}
.form-group {
    margin-bottom: 1rem;
}
.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}
.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-green);
}
</style>

<?php require_once 'includes/footer.php'; ?>
