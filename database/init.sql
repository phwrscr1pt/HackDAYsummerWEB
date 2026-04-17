-- =====================================================
-- PTPetho CTF - Database Initialization
-- Version: 1.0.0
-- =====================================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Use the database
USE ptpetho_internal;

-- =====================================================
-- TABLE: users (Login System)
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100),
    role ENUM('user', 'admin', 'superadmin', 'ceo') DEFAULT 'user',
    department VARCHAR(100),
    avatar VARCHAR(255) DEFAULT 'default.png',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: ptpetho_staff (Staff Directory - for SQLi)
-- =====================================================
CREATE TABLE IF NOT EXISTS ptpetho_staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50),
    password_hash VARCHAR(255),
    email VARCHAR(100),
    role VARCHAR(50),
    department VARCHAR(100),
    position VARCHAR(100),
    salary DECIMAL(12,2),
    hire_date DATE,
    phone VARCHAR(20),
    office_location VARCHAR(100),
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_role (role),
    INDEX idx_department (department)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: admin_feedback (Feedback System - for XSS)
-- =====================================================
CREATE TABLE IF NOT EXISTS admin_feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    sender_name VARCHAR(100),
    sender_role VARCHAR(50),
    subject VARCHAR(200),
    message TEXT,
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    is_read BOOLEAN DEFAULT FALSE,
    read_by VARCHAR(50) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL,
    INDEX idx_is_read (is_read),
    INDEX idx_priority (priority)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: fuel_cost_analysis (Secret Data - Final Flag)
-- =====================================================
CREATE TABLE IF NOT EXISTS fuel_cost_analysis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quarter VARCHAR(10) NOT NULL,
    year INT NOT NULL,
    fuel_type VARCHAR(50) DEFAULT 'Diesel',
    public_margin DECIMAL(5,2) NOT NULL COMMENT 'What we tell public (THB/liter)',
    actual_margin DECIMAL(5,2) NOT NULL COMMENT 'Real cost (THB/liter)',
    hidden_profit DECIMAL(5,2) NOT NULL COMMENT 'Difference (THB/liter)',
    total_volume_liters BIGINT COMMENT 'Total liters sold',
    total_hidden_profit DECIMAL(15,2) COMMENT 'Total hidden profit (THB)',
    approved_by VARCHAR(100),
    approval_date DATE,
    notes TEXT,
    classification ENUM('public', 'internal', 'confidential', 'top_secret') DEFAULT 'confidential',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_quarter_year (quarter, year),
    INDEX idx_classification (classification)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: audit_log (Activity Logging)
-- =====================================================
CREATE TABLE IF NOT EXISTS audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(100) NOT NULL,
    user_id INT NULL,
    username VARCHAR(50),
    ip_address VARCHAR(45),
    user_agent TEXT,
    request_uri VARCHAR(500),
    details TEXT,
    severity ENUM('info', 'warning', 'error', 'critical') DEFAULT 'info',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_action (action),
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: client_tiers (User Tiers - Challenge 2)
-- =====================================================
CREATE TABLE IF NOT EXISTS client_tiers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    tier ENUM('free', 'basic', 'premium', 'enterprise') DEFAULT 'free',
    price_paid DECIMAL(10,2) DEFAULT 0,
    features TEXT,
    upgraded_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_tier (tier)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: sessions (Session Management)
-- =====================================================
CREATE TABLE IF NOT EXISTS user_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    INDEX idx_session_token (session_token),
    INDEX idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: news (Company News)
-- =====================================================
CREATE TABLE IF NOT EXISTS company_news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    title_en VARCHAR(255),
    slug VARCHAR(255) UNIQUE,
    excerpt TEXT,
    content LONGTEXT,
    image VARCHAR(255),
    category VARCHAR(50),
    is_published BOOLEAN DEFAULT TRUE,
    views INT DEFAULT 0,
    author_id INT,
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_published (is_published)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERT: Users (Login Accounts)
-- =====================================================
-- Password Reference:
-- admin = admin (MD5: 21232f297a57a5a743894a0e4a801fc3)
-- director.kim = ptpetho2026 (MD5: 3fc0a7acf087f549ac2b266baf94b8b1)
-- ceo.somchai = password (MD5: 5f4dcc3b5aa765d61d8327deb882cf99)
-- user1 = user (MD5: ee11cbb19052e40b07aac0ca060c23ee)

INSERT INTO users (username, password_hash, email, full_name, role, department) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@ptpetho.local', 'System Administrator', 'admin', 'IT'),
('director.kim', '3fc0a7acf087f549ac2b266baf94b8b1', 'director.kim@ptpetho.local', 'Kim Srisawat', 'superadmin', 'Management'),
('ceo.somchai', '5f4dcc3b5aa765d61d8327deb882cf99', 'ceo@ptpetho.local', 'Somchai Rattanakul', 'ceo', 'Executive'),
('user.test', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@ptpetho.local', 'Test User', 'user', 'General'),
('qa.tester', '098f6bcd4621d373cade4e832627b4f6', 'qa@ptpetho.local', 'QA Tester', 'user', 'Quality Assurance');

-- =====================================================
-- INSERT: Staff Directory (for SQLi Search)
-- =====================================================
INSERT INTO ptpetho_staff (employee_id, name, username, password_hash, email, role, department, position, salary, hire_date, phone, office_location) VALUES
('PTP001', 'Somchai Rattanakul', 'ceo.somchai', '5f4dcc3b5aa765d61d8327deb882cf99', 'ceo@ptpetho.local', 'ceo', 'Executive', 'Chief Executive Officer', 2500000.00, '2010-01-15', '081-234-5678', 'HQ Floor 30'),
('PTP002', 'Kim Srisawat', 'director.kim', '3fc0a7acf087f549ac2b266baf94b8b1', 'director.kim@ptpetho.local', 'superadmin', 'Management', 'Director of Operations', 850000.00, '2015-03-20', '082-345-6789', 'HQ Floor 28'),
('PTP003', 'Somying Charoenpol', 'somying.c', 'e10adc3949ba59abbe56e057f20f883e', 'somying@ptpetho.local', 'admin', 'Finance', 'Finance Manager', 120000.00, '2018-06-01', '083-456-7890', 'HQ Floor 15'),
('PTP004', 'Prasert Wongkam', 'prasert.w', 'e10adc3949ba59abbe56e057f20f883e', 'prasert@ptpetho.local', 'user', 'Operations', 'Operations Supervisor', 65000.00, '2020-02-15', '084-567-8901', 'Refinery A'),
('PTP005', 'Naree Suksan', 'naree.s', 'e10adc3949ba59abbe56e057f20f883e', 'naree@ptpetho.local', 'user', 'HR', 'HR Specialist', 55000.00, '2021-08-10', '085-678-9012', 'HQ Floor 10'),
('PTP006', 'Wichai Thongdee', 'wichai.t', 'e10adc3949ba59abbe56e057f20f883e', 'wichai@ptpetho.local', 'admin', 'IT', 'System Administrator', 75000.00, '2019-11-25', '086-789-0123', 'HQ Floor 5'),
('PTP007', 'Apinya Somboon', 'apinya.s', 'e10adc3949ba59abbe56e057f20f883e', 'apinya@ptpetho.local', 'user', 'Marketing', 'Marketing Executive', 60000.00, '2022-01-05', '087-890-1234', 'HQ Floor 12'),
('PTP008', 'Thanawat Pholsri', 'thanawat.p', 'e10adc3949ba59abbe56e057f20f883e', 'thanawat@ptpetho.local', 'user', 'Sales', 'Sales Representative', 58000.00, '2022-04-18', '088-901-2345', 'Branch Bangkok'),
('PTP009', 'Kittisak Laosri', 'kittisak.l', 'e10adc3949ba59abbe56e057f20f883e', 'kittisak@ptpetho.local', 'user', 'Engineering', 'Senior Engineer', 85000.00, '2017-09-01', '089-012-3456', 'Refinery B'),
('PTP010', 'Pornthip Saelee', 'pornthip.s', 'e10adc3949ba59abbe56e057f20f883e', 'pornthip@ptpetho.local', 'user', 'Legal', 'Legal Counsel', 95000.00, '2019-03-15', '090-123-4567', 'HQ Floor 20');

-- =====================================================
-- INSERT: Fuel Cost Analysis (THE SECRET DATA!)
-- =====================================================
INSERT INTO fuel_cost_analysis (quarter, year, fuel_type, public_margin, actual_margin, hidden_profit, total_volume_liters, total_hidden_profit, approved_by, approval_date, notes, classification) VALUES
('Q1', 2569, 'Diesel', 13.00, 4.20, 8.80, 850000000, 7480000000.00, 'CEO Somchai Rattanakul', '2569-03-15', 'Approved for public statement. Actual margins classified TOP SECRET. Media inquiries to be deflected.', 'top_secret'),
('Q4', 2568, 'Diesel', 11.50, 3.80, 7.70, 920000000, 7084000000.00, 'CEO Somchai Rattanakul', '2568-12-20', 'Year-end adjustment. Increased margins approved by board.', 'top_secret'),
('Q3', 2568, 'Diesel', 10.20, 4.10, 6.10, 780000000, 4758000000.00, 'CEO Somchai Rattanakul', '2568-09-15', 'Standard quarterly margin. Within acceptable range.', 'confidential'),
('Q2', 2568, 'Diesel', 9.80, 3.90, 5.90, 810000000, 4779000000.00, 'CEO Somchai Rattanakul', '2568-06-18', 'Summer demand surge pricing applied.', 'confidential'),
('Q1', 2568, 'Diesel', 8.50, 3.50, 5.00, 750000000, 3750000000.00, 'CEO Somchai Rattanakul', '2568-03-20', 'Post-COVID recovery pricing.', 'confidential'),
('Q1', 2569, 'Benzine 95', 15.20, 5.80, 9.40, 420000000, 3948000000.00, 'CEO Somchai Rattanakul', '2569-03-15', 'Premium fuel higher margin approved.', 'top_secret'),
('Q1', 2569, 'Gasohol E20', 11.80, 4.50, 7.30, 380000000, 2774000000.00, 'CEO Somchai Rattanakul', '2569-03-15', 'Ethanol blend standard margin.', 'confidential');

-- =====================================================
-- INSERT: Feedback Messages (Some with XSS for demo)
-- =====================================================
INSERT INTO admin_feedback (sender_id, sender_name, sender_role, subject, message, priority, is_read, created_at) VALUES
(3, 'Somying Charoenpol', 'Finance Manager', 'Monthly Financial Report Discrepancy', 'Dear Management,\n\nI found some discrepancies in the Q1 financial report. The refinery margin calculations seem inconsistent with our internal records. Please review at your earliest convenience.\n\nBest regards,\nSomying', 'high', TRUE, '2569-03-10 09:30:00'),
(4, 'Prasert Wongkam', 'Operations Supervisor', 'Equipment Maintenance Request', 'We need urgent maintenance for Pump Station 3 at Refinery A. The pressure readings have been unstable for the past week.\n\nPlease approve the maintenance budget.', 'urgent', TRUE, '2569-03-12 14:22:00'),
(5, 'Naree Suksan', 'HR Specialist', 'New Employee Onboarding Schedule', 'Dear Director,\n\nPlease review the onboarding schedule for 5 new employees starting next month. All documents are prepared and ready for your approval.\n\nRegards,\nNaree', 'medium', FALSE, '2569-03-14 11:45:00'),
(6, 'Wichai Thongdee', 'System Administrator', 'Security Audit Findings', 'INTERNAL ONLY\n\nCompleted the quarterly security audit. Found some minor issues with the admin portal authentication. Will prepare detailed report by Friday.\n\nNote: Please do not share this externally.', 'high', FALSE, '2569-03-15 16:00:00'),
(7, 'Apinya Somboon', 'Marketing Executive', 'Press Release Draft - Fuel Price', 'Attached is the draft press release regarding the fuel price adjustment. Please review the wording about refinery margins before we send to media outlets.\n\nWaiting for CEO approval.', 'medium', FALSE, '2569-03-16 10:15:00');

-- =====================================================
-- INSERT: Company News
-- =====================================================
INSERT INTO company_news (title, title_en, slug, excerpt, content, category, is_published, published_at) VALUES
('PTPetho ประกาศผลประกอบการไตรมาส 1/2569', 'PTPetho Announces Q1/2569 Results', 'q1-2569-results', 'บริษัท พีทีเพโทร จำกัด (มหาชน) ประกาศผลประกอบการไตรมาส 1 ปี 2569 ด้วยรายได้รวม 125,000 ล้านบาท', '<p>บริษัท พีทีเพโทร จำกัด (มหาชน) ประกาศผลประกอบการไตรมาส 1 ปี 2569 ด้วยรายได้รวม 125,000 ล้านบาท เติบโต 15% จากช่วงเดียวกันของปีก่อน</p><p>นายสมชาย รัตนกุล ประธานเจ้าหน้าที่บริหาร กล่าวว่า "ผลประกอบการที่แข็งแกร่งนี้สะท้อนถึงความมุ่งมั่นของเราในการให้บริการลูกค้าอย่างดีที่สุด"</p>', 'financial', TRUE, '2569-03-20 09:00:00'),
('เปิดตัวสถานีบริการน้ำมันรูปแบบใหม่', 'Launch of New Service Station Concept', 'new-station-concept', 'PTPetho เปิดตัวสถานีบริการน้ำมันรูปแบบใหม่ "PTPetho Life Station" ที่รวมทุกบริการไว้ในที่เดียว', '<p>PTPetho เปิดตัวสถานีบริการน้ำมันรูปแบบใหม่ภายใต้ชื่อ "PTPetho Life Station" ซึ่งรวมบริการเติมน้ำมัน ร้านสะดวกซื้อ คาเฟ่ และจุดชาร์จรถยนต์ไฟฟ้าไว้ในที่เดียว</p>', 'business', TRUE, '2569-03-15 10:00:00'),
('PTPetho รับรางวัลองค์กรดีเด่นด้านสิ่งแวดล้อม', 'PTPetho Receives Environmental Excellence Award', 'environmental-award', 'PTPetho ได้รับรางวัลองค์กรดีเด่นด้านสิ่งแวดล้อมประจำปี 2568 จากกระทรวงทรัพยากรธรรมชาติและสิ่งแวดล้อม', '<p>บริษัท พีทีเพโทร จำกัด (มหาชน) ได้รับเกียรติรับรางวัลองค์กรดีเด่นด้านสิ่งแวดล้อมประจำปี 2568 จากการดำเนินนโยบายลดการปล่อยก๊าซเรือนกระจก</p>', 'csr', TRUE, '2569-03-01 14:00:00');

-- =====================================================
-- INSERT: Audit Log Sample
-- =====================================================
INSERT INTO audit_log (action, username, ip_address, details, severity) VALUES
('LOGIN_SUCCESS', 'admin', '192.168.1.100', 'Successful login from admin workstation', 'info'),
('LOGIN_SUCCESS', 'director.kim', '192.168.1.105', 'Successful login', 'info'),
('PAGE_ACCESS', 'director.kim', '192.168.1.105', 'Accessed staff directory', 'info'),
('DATA_EXPORT', 'director.kim', '192.168.1.105', 'Exported staff list to CSV', 'warning'),
('LOGIN_FAILED', 'unknown', '203.150.xxx.xxx', 'Failed login attempt - invalid credentials', 'warning');

-- =====================================================
-- CREATE VIEWS (for convenience)
-- =====================================================
CREATE OR REPLACE VIEW v_active_staff AS
SELECT employee_id, name, email, department, position, status
FROM ptpetho_staff
WHERE status = 'active';

CREATE OR REPLACE VIEW v_unread_feedback AS
SELECT id, sender_name, subject, priority, created_at
FROM admin_feedback
WHERE is_read = FALSE
ORDER BY
    CASE priority
        WHEN 'urgent' THEN 1
        WHEN 'high' THEN 2
        WHEN 'medium' THEN 3
        ELSE 4
    END,
    created_at DESC;

-- =====================================================
-- END OF INITIALIZATION
-- =====================================================
