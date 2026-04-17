# HACKDAY LAB - PTPetho CTF Challenge

<p align="center">
  <img src="docs/assets/logo-placeholder.png" alt="PTPetho Logo" width="200">
</p>

<p align="center">
  <strong>Vulnerable Web Application for Cybersecurity Education</strong><br>
  SQL Injection • XSS • Session Hijacking
</p>

---

## Overview

PTPetho is a deliberately vulnerable web application designed for teaching web security concepts to students aged 11-18. Students play as a pentest team uncovering hidden fuel cost data from a fictional Thai energy company.

**Challenges:** 10 | **Flags:** 5 | **Duration:** 2-2.5 hours

---

## Quick Start

### Prerequisites

- Docker & Docker Compose
- Git

### Installation

```bash
# Clone the repository
git clone https://github.com/YOUR_USERNAME/HACKDAY-LAB.git
cd HACKDAY-LAB

# Copy environment file
cp .env.example .env

# Start containers
docker-compose up -d

# Wait for MySQL to initialize (first run only)
sleep 30

# Access the application
open http://localhost
```

### URLs

| Service | URL | Description |
|---------|-----|-------------|
| Public Site | http://localhost | PTPetho homepage |
| Admin Portal | http://localhost/ptpetho-admin | Admin login |
| Cookie Logger | http://localhost:8000 | For XSS demo |

---

## Challenge Overview

```
[RECON] ────────────────────────────────────────────────────►
   Challenge 1: View Source
   Challenge 2: Client Manipulation
   Challenge 3: Network Tab
   Challenge 4: Header Spoofing        → FLAG 1

[SQLi] ─────────────────────────────────────────────────────►
   Challenge 5: Error-Based Discovery
   Challenge 6: Union-Based Extraction → FLAG 2
   Challenge 7: Filter Bypass          → FLAG 3

[XSS + HIJACK] ─────────────────────────────────────────────►
   Challenge 8: Stored XSS Discovery
   Challenge 9: Cookie Stealing        → FLAG 4
   Challenge 10: Session Hijacking     → FLAG 5
```

---

## For Instructors

### Credentials Reference

| Username | Password | Role | Notes |
|----------|----------|------|-------|
| admin | admin | Admin | Basic admin |
| director.kim | ptpetho2026 | Superadmin | Target for SQLi |
| ceo.somchai | password | CEO | Has access to secrets |

### Flags

```
FLAG 1: FLAG{h34d3r_trust_1ssu3}
FLAG 2: FLAG{uni0n_b4s3d_extr4ct10n}
FLAG 3: FLAG{f1lt3r_byp4ss_succ3ss}
FLAG 4: FLAG{st0r3d_xss_c00k13_th3ft}
FLAG 5: FLAG{s3ss10n_h1j4ck_truth_r3v34l3d}
```

### Reset Database

```bash
docker-compose down -v
docker-compose up -d
```

---

## Development

### Project Structure

```
HACKDAY-LAB/
├── docker-compose.yml
├── Dockerfile
├── src/                    # Application code
│   ├── index.php
│   ├── ptpetho-admin/
│   ├── assets/
│   └── includes/
├── database/
│   └── init.sql
└── docs/
```

### Commands

```bash
# Start
docker-compose up -d

# View logs
docker-compose logs -f

# Rebuild
docker-compose up -d --build

# Stop
docker-compose down

# MySQL CLI
docker-compose exec db mysql -u ptpetho -p
```

---

## Security Warning

This application contains **INTENTIONAL SECURITY VULNERABILITIES**.

- DO NOT deploy on public networks
- DO NOT use real data
- Run in isolated environment only
- For educational purposes only

---

## License

Educational use only. Created for Summer Camp cybersecurity training.

---

## Credits

- Story & Challenges: Summer Camp 5 Team
- Development: Claude AI Assistant
