<?php
/**
 * PTPetho - Public Homepage
 * Challenge 1: HTML comments expose sensitive information
 */

$pageTitle = 'หน้าแรก';
$currentPage = 'home';

require_once __DIR__ . '/includes/header.php';
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>พลังงานเพื่อ<span>อนาคต</span>ที่ยั่งยืน</h1>
                <p>บริษัท พีทีเพโทร เอนเนอร์จี จำกัด (มหาชน) มุ่งมั่นพัฒนาพลังงานสะอาดและยั่งยืน เพื่อคุณภาพชีวิตที่ดีของคนไทย</p>
                <div style="display: flex; gap: 1rem;">
                    <a href="/services.php" class="btn btn-primary btn-lg">บริการของเรา</a>
                    <a href="/about.php" class="btn btn-secondary btn-lg">เกี่ยวกับเรา</a>
                </div>
            </div>
        </div>

        <!-- Hidden form for upgrade tier - Challenge 1 hint -->
        <form id="client-info" style="display:none;">
            <input type="hidden" name="client_tier" value="free">
            <input type="hidden" name="api_version" value="v2.1">
        </form>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>2,500+</h3>
                    <p>สถานีบริการทั่วประเทศ</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>ปีแห่งความไว้วางใจ</p>
                </div>
                <div class="stat-item">
                    <h3>10M+</h3>
                    <p>ลูกค้าต่อเดือน</p>
                </div>
                <div class="stat-item">
                    <h3>15,000+</h3>
                    <p>พนักงานทั่วประเทศ</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-4">
                <h2>บริการของเรา</h2>
                <p class="text-muted">ครบครันทุกความต้องการด้านพลังงาน</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3>สถานีบริการน้ำมัน</h3>
                    <p>เครือข่ายสถานีบริการน้ำมันคุณภาพสูงกว่า 2,500 แห่งทั่วประเทศ พร้อมบริการครบวงจร</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3>โรงกลั่นน้ำมัน</h3>
                    <p>โรงกลั่นน้ำมันมาตรฐานสากล กำลังการผลิต 300,000 บาร์เรลต่อวัน</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h3>พลังงานสะอาด</h3>
                    <p>ลงทุนพัฒนาพลังงานทดแทน ทั้งโซลาร์เซลล์ พลังงานลม และ EV Charging</p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="section section-alt">
        <div class="container">
            <div class="text-center mb-4">
                <h2>ข่าวสารล่าสุด</h2>
                <p class="text-muted">ติดตามความเคลื่อนไหวของ PTPetho</p>
            </div>

            <div class="news-grid">
                <article class="news-card">
                    <div class="news-img"></div>
                    <div class="news-body">
                        <span class="news-date">20 มี.ค. 2569</span>
                        <h3 class="news-title"><a href="#">PTPetho ประกาศผลประกอบการไตรมาส 1/2569</a></h3>
                        <p class="card-text">บริษัทประกาศผลประกอบการไตรมาส 1 ด้วยรายได้รวม 125,000 ล้านบาท...</p>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-img"></div>
                    <div class="news-body">
                        <span class="news-date">15 มี.ค. 2569</span>
                        <h3 class="news-title"><a href="#">เปิดตัว "PTPetho Life Station" สถานีบริการรูปแบบใหม่</a></h3>
                        <p class="card-text">สถานีบริการครบวงจรที่รวมน้ำมัน คาเฟ่ ร้านสะดวกซื้อ และจุดชาร์จ EV...</p>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-img"></div>
                    <div class="news-body">
                        <span class="news-date">1 มี.ค. 2569</span>
                        <h3 class="news-title"><a href="#">รับรางวัลองค์กรดีเด่นด้านสิ่งแวดล้อม</a></h3>
                        <p class="card-text">PTPetho ได้รับรางวัลจากกระทรวงทรัพยากรธรรมชาติและสิ่งแวดล้อม...</p>
                    </div>
                </article>
            </div>

            <div class="text-center mt-4">
                <a href="/news.php" class="btn btn-outline">ดูข่าวทั้งหมด</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%); color: white;">
        <div class="container text-center">
            <h2 style="color: white;">ร่วมเป็นส่วนหนึ่งกับเรา</h2>
            <p style="max-width: 600px; margin: 0 auto 2rem; opacity: 0.9;">
                PTPetho เปิดรับสมัครบุคลากรที่มีความสามารถ เพื่อร่วมพัฒนาพลังงานแห่งอนาคต
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="/careers.php" class="btn btn-primary btn-lg">ดูตำแหน่งงาน</a>
                <a href="/upgrade.php" class="btn btn-secondary btn-lg">อัพเกรดบัญชี</a>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
