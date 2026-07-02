# 📋 Tahapan Pengerjaan & Checklist — WOApp

> **Dokumen ini berisi tahapan pengerjaan project, timeline, dan checklist/todolist development.**
> Estimasi Total: **16–20 Minggu** untuk MVP (Minimum Viable Product)
> Tech Stack: **Laravel 11 + Alpine.js + MySQL** | Deployment: **Self-hosted**

---

## Overview Tahapan

| Phase | Nama | Durasi | Status |
|-------|------|--------|--------|
| 1 | Foundation & Authentication | Minggu 1–3 | ⬜ Belum |
| 2 | Super Admin Panel | Minggu 3–5 | ⬜ Belum |
| 3 | WO Panel — Core Features | Minggu 5–9 | ⬜ Belum |
| 4 | WO Panel — Project Management | Minggu 9–13 | ⬜ Belum |
| 5 | Client Panel & Public Page | Minggu 13–16 | ⬜ Belum |
| 6 | Polish, Testing & Deployment | Minggu 16–20 | ⬜ Belum |

---

## Phase 1: Foundation & Authentication (Minggu 1–3)

**🎯 Tujuan:** Setup project, database, dan sistem autentikasi multi-role.

### 1.1 Project Setup
- [x] Initialize project Laravel 11 (`composer create-project laravel/laravel woapp`)
- [x] Install Alpine.js (`npm install alpinejs`)
- [x] Setup database MySQL 8.0+
- [x] Setup repository Git & branching strategy (main, develop, feature/*)
- [x] Setup environment variables (.env)
- [-] Setup CI/CD pipeline (GitHub Actions / GitLab CI) (Skipped for now)
- [x] Install & konfigurasi dependencies utama (Laravel Breeze, dll)
- [x] Setup PHP CS Fixer & Laravel Pint
- [x] Buat struktur folder project (Standard Laravel - Opsi A)

### 1.2 Database & Migration
- [ ] Finalisasi ERD (Entity Relationship Diagram)
- [ ] Buat migration: `users`
- [ ] Buat migration: `wo_profiles`
- [ ] Buat migration: `client_profiles`
- [ ] Buat migration: `subscriptions`
- [ ] Buat migration: `wedding_packages`
- [ ] Buat migration: `vendors`
- [ ] Buat migration: `clients`
- [ ] Buat migration: `wedding_projects`
- [ ] Buat migration: `budget_items`
- [ ] Buat migration: `schedule_milestones`
- [ ] Buat migration: `tasks`
- [ ] Buat migration: `guest_list`
- [ ] Buat migration: `rundown_items`
- [ ] Buat migration: `team_members`
- [ ] Buat migration: `venues`
- [ ] Buat seeders (Super Admin default, dummy data)
- [ ] Setup multi-tenancy logic (data isolation per WO)

### 1.3 Authentication System
- [ ] Install Laravel Breeze / Fortify
- [ ] Halaman Register WO (Blade form + validasi)
- [ ] Halaman Login (multi-role: Super Admin, WO, Client)
- [ ] Redirect berdasarkan role setelah login (middleware)
- [ ] Email verification flow (Laravel built-in)
- [ ] Forgot password / Reset password (Laravel built-in)
- [ ] Middleware role-based access control (`RoleMiddleware`)
- [ ] Guard untuk Super Admin routes (`admin/*`)
- [ ] Guard untuk WO routes (`wo/*`)
- [ ] Guard untuk Client routes (`client/*`)
- [ ] Session management (Laravel session driver)
- [ ] Logout functionality

### 1.4 Layout & UI Foundation
- [ ] Tentukan design system (color palette, typography, spacing)
- [ ] Setup Google Fonts di Blade layout
- [ ] Buat Blade layout: Super Admin (`layouts/admin.blade.php`)
- [ ] Buat Blade layout: WO Panel (`layouts/wo.blade.php`)
- [ ] Buat Blade layout: Client Panel (`layouts/client.blade.php`)
- [ ] Blade components reusable: Button, Input, Select, Modal, Table, Card
- [ ] Blade components reusable: Breadcrumb, Pagination, Badge, Alert
- [ ] Responsive design foundation (mobile, tablet, desktop)
- [ ] Dark mode toggle & support (Alpine.js)
- [ ] Loading states & skeleton screens
- [ ] Toast notification component (Alpine.js)
- [ ] Empty state components

### ✅ Phase 1 Deliverables
- [ ] Project Laravel 11 + Alpine.js sudah ter-setup
- [ ] User bisa register sebagai WO
- [ ] User bisa login sesuai role (redirect otomatis)
- [ ] Database MySQL sudah ter-setup dengan semua tabel
- [ ] Blade layout dasar sudah jadi untuk 3 panel (Admin, WO, Client)

---

## Phase 2: Super Admin Panel (Minggu 3–5)

**🎯 Tujuan:** Panel Super Admin untuk mengelola seluruh platform.

### 2.1 Super Admin Dashboard
- [ ] Widget: Total WO terdaftar (aktif/non-aktif)
- [ ] Widget: Total Client di seluruh platform
- [ ] Widget: Total Wedding Project (ongoing/completed)
- [ ] Widget: Revenue platform
- [ ] Grafik pertumbuhan user (line chart)
- [ ] Grafik WO baru per bulan (bar chart)
- [ ] Recent activities log (10 terbaru)
- [ ] Quick stats cards dengan animasi

### 2.2 WO Management
- [ ] Halaman list semua WO (tabel + filter + search + pagination)
- [ ] Halaman detail WO (profil, statistik, project)
- [ ] Aksi: Approve registrasi WO baru
- [ ] Aksi: Reject registrasi WO
- [ ] Aksi: Suspend WO (disable akses)
- [ ] Aksi: Activate WO (re-enable akses)
- [ ] Aksi: Delete WO
- [ ] Statistik per WO (total client, project, revenue)
- [ ] Filter: Status (pending, active, suspended)
- [ ] Search: Nama bisnis, email

### 2.3 Subscription Management
- [ ] CRUD paket langganan (nama, harga, fitur, limit)
- [ ] Assign paket langganan ke WO
- [ ] List history pembayaran (semua WO)
- [ ] Generate invoice
- [ ] Detail invoice per pembayaran

### 2.4 Master Data
- [ ] CRUD Kategori Vendor (nama, icon, deskripsi)
- [ ] CRUD Template Timeline (milestone default)
- [ ] CRUD Template Paket Wedding
- [ ] System Settings (nama aplikasi, logo, kontak, email settings)

### ✅ Phase 2 Deliverables
- [ ] Super Admin bisa melihat dashboard analytics
- [ ] Super Admin bisa manage WO (approve, reject, suspend)
- [ ] Super Admin bisa manage subscription
- [ ] Master data sudah bisa dikelola

---

## Phase 3: WO Panel — Core Features (Minggu 5–9)

**🎯 Tujuan:** Fitur inti panel WO untuk mengelola bisnis wedding.

### 3.1 WO Dashboard
- [ ] Widget: Jumlah project aktif
- [ ] Widget: Upcoming deadlines (5 terdekat)
- [ ] Widget: Budget summary (total semua project)
- [ ] Widget: Jumlah client aktif
- [ ] Recent activities timeline
- [ ] Quick action buttons (tambah client, buat project)
- [ ] Calendar mini dengan jadwal

### 3.2 Profil Bisnis WO
- [ ] Form edit profil bisnis (nama, tagline, deskripsi)
- [ ] Upload logo WO
- [ ] Upload foto profil/banner
- [ ] Edit kontak (phone, email, alamat, sosial media)
- [ ] Pengaturan slug URL (untuk halaman publik)
- [ ] Preview profil publik

### 3.3 Paket Wedding (CRUD)
- [ ] Halaman list semua paket (grid/list view)
- [ ] Form tambah paket baru
  - [ ] Input: Nama paket
  - [ ] Input: Deskripsi paket (rich text editor)
  - [ ] Input: Harga / range harga
  - [ ] Input: Daftar item/layanan (dynamic list)
  - [ ] Input: Upload multiple gambar
  - [ ] Input: Status (aktif/non-aktif)
- [ ] Form edit paket
- [ ] Hapus paket (soft delete + konfirmasi)
- [ ] Toggle aktif/non-aktif paket
- [ ] Preview tampilan paket di halaman publik
- [ ] Duplicate paket (copy to new)

### 3.4 Vendor Management (CRUD)
- [ ] Halaman list vendor (tabel + filter kategori + search)
- [ ] Form tambah vendor baru
  - [ ] Input: Nama vendor
  - [ ] Input: Kategori (dropdown dari master data)
  - [ ] Input: Kontak (phone, email, PIC)
  - [ ] Input: Alamat
  - [ ] Input: Range harga / price list
  - [ ] Input: Catatan internal
- [ ] Form edit vendor
- [ ] Hapus vendor (soft delete + konfirmasi)
- [ ] Upload dokumen kontrak (PDF)
- [ ] Rating & review internal (1-5 bintang)
- [ ] Tandai sebagai vendor favorit (toggle)
- [ ] Filter: Kategori, status, rating
- [ ] Detail vendor page

### 3.5 Client Management (CRUD)
- [ ] Halaman list client (tabel + search + pagination)
- [ ] Form tambah client baru
  - [ ] Input: Nama mempelai pria
  - [ ] Input: Nama mempelai wanita
  - [ ] Input: Kontak (phone, email)
  - [ ] Input: Alamat
  - [ ] Input: Tanggal wedding
  - [ ] Input: Paket yang dipilih (dropdown)
  - [ ] Input: Catatan
- [ ] Form edit client
- [ ] Hapus client (soft delete + konfirmasi)
- [ ] Buat akun login untuk client (generate email + password)
- [ ] Kirim kredensial ke client via email
- [ ] Assign paket ke client
- [ ] Detail client page (info + history project)

### 3.6 Team Management
- [ ] Halaman list anggota tim WO
- [ ] Form tambah anggota tim (nama, email, role, akses)
- [ ] Form edit anggota tim
- [ ] Hapus anggota tim
- [ ] Role: Koordinator, Asisten WO, Admin
- [ ] Permission per role

### ✅ Phase 3 Deliverables
- [ ] WO bisa melihat dashboard
- [ ] WO bisa manage profil bisnis
- [ ] WO bisa CRUD paket wedding
- [ ] WO bisa CRUD vendor
- [ ] WO bisa CRUD client + buat akun client
- [ ] WO bisa manage tim

---

## Phase 4: WO Panel — Wedding Project Management (Minggu 9–13)

**🎯 Tujuan:** Fitur project management lengkap per wedding.

### 4.1 Wedding Project (CRUD)
- [ ] Halaman list semua project (card/list view)
- [ ] Filter: Status (planning, ongoing, completed, cancelled)
- [ ] Buat project baru (linked ke client)
  - [ ] Input: Nama event
  - [ ] Input: Tanggal wedding
  - [ ] Input: Venue (dropdown)
  - [ ] Input: Total budget
  - [ ] Input: Paket yang dipilih
- [ ] Halaman detail project (tab-based: overview, budget, schedule, vendor, guest, rundown)
- [ ] Edit project
- [ ] Ubah status project
- [ ] Archive project
- [ ] Duplicate project (template)

### 4.2 Budget Planning & Tracker
- [ ] Tab Budget di halaman project
- [ ] Set total budget project
- [ ] Alokasi budget per kategori (form + progress bar)
- [ ] Halaman input pengeluaran
  - [ ] Input: Tanggal
  - [ ] Input: Kategori
  - [ ] Input: Vendor (dropdown)
  - [ ] Input: Jumlah (Rp)
  - [ ] Input: Keterangan
  - [ ] Input: Status pembayaran (belum bayar, DP, lunas)
- [ ] Upload bukti pembayaran (foto/PDF)
- [ ] Dashboard budget per project
  - [ ] Pie chart: alokasi per kategori
  - [ ] Bar chart: estimasi vs aktual
  - [ ] Progress bar: % budget terpakai
  - [ ] Summary card: total, terpakai, sisa
- [ ] Alert over-budget (warna merah + notifikasi)
- [ ] Alert mendekati budget (> 80%)
- [ ] Edit & hapus pengeluaran
- [ ] Export laporan budget (PDF)
- [ ] Export laporan budget (Excel)

### 4.3 Schedule / Timeline Management
- [ ] Tab Timeline di halaman project
- [ ] Generate timeline otomatis dari tanggal H (H-12, H-10, H-8, dst)
- [ ] CRUD milestone (judul, deskripsi, tanggal, status)
- [ ] CRUD task per milestone
  - [ ] Input: Judul task
  - [ ] Input: Deskripsi
  - [ ] Input: Assign ke anggota tim
  - [ ] Input: Due date
  - [ ] Input: Status (belum, proses, selesai)
- [ ] Calendar view (monthly)
- [ ] Calendar view (weekly)
- [ ] List view (semua milestone + tasks)
- [ ] Drag & drop reorder milestone
- [ ] Drag & drop reorder task
- [ ] Terapkan template timeline (dari master data)
- [ ] Progress bar per milestone
- [ ] Progress bar keseluruhan project
- [ ] Deadline reminder (notifikasi H-7, H-3, H-1)

### 4.4 Tenant / Venue Management
- [ ] Halaman list venue (card view + search)
- [ ] Form tambah venue
  - [ ] Input: Nama venue
  - [ ] Input: Alamat
  - [ ] Input: Kapasitas
  - [ ] Input: Fasilitas (checklist)
  - [ ] Input: Harga sewa
  - [ ] Input: Kontak
  - [ ] Input: Upload foto (multiple)
- [ ] Form edit venue
- [ ] Hapus venue
- [ ] Availability calendar (tanggal yang sudah di-book)
- [ ] Assign venue ke project

### 4.5 Guest List Management
- [ ] Tab Guest List di halaman project
- [ ] CRUD tamu undangan
  - [ ] Input: Nama tamu
  - [ ] Input: Kategori (keluarga pria, keluarga wanita, teman, kolega, dll)
  - [ ] Input: Jumlah tamu (dewasa + anak)
  - [ ] Input: RSVP status (belum konfirmasi, hadir, tidak hadir)
  - [ ] Input: Nomor meja/seat
  - [ ] Input: Catatan
- [ ] Filter: Kategori, RSVP status
- [ ] Search tamu
- [ ] Summary statistik:
  - [ ] Total tamu undangan
  - [ ] Total konfirmasi hadir
  - [ ] Total tidak hadir
  - [ ] Total belum konfirmasi
  - [ ] Breakdown per kategori
- [ ] Import data tamu dari Excel
- [ ] Export data tamu ke Excel
- [ ] Seat arrangement view (optional - tabel/grid)

### 4.6 Rundown Acara
- [ ] Tab Rundown di halaman project
- [ ] CRUD item rundown
  - [ ] Input: Waktu mulai
  - [ ] Input: Waktu selesai
  - [ ] Input: Nama aktivitas
  - [ ] Input: PIC (Person in Charge)
  - [ ] Input: Keterangan/notes
- [ ] Drag & drop reorder
- [ ] Terapkan template rundown
- [ ] Timeline visual view
- [ ] Print rundown (format cetak)
- [ ] Export PDF

### 4.7 Checklist Management
- [ ] Tab Checklist di halaman project
- [ ] CRUD checklist item (nama, kategori, status)
- [ ] Kategori checklist (dokumen, pembayaran, persiapan, dll)
- [ ] Status toggle: ✅ Done / ⬜ Todo
- [ ] Progress bar per kategori
- [ ] Progress bar keseluruhan
- [ ] Terapkan template checklist
- [ ] Deadline per checklist item

### ✅ Phase 4 Deliverables
- [ ] WO bisa buat & manage wedding project
- [ ] Budget planning & tracker berjalan lengkap
- [ ] Timeline/schedule bisa di-generate otomatis & di-customize
- [ ] Venue management berjalan
- [ ] Guest list bisa CRUD + import/export
- [ ] Rundown bisa CRUD + drag & drop
- [ ] Checklist per project berjalan

---

## Phase 5: Client Panel & Public Page (Minggu 13–16)

**🎯 Tujuan:** Panel untuk client dan halaman promosi publik WO.

### 5.1 Client Dashboard
- [ ] Countdown timer menuju H-Day (hari, jam, menit, detik)
- [ ] Progress bar keseluruhan persiapan (%)
- [ ] Widget: Upcoming milestones (3 terdekat)
- [ ] Widget: Budget summary (total, terpakai, sisa)
- [ ] Widget: Total tamu (konfirmasi hadir)
- [ ] Recent updates dari WO (activity log)
- [ ] Greeting dengan nama mempelai

### 5.2 Client — Schedule View
- [ ] Halaman lihat timeline & milestone (read-only)
- [ ] Lihat task per milestone dan status
- [ ] Calendar view (read-only)
- [ ] Filter milestone by status
- [ ] Visual progress per milestone

### 5.3 Client — Budget Tracker View
- [ ] Halaman lihat total budget & sisa
- [ ] Lihat pengeluaran per kategori
- [ ] Pie chart alokasi budget
- [ ] Bar chart estimasi vs aktual
- [ ] Progress bar % terpakai
- [ ] Detail list pengeluaran (read-only)

### 5.4 Client — Other Views
- [ ] Halaman vendor yang sudah dipilih (read-only)
  - [ ] Nama, kategori, kontak vendor
  - [ ] Status kontrak
- [ ] Halaman guest list (read-only)
  - [ ] Total tamu, RSVP status
  - [ ] Breakdown per kategori
- [ ] Halaman rundown acara (read-only)
  - [ ] Timeline visual
  - [ ] Detail per sesi
- [ ] Halaman checklist (read-only)
  - [ ] Progress per kategori

### 5.5 Client — Communication
- [ ] Form kirim notes/request ke WO
- [ ] Upload file referensi/inspirasi
- [ ] History notes/komunikasi (chat-like)
- [ ] Notifikasi notes baru

### 5.6 Halaman Promosi Publik WO
- [ ] Landing page per WO (`/wo/{slug}`)
- [ ] Hero section dengan nama & tagline WO
- [ ] Profil WO (logo, deskripsi, kontak)
- [ ] Daftar paket wedding (card grid)
- [ ] Detail paket (modal/page)
- [ ] Galeri portofolio (lightbox gallery)
- [ ] Section testimoni client (carousel)
- [ ] CTA: Button WhatsApp
- [ ] CTA: Form inquiry (nama, email, phone, pesan)
- [ ] Footer dengan info kontak & sosial media
- [ ] SEO: Meta title, meta description, canonical URL
- [ ] Open Graph tags (untuk sharing)
- [ ] Responsive mobile-first design
- [ ] Animasi scroll & hover effects

### ✅ Phase 5 Deliverables
- [ ] Client bisa login & melihat dashboard
- [ ] Client bisa lihat schedule, budget, vendor, guest list, rundown
- [ ] Client bisa kirim notes ke WO
- [ ] Halaman promosi publik WO sudah live & SEO-ready

---

## Phase 6: Polish, Testing & Deployment (Minggu 16–20)

**🎯 Tujuan:** Testing, optimasi, notifikasi, dan deployment ke production.

### 6.1 Notification System
- [ ] Email notification: Deadline reminder
- [ ] Email notification: Update project dari WO
- [ ] Email notification: Notes baru dari client
- [ ] Email notification: Pembayaran reminder
- [ ] In-app notification system (bell icon + dropdown)
- [ ] Mark as read / mark all as read
- [ ] Notification preferences per user
- [ ] WhatsApp notification (optional/premium feature)

### 6.2 Invoice & Payment (WO ke Client)
- [ ] Generate invoice untuk client
- [ ] Template invoice (logo WO, detail, item)
- [ ] Track pembayaran (DP, termin 1, termin 2, pelunasan)
- [ ] Status pembayaran per termin
- [ ] Reminder otomatis (H-7, H-3, jatuh tempo)
- [ ] Cetak invoice PDF
- [ ] History invoice per client

### 6.3 Reporting
- [ ] Dashboard laporan per WO
- [ ] Laporan keuangan per project (income vs expense)
- [ ] Laporan vendor (usage, rating)
- [ ] Laporan project (status, timeline)
- [ ] Export laporan ke PDF
- [ ] Export laporan ke Excel
- [ ] Filter laporan by periode

### 6.4 Testing
- [ ] Unit testing backend (models, services)
- [ ] Unit testing frontend (components)
- [ ] Integration testing (API endpoints)
- [ ] E2E testing critical flows:
  - [ ] Register WO → Login → Setup Profil
  - [ ] Buat Client → Buat Project → Set Budget
  - [ ] Generate Timeline → Update Tasks
  - [ ] Client Login → Lihat Dashboard
- [ ] Cross-browser testing (Chrome, Firefox, Safari, Edge)
- [ ] Mobile responsive testing (iOS Safari, Android Chrome)
- [ ] Performance testing (load time, API response)
- [ ] Security audit:
  - [ ] Authentication & authorization
  - [ ] Multi-tenant data isolation
  - [ ] SQL injection prevention
  - [ ] XSS prevention
  - [ ] CSRF protection
  - [ ] File upload validation
- [ ] UAT (User Acceptance Testing) dengan real WO

### 6.5 Optimasi
- [ ] Image optimization & lazy loading
- [ ] API response caching (Redis)
- [ ] Database query optimization (indexing, N+1 queries)
- [ ] Bundle size optimization (code splitting)
- [ ] SEO optimization (sitemap, robots.txt)
- [ ] Accessibility (a11y) audit & fixes
- [ ] Core Web Vitals optimization (LCP, FID, CLS)
- [ ] Compress assets (gzip/brotli)

### 6.6 Deployment
- [ ] Setup production server (VPS/cloud)
- [ ] Setup domain & SSL certificate
- [ ] Database production setup & migration
- [ ] Environment configuration (production)
- [ ] CI/CD pipeline untuk production
- [ ] Monitoring setup (error tracking, uptime)
- [ ] Logging setup (structured logs)
- [ ] Backup strategy (database daily backup)
- [ ] CDN setup untuk static assets
- [ ] Rate limiting & DDoS protection

### 6.7 Documentation
- [ ] API documentation (Swagger/Postman)
- [ ] User manual / Help Center
- [ ] Developer documentation (setup guide)
- [ ] Database documentation
- [ ] Changelog

### ✅ Phase 6 Deliverables
- [ ] Notification system berjalan (email + in-app)
- [ ] Invoice system berjalan
- [ ] Semua testing passed
- [ ] Performance score > 90 (Lighthouse)
- [ ] Deployed ke production
- [ ] Dokumentasi lengkap

---

## Summary Checklist Count

| Phase | Checklist Items |
|-------|----------------|
| Phase 1: Foundation & Authentication | ~48 items |
| Phase 2: Super Admin Panel | ~26 items |
| Phase 3: WO Panel — Core Features | ~44 items |
| Phase 4: WO Panel — Project Management | ~62 items |
| Phase 5: Client Panel & Public Page | ~38 items |
| Phase 6: Polish, Testing & Deployment | ~52 items |
| **Total** | **~270 items** |

---

## Catatan Penting

1. **Prioritas MVP**: Phase 1–4 merupakan inti MVP. Phase 5–6 bisa di-release secara bertahap.
2. **Iterative Development**: Setiap phase bisa di-review dan di-test sebelum lanjut ke phase berikutnya.
3. **Scope Creep**: Fitur tambahan di luar scope ini harus masuk ke backlog dan didiskusikan terlebih dahulu.
4. **Timeline Flexible**: Estimasi minggu bisa berubah tergantung kompleksitas dan resource.

---

*Dokumen ini akan di-update seiring progress development.*
**WOApp — Tahapan & Checklist Development v1.0**
