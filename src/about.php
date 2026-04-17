<?php
$pageTitle = 'เกี่ยวกับเรา';
$currentPage = 'about';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <h1>เกี่ยวกับเรา</h1>
        <p>บริษัท พีทีเพโทร เอนเนอร์จี จำกัด (มหาชน)</p>
    </div>
</section>

<!-- About Content -->
<section class="section">
    <div class="container">
        <div class="content-grid">
            <div class="content-main">
                <h2>วิสัยทัศน์</h2>
                <p>เป็นผู้นำด้านพลังงานอย่างยั่งยืนของประเทศไทย มุ่งมั่นพัฒนาพลังงานสะอาดและนวัตกรรมเพื่ออนาคต</p>

                <h2>พันธกิจ</h2>
                <ul>
                    <li>จัดหาและจำหน่ายผลิตภัณฑ์ปิโตรเลียมคุณภาพสูง</li>
                    <li>พัฒนาเครือข่ายสถานีบริการทั่วประเทศ</li>
                    <li>ลงทุนในพลังงานทดแทนและเทคโนโลยีสะอาด</li>
                    <li>สร้างคุณค่าให้ผู้มีส่วนได้ส่วนเสียอย่างยั่งยืน</li>
                </ul>

                <h2>ประวัติบริษัท</h2>
                <p>พีทีเพโทร เอนเนอร์จี ก่อตั้งขึ้นในปี พ.ศ. 2530 ด้วยทุนจดทะเบียน 100 ล้านบาท เริ่มต้นจากการเป็นผู้จัดจำหน่ายน้ำมันหล่อลื่นในประเทศไทย ปัจจุบันเติบโตเป็นบริษัทพลังงานครบวงจร มีสถานีบริการกว่า 2,500 แห่งทั่วประเทศ</p>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">2,500+</div>
                        <div class="stat-label">สถานีบริการ</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">15,000+</div>
                        <div class="stat-label">พนักงาน</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">37</div>
                        <div class="stat-label">ปีแห่งความสำเร็จ</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">77</div>
                        <div class="stat-label">จังหวัดทั่วไทย</div>
                    </div>
                </div>
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
.content-main {
    max-width: 800px;
    margin: 0 auto;
}
.content-main h2 {
    color: var(--primary-green);
    margin-top: 2rem;
    margin-bottom: 1rem;
}
.content-main ul {
    padding-left: 1.5rem;
    margin-bottom: 1.5rem;
}
.content-main li {
    margin-bottom: 0.5rem;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}
.stat-card {
    background: var(--background-light);
    padding: 1.5rem;
    border-radius: 8px;
    text-align: center;
}
.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-green);
}
.stat-label {
    color: var(--text-muted);
    margin-top: 0.25rem;
}
</style>

<?php require_once 'includes/footer.php'; ?>
