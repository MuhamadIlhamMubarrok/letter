# 💌 SISTEM UNDANGAN & SURAT (Digital Story & Wedding Invitation Platform)

Platform CMS dan viewer interaktif berbasis web untuk **Surat Cinta Digital (Love Letter)** dan **Undangan Pernikahan Online (Wedding Invitation)** yang dibangun dengan **Laravel 12**, **Tailwind CSS**, dan **Alpine.js**.

---

## 🏛️ Arsitektur & Struktur Direktori

Sistem ini berdiri mandiri dengan arsitektur **Domain-Driven Design (DDD)** yang modular dan terisolasi:

```
app/
├── Core/
│   └── Services/
│       └── ImageOptimizer.php          # Kompresi & konversi WebP otomatis <100KB
├── Domains/
│   ├── Auth/                           # Otentikasi Admin, Keamanan & Ganti Sandi
│   │   ├── Actions/
│   │   ├── Controllers/
│   │   ├── Enums/
│   │   ├── Models/
│   │   └── Requests/
│   └── DigitalStory/                   # Mesin Inti Undangan & Surat Cinta
│       ├── Actions/                    # Create, Update, Delete, Extend, QR Generator, RSVP
│       ├── Controllers/                # AdminStoryController & PublicStoryController
│       ├── Enums/                      # StoryType, DurationPlan, TemplateKey, Theme, Fulfillment
│       ├── Models/                     # DigitalStory, StoryMedia, StoryRsvp
│       ├── Requests/                   # Validasi Form CMS & Form Publik
│       └── Templates/                  # StoryTemplateRegistry
├── Http/
│   └── Middleware/
└── Models/
    └── User.php                        # Backward compatibility alias ke App\Domains\Auth\Models\User
```

---

## 🗄️ Skema Database Mandiri (`db_letter`)

Database projek ini sepenuhnya terpisah dari sistem toko bunga (Maja Flower / ERP), hanya mengelola tabel yang esensial:

1. **`digital_stories`** — Data utama surat cinta & undangan pernikahan (slug, masa aktif, template, musik, pesan, metadata).
2. **`story_media`** — Foto polaroid kenangan & galeri acara dengan urutan sorting (`sort_order`).
3. **`story_rsvps`** — Kehadiran tamu (hadir/tidak hadir/ragu-ragu), jumlah tamu, dan ucapan doa restu.
4. **`users`** — Akun staf & admin backoffice CMS.
5. **`sessions`**, **`cache`**, **`cache_locks`**, **`jobs`**, **`job_batches`**, **`failed_jobs`**, **`password_reset_tokens`** — Tabel operasional sistem Laravel.

---

## 🚀 Fitur Unggulan

1. **Template Mesin Surat Cinta (Love Letter):**
   - Animasi buka amplop interaktif (Vintage Envelope, Midnight Rose, Retro Polaroid, Minimalist Aesthetic).
   - Pemutar audio musik romantis dengan pemotong durasi lagu (*audio trimmer*).
   - Penghitung hari cinta (*love counter*).
   - Galeri foto polaroid interaktif.

2. **Template Mesin Undangan Pernikahan (Wedding Invitation):**
   - Cover undangan personal per nama tamu (`/s/{slug}?to=Nama+Tamu`).
   - Countdown acara pernikahan real-time.
   - Integrasi Google Maps & Calendar.
   - Kisah perjalanan cinta (*love journey*).
   - Form RSVP & Buku Tamu / Doa Restu live interaktif.
   - Tanda kasih digital / amplop digital (rekening bank & QRIS).

3. **Backoffice CMS (`/portal-rahasia-florist` atau `/admin`):**
   - Pipeline pemenuhan pesanan (*drafting*, *review*, *ready to print*, *completed*).
   - Generator kartu cetak fisik siap print (A6 / kartu buket) dengan QR code SVG beresolusi tinggi.
   - Quick WhatsApp notification & reminder perpanjangan durasi.

---

## ⚙️ Setup & Migrasi Database

```bash
# Salin konfigurasi environment
cp .env.example .env

# Generate Application Key
php artisan key:generate

# Jalankan migrasi dan seeder data demo
php artisan migrate:fresh --seed
```

### Kredensial Login Backoffice Demo:
- **URL Login:** `http://127.0.0.1:8000/portal-rahasia-florist` (atau `/admin/login`)
- **Email:** `admin@majaflower.com`
- **Password:** `password`
