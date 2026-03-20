# ✈️ NearFlight

> Sistem pemesanan tiket pesawat berbasis web dengan fitur manajemen kursi interaktif, keranjang belanja, kode diskon, dan loyalty points.

---

## 📋 Daftar Isi

- [Tentang Project](#tentang-project)
- [Fitur](#fitur)
- [Tech Stack](#tech-stack)
- [ERD Database](#erd-database)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Penggunaan](#penggunaan)
- [Role & Akses](#role--akses)
- [Struktur Database](#struktur-database)
- [Kontribusi](#kontribusi)

---

## 📖 Tentang Project

NearFlight adalah aplikasi web pemesanan tiket pesawat yang memungkinkan pengguna untuk mencari penerbangan, memilih kursi secara interaktif, melakukan pemesanan dengan berbagai metode pembayaran, serta mendapatkan e-tiket digital. Platform ini juga dilengkapi dengan sistem diskon, program loyalitas poin, dan dashboard manajemen untuk admin dan staff maskapai.

---

## ✨ Fitur

### Pengguna (Passenger)
- 🔍 **Pencarian penerbangan** — cari berdasarkan rute, tanggal, jumlah penumpang, dan kelas
- 💺 **Seat map interaktif** — pilih kursi secara visual (economy, business, first class)
- 🛒 **Keranjang belanja** — tambahkan beberapa penerbangan (pergi-pulang) sebelum checkout, kursi dikunci otomatis selama 15 menit
- 🎟️ **Kode diskon & promo** — masukkan kode voucher, flash sale otomatis, atau tukar poin loyalty
- 👨‍👩‍👧 **Multi-penumpang** — pesan tiket untuk lebih dari satu penumpang sekaligus
- 💳 **Pembayaran** — mendukung transfer bank, kartu kredit, dan e-wallet
- 📄 **E-tiket PDF** — tiket digital dikirim via email setelah pembayaran berhasil
- 🏆 **Loyalty points** — kumpulkan poin setiap pemesanan, tukar sebagai diskon

### Airline Staff
- 🛫 **Manajemen jadwal penerbangan** — tambah, edit, dan kelola jadwal penerbangan
- 💺 **Konfigurasi kursi & kelas** — atur denah kursi, kelas, dan harga per penerbangan
- 🏷️ **Buat kode diskon** — buat voucher dengan aturan penggunaan yang fleksibel
- 📊 **Laporan pemesanan** — pantau tingkat isi kursi dan pendapatan per penerbangan

### Admin
- 👥 **Manajemen pengguna** — kelola semua akun pengguna dan staff maskapai
- ✈️ **Manajemen maskapai & bandara** — tambah dan kelola data maskapai serta bandara
- 📈 **Laporan global** — pantau seluruh transaksi dan pendapatan platform
- 🎁 **Manajemen promo** — kelola program diskon dan loyalty points skala platform

---

## 🛠️ Tech Stack

### Backend
| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| PHP | ^8.2 | Bahasa pemrograman utama |
| Laravel | ^12.x | Framework backend |
| PostgreSQL | ^16.x | Database utama |
| Redis | ^7.x | Cache, session, dan seat locking |
| Predis | ^3.x | PHP client untuk Redis |

### Frontend
| Teknologi | Keterangan |
|-----------|------------|
| Blade | Template engine bawaan Laravel |
| Tailwind CSS | Styling dan UI components |
| Alpine.js | Interaktivitas ringan (seat map, cart) |
| Vite | Asset bundler |

### Storage & Services
| Layanan | Keterangan |
|---------|------------|
| Laravel Storage | Penyimpanan e-tiket PDF (local disk) |
| Midtrans / Xendit | Payment gateway |
| Laravel Queue | Antrian pengiriman email e-tiket |
| Laravel Mail | Notifikasi email konfirmasi booking |

### Development Tools
| Tool | Keterangan |
|------|------------|
| Laragon | Local development environment (Windows) |
| HeidiSQL | Database GUI client |
| dbdiagram.io | Desain ERD database |

---

## 🗃️ ERD Database

Project ini menggunakan **15 tabel** dengan relasi sebagai berikut:

```
users               ← tabel pusat semua role
├── passengers      ← data penumpang milik user
├── carts           ← keranjang belanja
│   └── cart_items  ← item dalam keranjang
├── bookings        ← transaksi pemesanan
│   ├── booking_seats ← detail kursi yang dipesan
│   └── payments    ← data pembayaran
├── discount_codes  ← kode diskon yang dibuat
└── loyalty_points  ← riwayat poin reward

airlines
├── airplanes
│   ├── seat_configurations ← denah kursi pesawat
│   └── flights
│       └── flight_seat_prices ← harga per kelas

airports ← asal & tujuan penerbangan
```

---

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- PostgreSQL >= 16
- Redis >= 7
- Node.js >= 20

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/username/nearflight.git
cd nearflight
```

**2. Install dependensi PHP**
```bash
composer install
```

**3. Install dependensi Node.js**
```bash
npm install
```

**4. Copy file environment**
```bash
cp .env.example .env
```

**5. Generate application key**
```bash
php artisan key:generate
```

**6. Jalankan migration**
```bash
php artisan migrate
```

**7. (Opsional) Jalankan seeder**
```bash
php artisan db:seed
```

**8. Build assets**
```bash
npm run dev
```

**9. Jalankan server**
```bash
php artisan serve
```

Aplikasi dapat diakses di `http://localhost:8000`

---

## ⚙️ Konfigurasi

Sesuaikan file `.env` dengan environment lokal kamu:

```env
# Application
APP_NAME=NearFlight
APP_URL=http://localhost:8000

# Database PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nearflight
DB_USERNAME=postgres
DB_PASSWORD=your_password

# Redis
REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null

# Cache & Session via Redis
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

---

## 📌 Penggunaan

### Alur Pemesanan Tiket

```
1. Daftar / Login akun
      ↓
2. Cari penerbangan (rute, tanggal, kelas, jumlah penumpang)
      ↓
3. Pilih penerbangan dari hasil pencarian
      ↓
4. Pilih kursi dari seat map interaktif
      ↓
5. Isi data penumpang
      ↓
6. Masukkan kode diskon (opsional)
      ↓
7. Review & konfirmasi pesanan
      ↓
8. Pilih metode pembayaran & bayar
      ↓
9. Terima e-tiket PDF via email
```

### Seat Locking (Redis)

Saat pengguna memilih kursi, sistem otomatis mengunci kursi tersebut di Redis selama **15 menit**. Jika pembayaran tidak selesai dalam 15 menit, kunci dilepas dan kursi tersedia kembali untuk pengguna lain.

---

## 👥 Role & Akses

| Role | Deskripsi | Akses |
|------|-----------|-------|
| `admin` | Super administrator platform | Full access semua fitur dan data |
| `airline_staff` | Operator maskapai | Kelola jadwal, kursi, harga, dan diskon maskapai sendiri |
| `passenger` | Pengguna umum | Cari, pesan, dan kelola tiket pribadi |

---

## 🗄️ Struktur Database

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Akun pengguna semua role |
| `passengers` | Data penumpang milik user |
| `airlines` | Data maskapai penerbangan |
| `airports` | Data bandara |
| `airplanes` | Data pesawat milik maskapai |
| `seat_configurations` | Denah & konfigurasi kursi per pesawat |
| `flights` | Jadwal penerbangan |
| `flight_seat_prices` | Harga tiket per kelas per penerbangan |
| `carts` | Keranjang belanja pengguna |
| `cart_items` | Item dalam keranjang |
| `discount_codes` | Kode diskon dan promo |
| `bookings` | Transaksi pemesanan |
| `booking_seats` | Detail kursi yang dipesan |
| `payments` | Data pembayaran |
| `loyalty_points` | Riwayat poin reward pengguna |

---

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/nama-fitur`)
3. Commit perubahan (`git commit -m 'feat: tambah fitur X'`)
4. Push ke branch (`git push origin feature/nama-fitur`)
5. Buat Pull Request

---

## 📄 Lisensi

Project ini menggunakan lisensi [MIT](LICENSE).

---

<p align="center">Dibuat dengan ❤️ menggunakan Laravel & PostgreSQL</p>