# 🎊 PRD — WOApp: Wedding Organizer SaaS Platform

> **Product Requirements Document (PRD) untuk aplikasi SaaS Wedding Organizer.**
> Versi: 1.1 | Tanggal: 2 Juli 2026 | Status: **Finalized**

---

## 1. Product Overview

### 1.1 Visi Produk
WOApp adalah platform SaaS (Software as a Service) yang memungkinkan **Wedding Organizer (WO)** mengelola seluruh aspek bisnis pernikahan secara digital — mulai dari promosi paket, manajemen vendor, pengelolaan klien, scheduling, hingga budget tracking. Platform ini juga memberi akses kepada **klien** untuk memantau progress persiapan wedding mereka secara real-time.

### 1.2 Problem Statement
| Masalah | Dampak |
|---------|--------|
| WO masih mengelola data secara manual (spreadsheet/WhatsApp) | Data tersebar, rawan hilang, sulit di-track |
| Klien tidak punya visibility terhadap progress wedding | Miskomunikasi, klien tidak puas |
| Tidak ada sistem budgeting yang terstruktur | Over-budget, pengeluaran tidak terlacak |
| Promosi paket wedding tidak terpusat | Sulit menjangkau calon klien baru |
| Koordinasi vendor sulit | Keterlambatan, miscommunication |

### 1.3 Target User

| Role | Deskripsi |
|------|-----------|
| **Super Admin** | Pengelola platform, melihat semua data WO & klien, mengelola subscription & billing |
| **Wedding Organizer (WO)** | Pemilik/tim WO yang register ke platform untuk mengelola bisnis wedding |
| **Client** | Pasangan yang akan menikah, akun dibuat oleh WO, bisa melihat schedule & budget tracker |

---

## 2. User Roles & Permissions

### 2.1 Super Admin
```
✅ Dashboard analytics seluruh platform
✅ Manage semua WO (approve, suspend, delete)
✅ Lihat semua data (WO, Client, Transaksi)
✅ Manage subscription plans & billing
✅ Manage master data (kategori vendor, template paket, dll)
✅ System settings & configuration
✅ Laporan revenue platform
✅ Manage konten landing page
```

### 2.2 Wedding Organizer (WO)
```
✅ Register & Login sebagai WO
✅ Setup profil bisnis WO (nama, logo, deskripsi, kontak, dll)
✅ CRUD Paket Wedding (untuk halaman promosi)
✅ Manage Vendor (CRUD vendor, kategori, kontrak, rating)
✅ Manage Client (CRUD client, assign ke project wedding)
✅ Manage Wedding Project (per client)
✅ Budget Planning & Tracker (per project)
✅ Schedule / Timeline Management (per project)
✅ Manage Tenant/Venue
✅ Manage Team Member WO
✅ Checklist & Task Management
✅ Guest List Management
✅ Rundown Acara
✅ Invoice & Payment Tracking
✅ Halaman Promosi Publik (landing page WO)
✅ Dashboard & Reporting
```

### 2.3 Client
```
✅ Login dengan akun yang dibuat WO
✅ View Dashboard progress wedding
✅ View Schedule / Timeline
✅ View & Track Budget (budget tracker)
✅ View Vendor yang sudah dipilih
✅ View Checklist progress
✅ View Rundown acara
✅ View Guest List
✅ Approve/Request perubahan via notes/comments
✅ Upload dokumen (inspirasi, referensi)
✅ Notifikasi & Reminder
```

---

## 3. Feature Specification

### 3.1 Authentication & Multi-Tenancy

| Feature | Detail |
|---------|--------|
| Registration WO | Form registrasi WO dengan verifikasi email |
| Login System | Email/password, multi-role (Super Admin, WO, Client) |
| Multi-Tenancy | Setiap WO punya data terisolasi (tenant-based) |
| WO Onboarding | Wizard setup profil WO setelah registrasi |
| Client Account Creation | WO bisa membuat akun untuk client-nya |
| Forgot Password | Reset password via email |

---

### 3.2 Super Admin Panel

#### 3.2.1 Dashboard Analytics
- Total WO terdaftar (aktif/non-aktif)
- Total Client di seluruh platform
- Total Wedding Project (ongoing/completed)
- Revenue platform (dari subscription)
- Grafik pertumbuhan user

#### 3.2.2 WO Management
- List semua WO dengan filter & search
- Detail profil WO
- Approve/Reject registrasi WO
- Suspend/Activate WO
- Lihat statistik per WO

#### 3.2.3 Subscription & Billing
- Manage paket langganan (Free, Basic, Pro, Enterprise)
- Lihat history pembayaran
- Invoice management

#### 3.2.4 Master Data
- Kategori Vendor (Catering, Dekorasi, MUA, Fotografi, dll)
- Template Paket Wedding
- Template Timeline/Milestone
- Pengaturan sistem

---

### 3.3 WO Panel

#### 3.3.1 Dashboard WO
- Overview project aktif
- Upcoming schedule/deadline
- Budget summary (seluruh project)
- Recent activities
- Quick actions

#### 3.3.2 Halaman Promosi / Landing Page WO
- **Profil WO**: Nama, logo, tagline, deskripsi, portofolio
- **Paket Wedding**:
  - Nama paket (Silver, Gold, Platinum, Custom, dll)
  - Deskripsi paket
  - Daftar item/layanan yang termasuk
  - Harga / range harga
  - Gambar/foto
  - Status (aktif/non-aktif)
- **Galeri Portofolio**: Foto-foto wedding sebelumnya
- **Testimoni Client**
- **Kontak & CTA**: WhatsApp, form inquiry
- URL publik: `woapp.com/wo/{slug}`

#### 3.3.3 Vendor Management
- CRUD Vendor
  - Nama, kategori, kontak, alamat
  - Range harga / price list
  - Rating & review
  - Dokumen kontrak
  - Status kerjasama (aktif/non-aktif)
- Kategori Vendor: Venue, Catering, Dekorasi, MUA, Fotografi/Videografi, Entertainment, MC, Busana, Undangan, Souvenir, dll
- Vendor Favorit
- Assign vendor ke project wedding

#### 3.3.4 Client Management
- CRUD Client
  - Data mempelai (pria & wanita)
  - Kontak, alamat
  - Tanggal wedding
  - Paket yang dipilih
- Buat akun login untuk client
- History project per client

#### 3.3.5 Wedding Project Management
- Setiap client = 1 project wedding
- Project berisi:
  - Info dasar (nama event, tanggal, venue)
  - Paket yang dipilih
  - Timeline/Schedule
  - Budget Plan
  - Vendor terpilih
  - Checklist/Task
  - Guest List
  - Rundown
  - Notes/Dokumen

#### 3.3.6 Budget Planning & Tracker

> **⚠️ PENTING:** Ini adalah fitur inti yang membedakan WOApp dari kompetitor.

- **Budget Plan** (per project):
  - Total budget dari client
  - Alokasi per kategori (venue, catering, dekorasi, dll)
  - Estimasi vs Aktual
- **Budget Tracker**:
  - Input pengeluaran (tanggal, kategori, vendor, jumlah, keterangan)
  - Status pembayaran (DP, lunas, belum bayar)
  - Upload bukti pembayaran
  - Persentase budget terpakai
  - Alert jika mendekati/melebihi budget
- **Laporan Budget**:
  - Summary per kategori
  - Grafik pie chart alokasi budget
  - Export PDF/Excel

#### 3.3.7 Schedule / Timeline Management
- Timeline otomatis berdasarkan tanggal wedding (H-12 bulan, H-10, dst)
- Milestone-based planning
- Setiap milestone punya tasks
- Task assignment (ke anggota tim WO)
- Status: Belum, Proses, Selesai
- Calendar view & list view
- Reminder/notifikasi deadline
- Template timeline yang bisa di-customize

> **📝 Catatan:** Referensi tahapan timeline sudah ada di dokumen `wedding_organizer_timeline_tahapan.md`

#### 3.3.8 Tenant / Venue Management
- CRUD Venue/Tenant
  - Nama, alamat, kapasitas
  - Fasilitas
  - Harga sewa
  - Foto
  - Kontak
  - Ketersediaan (availability calendar)
- Assign venue ke project

#### 3.3.9 Guest List Management
- CRUD tamu undangan
- Kategori tamu (keluarga mempelai pria, keluarga mempelai wanita, teman, kolega, dll)
- RSVP tracking (hadir/tidak hadir/belum konfirmasi)
- Jumlah tamu (dewasa, anak)
- Seat arrangement
- Export data tamu

#### 3.3.10 Rundown Acara
- CRUD item rundown
- Waktu mulai & selesai
- PIC (Person in Charge)
- Keterangan
- Urutan acara (drag & drop)
- Template rundown

#### 3.3.11 Team Management
- CRUD anggota tim WO
- Role dalam tim (Koordinator, Asisten, dll)
- Assign task ke anggota

#### 3.3.12 Invoice & Payment
- Generate invoice untuk client
- Track pembayaran dari client (DP, termin, pelunasan)
- Status pembayaran
- Reminder pembayaran

---

### 3.4 Client Panel

#### 3.4.1 Client Dashboard
- Countdown menuju hari-H
- Progress keseluruhan (%)
- Upcoming tasks/milestones
- Budget summary (terpakai vs sisa)
- Recent updates dari WO

#### 3.4.2 Schedule View
- Lihat timeline/milestone
- Lihat task dan status
- Calendar view
- Notifikasi deadline

#### 3.4.3 Budget Tracker View
- Lihat total budget
- Lihat pengeluaran per kategori
- Grafik budget usage
- Detail pembayaran

#### 3.4.4 Vendor View
- Lihat vendor yang sudah dipilih
- Info kontak vendor
- Status kontrak

#### 3.4.5 Guest List View
- Lihat daftar tamu
- RSVP status
- Total tamu

#### 3.4.6 Rundown View
- Lihat rundown acara
- Detail per sesi

#### 3.4.7 Notes & Communication
- Kirim notes/request ke WO
- Upload file referensi/inspirasi
- History komunikasi

---

## 4. Tech Stack (Final)

| Layer | Technology | Keterangan |
|-------|-----------|------------|
| **Framework** | Laravel 11 | Full-stack monolith |
| **Frontend JS** | Alpine.js | Lightweight reactive JS |
| **Template Engine** | Blade | Laravel built-in |
| **Styling** | Tailwind CSS / Bootstrap 5 | TBD saat development |
| **Database** | MySQL 8.0+ | Relational database |
| **Auth** | Laravel Breeze / Fortify | Built-in auth scaffolding |
| **File Storage** | Local Storage / S3 | Upload ke server lokal |
| **Hosting** | Self-hosted (VPS) | Server sendiri |
| **Web Server** | Nginx + PHP-FPM | Standard Laravel deployment |
| **Email** | SMTP (Gmail/Mailtrap) | Untuk notifikasi |
| **Payment** | Manual Transfer | Transfer bank manual, tanpa payment gateway |
| **Bahasa** | Bahasa Indonesia | Single language |

> **✅ Tech stack sudah difinalisasi.** Full-stack Laravel + Alpine.js, tanpa framework frontend terpisah.

---

## 5. Database Schema (High-Level ERD)

### Tabel Utama

#### USERS
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| name | string | |
| email | string | unique |
| password | string | hashed |
| role | enum | super_admin, wo, client |
| tenant_id | int | FK |
| is_active | boolean | |

#### WO_PROFILES
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| user_id | int | FK → users |
| business_name | string | |
| slug | string | unique, untuk URL publik |
| logo | string | |
| description | text | |
| phone | string | |
| address | text | |
| subscription_plan | enum | free, basic, pro, enterprise |

#### CLIENTS
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| wo_profile_id | int | FK → wo_profiles |
| user_id | int | FK → users |
| groom_name | string | |
| bride_name | string | |
| wedding_date | date | |
| phone | string | |
| package_id | int | FK → wedding_packages |

#### WEDDING_PROJECTS
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| client_id | int | FK → clients |
| wo_profile_id | int | FK → wo_profiles |
| name | string | |
| wedding_date | date | |
| venue_id | int | FK → venues |
| total_budget | decimal | |
| status | enum | planning, ongoing, completed, cancelled |

#### BUDGET_ITEMS
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| project_id | int | FK → wedding_projects |
| category | string | |
| vendor_id | int | FK → vendors (nullable) |
| description | string | |
| estimated_cost | decimal | |
| actual_cost | decimal | |
| payment_status | enum | unpaid, dp, paid |
| payment_proof | string | file path |

#### SCHEDULE_MILESTONES
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| project_id | int | FK → wedding_projects |
| title | string | |
| description | text | |
| due_date | date | |
| status | enum | pending, in_progress, done |
| order | int | sorting |

#### TASKS
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| milestone_id | int | FK → schedule_milestones |
| title | string | |
| assigned_to | int | FK → users (nullable) |
| status | enum | todo, in_progress, done |
| due_date | date | |

#### VENDORS
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| wo_profile_id | int | FK → wo_profiles |
| name | string | |
| category | enum | venue, catering, decoration, mua, photography, entertainment, mc, dress, invitation, souvenir, other |
| phone | string | |
| address | text | |
| price_range | string | |
| rating | decimal | |
| status | enum | active, inactive |

#### WEDDING_PACKAGES
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| wo_profile_id | int | FK → wo_profiles |
| name | string | |
| description | text | |
| price | decimal | |
| items | json | daftar item/layanan |
| images | json | foto-foto paket |
| is_active | boolean | |

#### GUEST_LIST
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| project_id | int | FK → wedding_projects |
| name | string | |
| category | string | keluarga_pria, keluarga_wanita, teman, kolega |
| rsvp_status | enum | pending, confirmed, declined |
| guest_count | int | jumlah orang |
| seat_number | string | |

#### RUNDOWN_ITEMS
| Column | Type | Note |
|--------|------|------|
| id | int | PK |
| project_id | int | FK → wedding_projects |
| time_start | time | |
| time_end | time | |
| activity | string | |
| pic | string | |
| notes | text | |
| order | int | sorting |

### Relasi Antar Tabel
```
USERS ──┬── WO_PROFILES ──┬── WEDDING_PACKAGES
        │                  ├── VENDORS
        │                  ├── CLIENTS ── WEDDING_PROJECTS ──┬── BUDGET_ITEMS
        │                  │                                  ├── SCHEDULE_MILESTONES ── TASKS
        │                  │                                  ├── GUEST_LIST
        │                  │                                  ├── RUNDOWN_ITEMS
        │                  │                                  └── PROJECT_VENDORS
        │                  └── TEAM_MEMBERS
        │
        └── CLIENT_PROFILES
```

---

## 6. Subscription Plans

| Feature | Free | Basic | Pro | Enterprise |
|---------|------|-------|-----|-----------|
| Max Project Aktif | 1 | 5 | 20 | Unlimited |
| Max Client | 2 | 10 | 50 | Unlimited |
| Max Vendor | 10 | 30 | 100 | Unlimited |
| Landing Page WO | ❌ | ✅ | ✅ | ✅ |
| Custom Domain | ❌ | ❌ | ✅ | ✅ |
| Export PDF/Excel | ❌ | ✅ | ✅ | ✅ |
| Team Members | 1 | 3 | 10 | Unlimited |
| Priority Support | ❌ | ❌ | ✅ | ✅ |
| White Label | ❌ | ❌ | ❌ | ✅ |

---

## 7. Alur Penggunaan (User Flow)

### 7.1 Alur WO
```
WO Register → Verifikasi Email → Onboarding Wizard → Setup Profil Bisnis → Dashboard WO
                                                                              ├── Buat Paket Wedding
                                                                              ├── Tambah Vendor
                                                                              └── Tambah Client
                                                                                    ├── Buat Project Wedding
                                                                                    │     ├── Set Budget Plan
                                                                                    │     ├── Set Timeline/Schedule
                                                                                    │     ├── Assign Vendor
                                                                                    │     ├── Buat Guest List
                                                                                    │     └── Buat Rundown
                                                                                    └── Buat Akun Client → Client Bisa Login
```

### 7.2 Alur Client
```
Terima Kredensial dari WO → Login → Client Dashboard
                                      ├── Lihat Countdown
                                      ├── Lihat Schedule
                                      ├── Lihat Budget Tracker
                                      ├── Lihat Vendor
                                      ├── Lihat Guest List
                                      ├── Lihat Rundown
                                      └── Kirim Notes ke WO
```

---

## 8. Wireframe Screens (Key Pages)

| Screen | Role | Priority |
|--------|------|----------|
| Landing Page Platform | Public | High |
| Register WO | WO | High |
| Login | All | High |
| Super Admin Dashboard | Super Admin | High |
| WO Management | Super Admin | High |
| WO Dashboard | WO | High |
| Paket Wedding (CRUD) | WO | High |
| Vendor Management | WO | High |
| Client Management | WO | High |
| Project Detail | WO | High |
| Budget Planner & Tracker | WO | High |
| Schedule/Timeline | WO | High |
| Guest List | WO | Medium |
| Rundown | WO | Medium |
| Client Dashboard | Client | High |
| Client Schedule View | Client | High |
| Client Budget View | Client | High |
| Public WO Landing Page | Public | Medium |

---

## 9. Non-Functional Requirements

| Aspek | Requirement |
|-------|-------------|
| **Performance** | Page load < 3 detik, API response < 500ms |
| **Security** | Multi-tenant data isolation, CSRF protection, XSS prevention |
| **Scalability** | Support 1000+ WO concurrent |
| **Availability** | 99.5% uptime |
| **Data Privacy** | Data client hanya bisa diakses WO terkait |
| **Mobile** | Responsive design, mobile-first |
| **Browser** | Chrome, Firefox, Safari, Edge (latest 2 versions) |

---

## 10. Success Metrics (KPI)

| Metric | Target (6 bulan) |
|--------|------------------|
| WO terdaftar | 100+ |
| Client aktif | 500+ |
| Wedding project completed | 200+ |
| User satisfaction (NPS) | > 8/10 |
| Conversion rate (free → paid) | > 15% |
| Monthly churn rate | < 5% |

---

## 11. Keputusan Teknis (Finalized)

> **✅ Semua pertanyaan sudah dijawab dan difinalisasi.**

| No | Pertanyaan | Keputusan |
|----|-----------|----------|
| 1 | **Tech Stack** | Full-stack **Laravel + Alpine.js** (monolith, Blade templating) |
| 2 | **Database** | **MySQL 8.0+** |
| 3 | **Deployment** | **Self-hosted** (VPS dengan Nginx + PHP-FPM) |
| 4 | **Payment Gateway** | **Manual transfer bank** (tanpa payment gateway, konfirmasi manual) |
| 5 | **Prioritas MVP** | **Phase 1–4** cukup untuk MVP pertama |
| 6 | **Design** | **Sudah tersedia** (mockup/referensi design sudah ada) |
| 7 | **Bahasa** | **Bahasa Indonesia saja** (single language) |
| 8 | **Mobile App** | **Tidak ada** — web responsive saja (tanpa mobile app) |

### Implikasi Keputusan

**Laravel + Alpine.js (Monolith)**
- Tidak perlu setup frontend terpisah (React/Vue)
- Blade sebagai template engine, Alpine.js untuk interaktivitas ringan
- Livewire bisa dipertimbangkan untuk komponen yang lebih kompleks (datatables, form wizard, dll)
- Semua dalam 1 codebase Laravel

**Manual Transfer Payment**
- WO mengirim invoice ke client
- Client transfer manual ke rekening WO
- WO mengkonfirmasi pembayaran di sistem
- Upload bukti transfer sebagai verifikasi
- Tidak ada integrasi payment gateway di MVP

**Self-Hosted Deployment**
- Butuh setup VPS (contoh: IDCloudHost, Biznet, DigitalOcean)
- Setup Nginx + PHP 8.2+ + MySQL 8.0+
- SSL via Let's Encrypt (gratis)
- Backup database harian
- Monitoring manual / simple uptime checker

---

*Dokumen ini akan di-update seiring perkembangan project.*
**WOApp — Wedding Organizer SaaS Platform v1.1 (Finalized)**
