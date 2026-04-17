<?php
$pageTitle = 'ร่วมงานกับเรา';
$currentPage = 'careers';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <h1>ร่วมงานกับเรา</h1>
        <p>เติบโตไปด้วยกันกับครอบครัว PTPetho</p>
    </div>
</section>

<!-- Careers Content -->
<section class="section">
    <div class="container">
        <div class="careers-intro">
            <h2>ทำไมต้อง PTPetho?</h2>
            <p>เราเชื่อว่าพนักงานคือหัวใจสำคัญของความสำเร็จ PTPetho มุ่งมั่นสร้างสภาพแวดล้อมการทำงานที่ดี พร้อมโอกาสในการเติบโตและพัฒนาศักยภาพ</p>
        </div>

        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">💰</div>
                <h4>เงินเดือนและสวัสดิการ</h4>
                <p>เงินเดือนแข่งขันได้ โบนัสประจำปี ประกันสุขภาพ กองทุนสำรองเลี้ยงชีพ</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">📚</div>
                <h4>การพัฒนาบุคลากร</h4>
                <p>โปรแกรมฝึกอบรม ทุนการศึกษา โอกาสดูงานต่างประเทศ</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">⚖️</div>
                <h4>Work-Life Balance</h4>
                <p>วันลาพักร้อน 15 วัน ทำงานยืดหยุ่น กิจกรรมสันทนาการ</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">🚀</div>
                <h4>ความก้าวหน้า</h4>
                <p>โอกาสเลื่อนตำแหน่ง Career Path ที่ชัดเจน</p>
            </div>
        </div>

        <h2 class="section-title">ตำแหน่งงานที่เปิดรับ</h2>
        <div class="jobs-list">
            <div class="job-card">
                <div class="job-header">
                    <h3>วิศวกรโรงกลั่น</h3>
                    <span class="job-tag">Engineering</span>
                </div>
                <p class="job-location">📍 ระยอง</p>
                <p>รับผิดชอบดูแลกระบวนการผลิตในโรงกลั่น ควบคุมคุณภาพผลิตภัณฑ์</p>
                <a href="#" class="btn btn-outline">ดูรายละเอียด</a>
            </div>
            <div class="job-card">
                <div class="job-header">
                    <h3>นักวิเคราะห์ข้อมูล</h3>
                    <span class="job-tag">IT</span>
                </div>
                <p class="job-location">📍 กรุงเทพฯ</p>
                <p>วิเคราะห์ข้อมูลธุรกิจ สร้าง Dashboard และ Report สำหรับผู้บริหาร</p>
                <a href="#" class="btn btn-outline">ดูรายละเอียด</a>
            </div>
            <div class="job-card">
                <div class="job-header">
                    <h3>ผู้จัดการสถานีบริการ</h3>
                    <span class="job-tag">Operations</span>
                </div>
                <p class="job-location">📍 ทั่วประเทศ</p>
                <p>บริหารจัดการสถานีบริการ ดูแลทีมงาน ควบคุมยอดขายและคุณภาพบริการ</p>
                <a href="#" class="btn btn-outline">ดูรายละเอียด</a>
            </div>
            <div class="job-card">
                <div class="job-header">
                    <h3>Cybersecurity Specialist</h3>
                    <span class="job-tag">IT Security</span>
                </div>
                <p class="job-location">📍 กรุงเทพฯ</p>
                <p>ดูแลระบบความปลอดภัยทางไซเบอร์ ทดสอบช่องโหว่ ตอบสนองต่อภัยคุกคาม</p>
                <a href="#" class="btn btn-outline">ดูรายละเอียด</a>
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
.careers-intro {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 3rem;
}
.careers-intro h2 {
    color: var(--primary-green);
    margin-bottom: 1rem;
}
.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}
.benefit-card {
    background: var(--background-light);
    padding: 1.5rem;
    border-radius: 10px;
    text-align: center;
}
.benefit-icon {
    font-size: 2rem;
    margin-bottom: 0.75rem;
}
.benefit-card h4 {
    color: var(--primary-green);
    margin-bottom: 0.5rem;
}
.benefit-card p {
    font-size: 0.9rem;
    color: var(--text-muted);
}
.section-title {
    color: var(--primary-green);
    margin-bottom: 1.5rem;
}
.jobs-list {
    display: grid;
    gap: 1.5rem;
}
.job-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 1.5rem;
}
.job-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}
.job-header h3 {
    color: var(--text-dark);
}
.job-tag {
    background: var(--primary-green);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
}
.job-location {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}
.job-card > p {
    margin-bottom: 1rem;
}
.btn-outline {
    border: 1px solid var(--primary-green);
    color: var(--primary-green);
    background: transparent;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
}
.btn-outline:hover {
    background: var(--primary-green);
    color: white;
}
</style>

<?php require_once 'includes/footer.php'; ?>
