<?php
$pageTitle = 'ข่าวสาร';
$currentPage = 'news';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <h1>ข่าวสารและกิจกรรม</h1>
        <p>ติดตามความเคลื่อนไหวล่าสุดจาก PTPetho</p>
    </div>
</section>

<!-- News Content -->
<section class="section">
    <div class="container">
        <div class="news-grid">
            <article class="news-card">
                <div class="news-date">18 มี.ค. 2569</div>
                <h3>PTPetho ประกาศปรับโครงสร้างราคาน้ำมันใหม่</h3>
                <p>บริษัทประกาศปรับโครงสร้างราคาน้ำมันเพื่อสะท้อนต้นทุนที่แท้จริง โดยจะมีผลบังคับใช้ตั้งแต่วันที่ 1 เมษายน 2569</p>
                <a href="#" class="news-link">อ่านต่อ →</a>
            </article>
            <article class="news-card">
                <div class="news-date">15 มี.ค. 2569</div>
                <h3>เปิดตัวสถานีชาร์จ EV แห่งใหม่ 50 สาขา</h3>
                <p>PTPetho ขยายเครือข่ายสถานีชาร์จรถยนต์ไฟฟ้าอีก 50 แห่ง รองรับการเติบโตของตลาด EV ในประเทศไทย</p>
                <a href="#" class="news-link">อ่านต่อ →</a>
            </article>
            <article class="news-card">
                <div class="news-date">10 มี.ค. 2569</div>
                <h3>รายงานผลประกอบการไตรมาส 4/2568</h3>
                <p>บริษัทรายงานผลประกอบการไตรมาส 4 ปี 2568 กำไรสุทธิ 12,500 ล้านบาท เพิ่มขึ้น 15% จากปีก่อน</p>
                <a href="#" class="news-link">อ่านต่อ →</a>
            </article>
            <article class="news-card">
                <div class="news-date">1 มี.ค. 2569</div>
                <h3>โครงการ CSR "พลังงานเพื่อชุมชน"</h3>
                <p>PTPetho ส่งมอบระบบผลิตไฟฟ้าจากพลังงานแสงอาทิตย์ให้โรงเรียนในถิ่นทุรกันดาร 100 แห่ง</p>
                <a href="#" class="news-link">อ่านต่อ →</a>
            </article>
            <article class="news-card">
                <div class="news-date">20 ก.พ. 2569</div>
                <h3>ลงนาม MOU พัฒนาพลังงานไฮโดรเจน</h3>
                <p>ร่วมมือกับพันธมิตรจากญี่ปุ่นพัฒนาเทคโนโลยีพลังงานไฮโดรเจนสีเขียวในประเทศไทย</p>
                <a href="#" class="news-link">อ่านต่อ →</a>
            </article>
            <article class="news-card">
                <div class="news-date">14 ก.พ. 2569</div>
                <h3>PTPetho ได้รับรางวัล SET Sustainability Awards</h3>
                <p>รางวัลองค์กรต้นแบบด้านความยั่งยืนจากตลาดหลักทรัพย์แห่งประเทศไทยประจำปี 2568</p>
                <a href="#" class="news-link">อ่านต่อ →</a>
            </article>
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
.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}
.news-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    transition: transform 0.3s, box-shadow 0.3s;
}
.news-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.news-date {
    font-size: 0.85rem;
    color: var(--accent-gold);
    font-weight: 600;
    margin-bottom: 0.5rem;
}
.news-card h3 {
    color: var(--text-dark);
    margin-bottom: 0.75rem;
    font-size: 1.1rem;
}
.news-card p {
    color: var(--text-muted);
    font-size: 0.95rem;
    margin-bottom: 1rem;
}
.news-link {
    color: var(--primary-green);
    font-weight: 500;
    text-decoration: none;
}
.news-link:hover {
    text-decoration: underline;
}
</style>

<?php require_once 'includes/footer.php'; ?>
