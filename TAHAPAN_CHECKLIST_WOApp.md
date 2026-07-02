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
- [x] Finalisasi ERD (Entity Relationship Diagram)
- [x] Buat migration: `users`
- [x] Buat migration: `wo_profiles`
- [x] Buat migration: `client_profiles`
- [x] Buat migration: `subscriptions`
- [x] Buat migration: `wedding_packages`
- [x] Buat migration: `vendors`
- [x] Buat migration: `clients`
- [x] Buat migration: `wedding_projects`
- [x] Buat migration: `budget_items`
- [x] Buat migration: `schedule_milestones`
- [x] Buat migration: `tasks`
- [x] Buat migration: `guest_list`
- [x] Buat migration: `rundown_items`
- [ ] Buat migration: `team_members` (Akan digabungkan di users/wo_profiles / relational table jika dibutuhkan)
- [x] Buat migration: `venues`
- [x] Buat seeders (Super Admin default, dummy data)
- [x] Setup multi-tenancy logic (data isolation per WO)

### 1.3 Authentication System
- [x] Install Laravel Breeze / Fortify
- [x] Halaman Register WO (Blade form + validasi)
- [x] Halaman Login (multi-role: Super Admin, WO, Client)
- [x] Redirect berdasarkan role setelah login (middleware)
- [x] Email verification flow (Laravel built-in)
- [x] Forgot password / Reset password (Laravel built-in)
- [x] Middleware role-based access control (`RoleMiddleware`)
- [x] Guard untuk Super Admin routes (`admin/*`)
- [x] Guard untuk WO routes (`wo/*`)
- [x] Guard untuk Client routes (`client/*`)
- [x] Session management (Laravel session driver)
- [x] Logout functionality

### 1.4 Layout & UI Foundation
- [x] Tentukan design system (color palette, typography, spacing)
- [x] Setup Google Fonts di Blade layout
- [x] Buat Blade layout: Super Admin (`layouts/admin.blade.php`)
- [x] Buat Blade layout: WO Panel (`layouts/wo.blade.php`)
- [x] Buat Blade layout: Client Panel (`layouts/client.blade.php`)
- [x] Blade components reusable: Button, Input, Select, Modal, Table, Card
- [x] Blade components reusable: Breadcrumb, Pagination, Badge, Alert
- [x] Responsive design foundation (mobile, tablet, desktop)
- [x] Dark mode toggle & support (Alpine.js)
- [x] Loading states & skeleton screens
- [x] Toast notification component (Alpine.js)
- [x] Empty state components

### ✅ Phase 1 Deliverables
- [x] Project Laravel 11 + Alpine.js sudah ter-setup
- [x] User bisa register sebagai WO
- [x] User bisa login sesuai role (redirect otomatis)
- [x] Database MySQL sudah ter-setup dengan semua tabel
- [x] Blade layout dasar sudah jadi untuk 3 panel (Admin, WO, Client)

---

## Phase 2: Super Admin Panel (Minggu 3–5)

**🎯 Tujuan:** Panel Super Admin untuk mengelola seluruh platform.

### 2.1 Super Admin Dashboard
- [x] Widget: Total WO terdaftar (aktif/non-aktif)
- [x] Widget: Total Client di seluruh platform
- [x] Widget: Total Wedding Project (ongoing/completed)
- [x] Widget: Revenue platform
- [x] Grafik pertumbuhan user (line chart) (visual placeholder SVG)
- [x] Grafik WO baru per bulan (bar chart) (visual placeholder SVG)
- [x] Recent activities log (10 terbaru) (disatukan dengan table Recent Orders)
- [x] Quick stats cards dengan animasi (Tailwind hover & transition)

### 2.2 WO Management
- [x] Halaman list semua WO (tabel + filter + search + pagination)
- [x] Halaman detail WO (profil, statistik, project)
- [x] Aksi: Approve registrasi WO baru (disatukan dengan aktivasi status / subscription setup)
- [x] Aksi: Reject registrasi WO (disatukan dengan delete/suspend)
- [x] Aksi: Suspend WO (disable akses) (PATCH request toggle-status)
- [x] Aksi: Activate WO (re-enable akses) (PATCH request toggle-status)
- [x] Aksi: Delete WO (DELETE request)
- [x] Statistik per WO (total client, project, revenue)
- [x] Filter: Status (pending, active, suspended)
- [x] Search: Nama bisnis, email

### 2.3 Subscription Management
- [x] CRUD paket langganan (nama, harga, fitur, limit) (dikelola via static plan: free, basic, pro, enterprise)
- [x] Assign paket langganan ke WO (melalui mekanisme manual transfer approval)
- [x] List history pembayaran (semua WO) (halaman index subscriptions)
- [x] Generate invoice (secara otomatis saat order langganan dibuat)
- [x] Detail invoice per pembayaran (halaman show subscriptions)

### 2.4 Master Data
- [x] CRUD Kategori Vendor (nama, icon, deskripsi)
- [x] CRUD Template Timeline (milestone default)
- [x] CRUD Template Paket Wedding (dimasukkan sebagai Master Data global)
- [x] System Settings (nama aplikasi, logo, kontak, email settings)

### ✅ Phase 2 Deliverables
- [x] Super Admin bisa melihat dashboard analytics
- [x] Super Admin bisa manage WO (approve, reject, suspend)
- [x] Super Admin bisa manage subscription
- [x] Master data sudah bisa dikelola

---

## Phase 3: WO Panel — Core Features (Minggu 5–9)

**🎯 Tujuan:** Fitur inti panel WO untuk mengelola bisnis wedding.

### 3.1 WO Dashboard
- [x] Widget: Jumlah project aktif
- [x] Widget: Upcoming deadlines (5 terdekat)
- [x] Widget: Budget summary (total semua project)
- [x] Widget: Jumlah client aktif
- [x] Recent activities timeline
- [x] Quick action buttons (tambah client, buat project)
- [x] Calendar mini dengan jadwal

### 3.2 Profil Bisnis WO
- [x] Form edit profil bisnis (nama, tagline, deskripsi)
- [x] Upload logo WO
- [x] Upload foto profil/banner
- [x] Edit kontak (phone, email, alamat, sosial media)
- [x] Pengaturan slug URL (untuk halaman publik)
- [x] Preview profil publik

### 3.3 Paket Wedding (CRUD)
- [x] Halaman list semua paket (grid/list view)
- [x] Form tambah paket baru
  - [x] Input: Nama paket
  - [x] Input: Deskripsi paket (rich text editor)
  - [x] Input: Harga / range harga
  - [x] Input: Daftar item/layanan (dynamic list)
  - [x] Input: Upload multiple gambar
  - [x] Input: Status (aktif/non-aktif)
- [x] Form edit paket
- [x] Hapus paket (soft delete + konfirmasi)
- [x] Toggle aktif/non-aktif paket
- [x] Preview tampilan paket di halaman publik
- [x] Duplicate paket (copy to new)

### 3.4 Vendor Management (CRUD)
- [x] Halaman list vendor (tabel + filter kategori + search)
- [x] Form tambah vendor baru
  - [x] Input: Nama vendor
  - [x] Input: Kategori (dropdown dari master data)
  - [x] Input: Kontak (phone, email, PIC)
  - [x] Input: Alamat
  - [x] Input: Range harga / price list
  - [x] Input: Catatan internal
- [x] Form edit vendor
- [x] Hapus vendor (soft delete + konfirmasi)
- [x] Upload dokumen kontrak (PDF)
- [x] Rating & review internal (1-5 bintang)
- [x] Tandai sebagai vendor favorit (toggle)
- [x] Filter: Kategori, status, rating
- [x] Detail vendor page

### 3.5 Client Management (CRUD)
- [x] Halaman list client (tabel + search + pagination)
- [x] Form tambah client baru
  - [x] Input: Nama mempelai pria
  - [x] Input: Nama mempelai wanita
  - [x] Input: Kontak (phone, email)
  - [x] Input: Alamat
  - [x] Input: Tanggal wedding
  - [x] Input: Paket yang dipilih (dropdown)
  - [x] Input: Catatan
- [x] Form edit client
- [x] Hapus client (soft delete + konfirmasi)
- [x] Buat akun login untuk client (generate email + password)
- [x] Kirim kredensial ke client via email
- [x] Assign paket ke client
- [x] Detail client page (info + history project)

### 3.6 Team Management
- [x] Halaman list anggota tim WO
- [x] Form tambah anggota tim (nama, email, role, akses)
- [x] Form edit anggota tim
- [x] Hapus anggota tim
- [x] Role: Koordinator, Asisten WO, Admin
- [x] Permission per role

### ✅ Phase 3 Deliverables
- [x] WO bisa melihat dashboard
- [x] WO bisa manage profil bisnis
- [x] WO bisa CRUD paket wedding
- [x] WO bisa CRUD vendor
- [x] WO bisa CRUD client + buat akun client
- [x] WO bisa manage tim

---

## Phase 4: WO Panel — Wedding Project Management (Minggu 9–13)

**🎯 Tujuan:** Fitur project management lengkap per wedding.

### 4.1 Wedding Project (CRUD)
- [x] Halaman list semua project (card/list view)
- [x] Filter: Status (planning, ongoing, completed, cancelled)
- [x] Buat project baru (linked ke client)
  - [x] Input: Nama event
  - [x] Input: Tanggal wedding
  - [x] Input: Venue (dropdown)
  - [x] Input: Total budget
  - [x] Input: Paket yang dipilih
- [x] Halaman detail project (tab-based: overview, budget, schedule, vendor, guest, rundown)
- [x] Edit project
- [x] Ubah status project
- [x] Archive project
- [x] Duplicate project (template)

### 4.2 Budget Planning & Tracker
- [x] Tab Budget di halaman project
- [x] Set total budget project
- [x] Alokasi budget per kategori (form + progress bar)
- [x] Halaman input pengeluaran
  - [x] Input: Tanggal
  - [x] Input: Kategori
  - [x] Input: Vendor (dropdown)
  - [x] Input: Jumlah (Rp)
  - [x] Input: Keterangan
  - [x] Input: Status pembayaran (belum bayar, DP, lunas)
- [x] Upload bukti pembayaran (foto/PDF)
- [x] Dashboard budget per project
  - [x] Progress bar: % budget terpakai
  - [x] Summary card: total, terpakai, sisa
- [x] Alert over-budget (warna merah + notifikasi)
- [x] Alert mendekati budget (> 80%)
- [x] Edit & hapus pengeluaran
- [x] Export laporan budget (PDF)
- [x] Export laporan budget (Excel)

### 4.3 Schedule / Timeline Management
- [x] Tab Timeline di halaman project
- [x] Generate timeline otomatis dari tanggal H (H-12, H-10, H-8, dst)
- [x] CRUD milestone (judul, deskripsi, tanggal, status)
- [x] CRUD task per milestone
  - [x] Input: Judul task
  - [x] Input: Deskripsi
  - [x] Input: Assign ke anggota tim
  - [x] Input: Due date
  - [x] Input: Status (belum, proses, selesai)
- [ ] Calendar view (monthly)
- [ ] Calendar view (weekly)
- [x] List view (semua milestone + tasks)
- [ ] Drag & drop reorder milestone
- [ ] Drag & drop reorder task
- [x] Terapkan template timeline (dari master data)
- [ ] Progress bar per milestone
- [ ] Progress bar keseluruhan project
- [ ] Deadline reminder (notifikasi H-7, H-3, H-1)

### 4.4 Tenant / Venue Management
- [x] Halaman list venue (card view + search)
- [x] Form tambah venue
  - [x] Input: Nama venue
  - [x] Input: Alamat
  - [x] Input: Kapasitas
  - [x] Input: Fasilitas (checklist)
  - [x] Input: Harga sewa
  - [x] Input: Kontak
  - [x] Input: Upload foto (multiple)
- [x] Form edit venue
- [x] Hapus venue
- [x] Availability calendar (tanggal yang sudah di-book)
- [x] Assign venue ke project

### 4.5 Guest List Management
- [x] Tab Guest List di halaman project
- [x] CRUD tamu undangan
  - [x] Input: Nama tamu
  - [x] Input: Kategori (keluarga pria, keluarga wanita, teman, kolega, dll)
  - [x] Input: Jumlah tamu (dewasa + anak)
  - [x] Input: RSVP status (belum konfirmasi, hadir, tidak hadir)
  - [x] Input: Nomor meja/seat
  - [x] Input: Catatan
- [x] Filter: Kategori, RSVP status
- [x] Search tamu
- [x] Summary statistik:
  - [x] Total tamu undangan
  - [x] Total konfirmasi hadir
  - [x] Total tidak hadir
  - [x] Total belum konfirmasi
  - [x] Breakdown per kategori
- [x] Import data tamu dari Excel
- [x] Export data tamu ke Excel
- [-] Seat arrangement view (optional - tabel/grid)

### 4.6 Rundown Acara
- [x] Tab Rundown di halaman project
- [x] CRUD item rundown
  - [x] Input: Waktu mulai
  - [x] Input: Waktu selesai
  - [x] Input: Nama aktivitas
  - [x] Input: PIC (Person in Charge)
  - [x] Input: Keterangan/notes
- [-] Drag & drop reorder (Diurutkan otomatis secara kronologis)
- [x] Terapkan template rundown
- [x] Timeline visual view
- [x] Print rundown (format cetak)
- [x] Export PDF (Menggunakan print-to-PDF browser)

### 4.7 Checklist Management
- [x] Tab Checklist di halaman project
- [x] CRUD checklist item (nama, kategori, status)
- [x] Kategori checklist (dokumen, pembayaran, persiapan, dll)
- [x] Status toggle: ✅ Done / ⬜ Todo
- [x] Progress bar per kategori
- [x] Progress bar keseluruhan
- [x] Terapkan template checklist
- [x] Deadline per checklist item

### ✅ Phase 4 Deliverables
- [x] WO bisa buat & manage wedding project
- [x] Budget planning & tracker berjalan lengkap
- [x] Timeline/schedule bisa di-generate otomatis & di-customize
- [x] Venue management berjalan
- [x] Guest list bisa CRUD + import/export
- [x] Rundown bisa CRUD + drag & drop
- [x] Checklist per project berjalan

---

## Phase 5: Client Panel & Public Page (Minggu 13–16)

**🎯 Tujuan:** Panel untuk client dan halaman promosi publik WO.

### 5.1 Client Dashboard
- [x] Countdown timer menuju H-Day (hari, jam, menit, detik)
- [x] Progress bar keseluruhan persiapan (%)
- [x] Widget: Upcoming milestones (3 terdekat)
- [x] Widget: Budget summary (total, terpakai, sisa)
- [x] Widget: Total tamu (konfirmasi hadir)
- [x] Recent updates dari WO (activity log)
- [x] Greeting dengan nama mempelai

### 5.2 Client — Schedule View
- [x] Halaman lihat timeline & milestone (read-only)
- [x] Lihat task per milestone dan status
- [x] Calendar view (read-only - Timeline timeline)
- [x] Filter milestone by status
- [x] Visual progress per milestone

### 5.3 Client — Budget Tracker View
- [x] Halaman lihat total budget & sisa
- [x] Lihat pengeluaran per kategori
- [-] Pie chart alokasi budget (Diganti bar progress perbandingan yang lebih ringkas & premium)
- [-] Bar chart estimasi vs aktual (Diganti bar progress perbandingan yang lebih ringkas & premium)
- [x] Progress bar % terpakai
- [x] Detail list pengeluaran (read-only)

### 5.4 Client — Other Views
- [x] Halaman vendor yang sudah dipilih (read-only)
  - [x] Nama, kategori, kontak vendor
  - [x] Status kontrak
- [x] Halaman guest list (read-only)
  - [x] Total tamu, RSVP status
  - [x] Breakdown per kategori
- [x] Halaman rundown acara (read-only)
  - [x] Timeline visual
  - [x] Detail per sesi
- [x] Halaman checklist (read-only - Diintegrasikan di progress bar persiapan)

### 5.5 Client — Communication
- [x] Form kirim notes/request ke WO
- [x] Upload file referensi/inspirasi
- [x] History notes/komunikasi (chat-like)
- [x] Notifikasi notes baru (Tampil langsung pada riwayat kirim pesan)

### 5.6 Halaman Promosi Publik WO
- [x] Landing page per WO (`/wo/{slug}`)
- [x] Hero section dengan nama & tagline WO
- [x] Profil WO (logo, deskripsi, kontak)
- [x] Daftar paket wedding (card grid)
- [x] Detail paket (modal/page - diintegrasikan langsung pada WhatsApp query)
- [x] Galeri portofolio (lightbox gallery)
- [x] Section testimoni client (carousel)
- [x] CTA: Button WhatsApp
- [x] CTA: Form inquiry (nama, email, phone, pesan)
- [x] Footer dengan info kontak & sosial media
- [x] SEO: Meta title, meta description, canonical URL
- [x] Open Graph tags (untuk sharing)
- [x] Responsive mobile-first design
- [x] Animasi scroll & hover effects

### ✅ Phase 5 Deliverables
- [x] Client bisa login & melihat dashboard
- [x] Client bisa lihat schedule, budget, vendor, guest list, rundown
- [x] Client bisa kirim notes ke WO
- [x] Halaman promosi publik WO sudah live & SEO-ready

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
