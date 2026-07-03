# 📝 Checklist Tahapan Implementasi — Sistem Langganan & Checkout WO (Phase 2)

> **Dokumen panduan dan checklist pengerjaan fitur Subscription, Checkout & Upload Bukti Pembayaran.**

---

## 🎨 Tahap 0: Redesain Halaman Auth (Login & Register)
- [x] Redesain halaman **Login** (`resources/views/auth/login.blade.php`) agar memiliki tampilan premium, berestetika modern (dark-mode/rose accent), responsif, dan dinamis.
- [x] Redesain halaman **Register** (`resources/views/auth/register.blade.php`) dengan desain premium yang senada, lengkap dengan penanganan visual untuk parameter paket pilihan (`plan`).

---

## 🛠️ Tahap 1: Database & Model Setup
- [x] Buat field `expired_at` di tabel `wo_profiles` (jika belum ada) untuk mencatat akhir masa aktif langganan.
- [x] Buat Migration untuk memastikan relasi tabel `subscriptions` dan `wo_profiles` terindeks dengan baik.
- [x] Definisikan relasi `subscriptions()` di model `WoProfile` (One-to-Many).
- [x] Definisikan relasi `woProfile()` di model `Subscription` (BelongsTo).
- [x] Tambahkan status pembayaran tambahan jika diperlukan pada model/migration.

---

## 💻 Tahap 2: Route & Controller Development
- [x] Buat `SubscriptionController` untuk panel Wedding Organizer (`App\Http\Controllers\WO\SubscriptionController`).
- [x] Buat Route `wo.subscription.index` untuk menampilkan dashboard paket langganan aktif WO.
- [x] Buat Route `wo.subscription.checkout` untuk menampilkan halaman detail invoice & rekening pembayaran.
- [x] Buat Route POST `wo.subscription.store` untuk memproses unggahan file bukti transfer.
- [x] Integrasikan upload file bukti bayar ke Storage (folder `public/payment_proofs`).

---

## 🎨 Tahap 3: User Interface (Frontend WO Panel)
- [x] Buat menu sidebar baru **"Langganan & Billing"** pada layout dashboard WO.
- [x] Desain view `wo.subscription.index` (Status paket saat ini, riwayat tagihan, dan pricing cards untuk upgrade).
- [x] Desain view `wo.subscription.checkout` (Detail invoice paket, nominal pembayaran, rekening tujuan, dan formulir upload bukti transfer).
- [x] Tambahkan pesan alert informatif jika WO memiliki pengajuan upgrade yang berstatus `pending`.

---

## 👑 Tahap 4: Admin Panel Approval (Super Admin)
- [x] Hubungkan riwayat transfer masuk ke menu **Manage Subscriptions** pada dashboard Super Admin.
- [x] Buat tombol verifikasi bayar: **Setujui (Approve)** dan **Tolak (Reject)** bukti pembayaran.
- [x] Hubungkan aksi **Approve**:
  - Mengubah status `subscription` menjadi `active`.
  - Mengisi `starts_at` (sekarang) dan `ends_at` (sekarang + 30 hari).
  - Mengubah status `subscription_plan` di tabel `wo_profiles` sesuai paket yang dibeli.
- [x] Hubungkan aksi **Reject**:
  - Mengubah status `subscription` menjadi `cancelled` / `rejected`.
  - Mengirim flash message atau alasan penolakan.

---

## 🚫 Tahap 5: Feature Gating & Middleware (Pembatasan Limit)
- [x] Buat custom Middleware `CheckSubscription` untuk mendeteksi apakah langganan WO sudah kedaluwarsa (`expired`).
- [x] Buat Laravel Policy / Gate untuk membatasi penambahan **Wedding Project** berdasarkan paket aktif:
  - Free: maks 1 project aktif.
  - Basic: maks 5 project aktif.
  - Pro/Enterprise: unlimited.
- [x] Buat Laravel Policy / Gate untuk membatasi jumlah **Anggota Tim** (Team Members):
  - Free: maks 3 anggota.
  - Basic: maks 10 anggota.
  - Pro/Enterprise: unlimited.
- [x] Sembunyikan/batasi akses pengaturan **Landing Page Publik** jika paket WO adalah Free.
- [x] Sembunyikan/batasi akses **Client Dashboard** jika paket WO adalah Free.

---

## 🧪 Tahap 6: Uji Coba & UAT
- [x] Lakukan registrasi WO baru dan pastikan default paket adalah **Free**.
- [x] Coba buat lebih dari 1 project aktif dengan paket Free $\rightarrow$ pastikan sistem memblokir tindakan tersebut.
- [x] Ajukan upgrade ke paket **Pro** dengan mengunggah gambar bukti transfer palsu.
- [x] Login sebagai **Super Admin**, periksa halaman pengajuan masuk, lalu klik **Approve**.
- [x] Kembali login sebagai WO $\rightarrow$ pastikan status dashboard sudah berubah menjadi **Pro** dan semua batasan fitur telah terbuka.
