# 🎨 Design References — WOApp

> **Dokumen ini berisi referensi design yang akan digunakan sebagai panduan saat development.**

---

## 1. Halaman Publik / Landing Page WO

**File:** `referensi-01-public-landing-page.png`

### Karakteristik Design:
- **Color Scheme:** Dusty rose / pink pastel + cream/beige + dark footer
- **Style:** Elegant, feminine, romantic — sangat cocok untuk wedding
- **Layout Sections:**
  - Hero section dengan foto wedding + tagline utama
  - About section ("The Minds Behind Your Perfect Day")
  - Services section ("Bespoke Planning For Your Special Day")
  - Portfolio section ("Visualizing Your Dreams Into Reality")
  - Commitment section
  - Why Choose Us section
  - Social media / gallery feed
  - CTA section ("Let's Talk")
  - Footer dengan kontak & social links
- **Typography:** Kombinasi serif (heading) + sans-serif (body)
- **Visual Elements:** Rounded corners, soft shadows, bubble/circle decorations
- **Imagery:** Full-width photos, grid galleries, circular portrait frames

### Implementasi Nanti:
- Ini akan menjadi template halaman publik per WO (`/wo/{slug}`)
- Konten dinamis: nama WO, paket wedding, portofolio, testimoni
- Responsive mobile-first
- SEO optimized

---

## 2. Halaman Admin Dashboard

**File:** `referensi-02-admin-dashboard.png`

### Karakteristik Design:
- **Color Scheme:** Clean white + soft blue/purple accent + light gray background
- **Style:** Modern, clean, professional — SaaS dashboard standard
- **Layout:**
  - **Sidebar kiri:** Logo, navigasi menu (Dashboard, Business, Products, Clients, Analytics, Performance, History, Notification, Message, Settings), user profile di bawah
  - **Top bar:** Search bar, icons (language, dark mode, calendar, notifications, chat, profile)
  - **Content area:**
    - Stats cards row (Total Revenue, Total Orders, Total Customers, Sales Overview)
    - Charts section (Line chart "Total Users" + Bar chart "Device Traffic")
    - Data table (Recent Orders dengan kolom: Purchase Id, Customer Name, Product Name, Amount, Order Date, Vendor, Status)
- **UI Components:**
  - Stat cards dengan icon berwarna (hijau, biru, ungu)
  - Badge status berwarna (Paid=hijau, Unpaid=merah, Pending=kuning)
  - Sidebar collapsible dengan icon
  - Avatar user
  - Notification/update card di sidebar bawah
  - "Go Premium" CTA button

### Implementasi Nanti:
- Template ini digunakan untuk **Super Admin Panel**, **WO Panel**, dan **Client Panel**
- Sidebar menu disesuaikan per role
- Stats cards disesuaikan per konteks:
  - Super Admin: Total WO, Total Client, Total Project, Revenue
  - WO: Project Aktif, Client, Upcoming Deadline, Budget Summary
  - Client: Countdown H-Day, Progress %, Budget, Tamu Konfirmasi
- Data table untuk list data (WO, Client, Vendor, Project, dll)

---

## Catatan Penggunaan

| Aspek | Public Page | Admin Dashboard |
|-------|------------|-----------------|
| Target User | Calon klien (publik) | Super Admin, WO, Client |
| Tone | Elegant, romantic | Professional, clean |
| Color | Pink pastel, cream | Blue/purple, white |
| Typography | Serif + Sans-serif | Sans-serif (modern) |
| Responsiveness | Mobile-first | Desktop-first, responsive |

---

*File gambar referensi tersimpan di: `docs/design-references/`*
