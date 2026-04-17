<?php
$pageTitle = 'บริการของเรา';
$currentPage = 'services';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <h1>บริการของเรา</h1>
        <p>ผลิตภัณฑ์และบริการด้านพลังงานครบวงจร</p>
    </div>
</section>

<!-- Services Content -->
<section class="section">
    <div class="container">
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">⛽</div>
                <h3>สถานีบริการน้ำมัน</h3>
                <p>เครือข่ายสถานีบริการน้ำมันกว่า 2,500 แห่งทั่วประเทศ พร้อมบริการมาตรฐานสากล</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🔥</div>
                <h3>ก๊าซธรรมชาติ NGV</h3>
                <p>สถานีบริการก๊าซธรรมชาติสำหรับยานยนต์ ราคาประหยัด เป็นมิตรต่อสิ่งแวดล้อม</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🛢️</div>
                <h3>น้ำมันหล่อลื่น</h3>
                <p>น้ำมันหล่อลื่นคุณภาพสูงสำหรับยานยนต์และอุตสาหกรรม ได้มาตรฐาน API</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🏭</div>
                <h3>โรงกลั่นน้ำมัน</h3>
                <p>โรงกลั่นน้ำมันกำลังการผลิต 150,000 บาร์เรลต่อวัน ตั้งอยู่ที่จังหวัดระยอง</p>
            </div>
            <div class="service-card">
                <div class="service-icon">☀️</div>
                <h3>พลังงานทดแทน</h3>
                <p>โครงการผลิตไฟฟ้าจากพลังงานแสงอาทิตย์และพลังงานลม กำลังผลิตรวม 500 MW</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🔋</div>
                <h3>สถานีชาร์จ EV</h3>
                <p>สถานีชาร์จรถยนต์ไฟฟ้าความเร็วสูง พร้อมให้บริการ 24 ชั่วโมง</p>
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
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}
.service-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}
.service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.service-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}
.service-card h3 {
    color: var(--primary-green);
    margin-bottom: 0.75rem;
}
.service-card p {
    color: var(--text-muted);
    font-size: 0.95rem;
}
</style>

<?php require_once 'includes/footer.php'; ?>
