# 🌸 MAJA FLOWER — Artisanal Boutique Florist Platform

A boutique florist web platform and company profile built with **Laravel 12**, **Tailwind CSS**, and **Alpine.js**, adhering to strict **Clean Modular Layered Architecture (Service-Repository Pattern with DTOs)**.

---

## 🎨 Visual Identity & Design Tokens

* **Primary (Deep Forest Green):** `#346739`
* **Secondary (Earthy Sage):** `#79AE6F`
* **Accent (Soft Celadon / Pistachio):** `#9FCB98`
* **Cream (Warm Vanilla Background):** `#F2EDC2`
* **Dark (High-Contrast Charcoal Text):** `#1F291E`
* **Surface (Pure White Card Background):** `#FFFFFF`

### Typography System
* **Editorial & Heading:** `Hedvig Letters Serif`, serif (`font-heading`)
* **Precision & Technical:** `Roboto Mono`, monospace (`font-mono`) — used for resi numbers, pricing (`Rp 350.000`), bouquet dimensions, and status codes.
* **Body Text:** `Plus Jakarta Sans`, sans-serif (`font-body`)

---

## 🏛️ Clean Architecture Structure

```
app/
├── Core/
│   ├── DTO/BaseDTO.php
│   ├── Repository/BaseRepository.php & BaseRepositoryInterface.php
│   ├── Service/BaseCrudService.php & BaseCrudServiceInterface.php
│   └── Enums/OrderStatusEnum.php
├── Admin/
│   ├── Product/ (Controller, DTO, Request, Service, Repository, Model)
│   ├── Order/   (Controller, DTO, Request, Service, Repository, Model)
│   ├── Dashboard/
│   └── Auth/
├── Client/
│   ├── Home/
│   ├── Catalog/
│   ├── OrderTracking/
│   └── Chatbot/
└── Services/
    └── Ai/GeminiService.php
```

---

## 🚀 Fitur Unggulan

1. **Editorial Asymmetric Hero & Company Profile (`/`)**
   - Komposisi visual editorial majalah, organic curved borders, floating price pill.
   - 4-Langkah Interaktif Pemesanan (`order-stepper`).
   - Signature Best-sellers & WhatsApp Quick Order.
   - Section **"Filosofi Bunga (The Language of Flowers)"**.
   - Section **"Bespoke Custom Studio"**.
   - Section **"Momen Bahagia (Polaroid Testimonials)"**.
   - Interactive Botanical Google Maps & studio location.

2. **Katalog Buket Interaktif (`/katalog`)**
   - Live filter Alpine.js: kategori, rentang harga (slider), ketersediaan stok.
   - Search bar live untuk nama buket atau varietas bunga.
   - Responsive grid (2 kolom mobile, 4 kolom desktop).

3. **Detail Produk & Kalkulator Custom (`/katalog/{slug}`)**
   - Gallery foto dengan thumbnail selector (Alpine.js).
   - Spesifikasi bunga & dimensi (`font-mono`).
   - Form kustomisasi palet wrapping (Sage Green, Earth tone, Pastel, Monochrome).
   - Free greeting card generator.
   - Add-on selector dengan kalkulasi total harga otomatis.
   - Generator tautan pesanan WhatsApp rapi.

4. **Live Order Tracking & Photo Approval (`/lacak-pesanan`)**
   - Pencarian nomor resi (`MAJA-2026-XXXX`) atau nomor handphone pemesan.
   - Visual 6-tahap status timeline.
   - **Tahap Approval Foto Rangkaian**: Customer dapat melihat foto buket resolusi tinggi yang diunggah florist sebelum dibungkus. Terdapat tombol interaktif **"Setujui Rangkaian"** atau **"Minta Sedikit Revisi via WA"**.

5. **Maja AI Floral Assistant (Floating Widget)**
   - Floating action button bertema Forest Green & Warm Cream.
   - Terintegrasi dengan `GeminiService` (Google Gemini API / Florist fallback knowledge base).
   - Quick chips pertanyaan cepat seputar wisuda, ucapan maaf, dan cara merawat bunga.

6. **Admin Backoffice (`/admin`)**
   - Login terproteksi (`/login` / `/admin/login`).
   - Ringkasan studio: Metrik produk, pesanan aktif, pesanan butuh approval foto, dan total omset.
   - CRUD Produk lengkap dengan upload multi-gambar ke `storage/app/public`.
   - Manajemen Pesanan: Update tahapan status & **Unggah Foto Buket (Kamera/File)** untuk live tracking pelanggan.

---

## 🔑 Kredensial Akun Demo

* **URL Admin Login:** `http://127.0.0.1:8000/login`
* **Email:** `admin@majaflower.com`
* **Password:** `password`

### Contoh Nomor Resi Demo untuk Tracking:
* `MAJA-2026-0001` (Tahap 3: **Approval Foto Hasil Rangkaian** — Terdapat foto resolusi tinggi siap diapprove!)
* `MAJA-2026-0002` (Tahap 5: Dalam Perjalanan Pengiriman)
* `MAJA-2026-0003` (Tahap 6: Pesanan Telah Tiba di Lokasi)

---

## 🛠️ Cara Menjalankan Aplikasi

1. **Jalankan Migration & Seed Data:**
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Buat Symlink Storage:**
   ```bash
   php artisan storage:link
   ```

3. **Build Frontend Assets (Tailwind & Alpine):**
   ```bash
   npm run build
   ```

4. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Buka browser di `http://127.0.0.1:8000`.

5. **Menjalankan Test Otomatis:**
   ```bash
   php artisan test
   ```
