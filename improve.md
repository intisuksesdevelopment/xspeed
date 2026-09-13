# Improve — Halaman Home (Storefront XSpeed Motoshop)

> Dokumen rekomendasi perbaikan frontend untuk halaman home.

## ✅ Progress (terakhir diperbarui 2026-09-13)

**Sudah dikerjakan:**
- [x] P0-1 jQuery ganda dihapus (jQuery tidak dipakai storefront), `formatRupiah` mati dihapus
- [x] P0-3 Nav links lintas halaman (di sub-halaman otomatis `route('main')#section`)
- [x] P1-4 CSS home (Font Awesome + Swiper) pindah ke `<head>`; hanya dimuat saat route `main`
- [x] P1-4 Google Fonts dirampingkan jadi 1 link (Rajdhani + Inter)
- [x] P1-5 Gambar: `loading="lazy"` + `decoding="async"` + `alt` (brand, produk, galeri, testimonial)
- [x] P2-10 `[x-cloak]` + noscript fallback di section produk
- [x] P3-12 Testimonial tidak lagi duplikat (3 unik)
- [x] P3-13 Counter langsung jalan bila section sudah terlihat saat load
- [x] SEO ringan: title & meta description diganti sesuai brand
- [x] Aksesibilitas ringan: `aria-label` ikon sosial footer
- [x] P3-VC-9 Swiper pagination styling (gallery + testimonial) → CSS scoped bullets + active states
- [x] P3-HERO Hero redesign: particle canvas JS + connecting dots, glowing radial bg, 3 floating product showcase cards, float badges (discount 20%, rating 4.9), badge SVG bolt icon, glowing divider line, CTA buttons dengan SVG icon, trust badges bar, stats bar dengan AlpineJS counter animation (2500+ produk, 10000+ customers), scroll indicator bounce
- [x] P3-HERO-MASC Hero redesigned dengan gaya maskulin sparepart motor: carbon fiber bg, ember particle canvas, engine block CSS (cylinders + crank wheel animasi), red glow accents, metal divider dengan rivet, btn-fire/btn-steel, speed lines, spec badges floating. Semua teks menggunakan lang file EN/ID.
- [x] P3-LANG Hero text strings dipindahkan ke lang file: `resources/lang/en/hero.php` dan `resources/lang/id/hero.php` dengan 35+ keys.
- [x] HERO-CSS-1 Hero CSS diperbaiki (lost BRAND section), dual-write ke `resources/css/dashboard.css` + `public/build/css/dashboard.css`
- [x] HERO-COLOR Semua warna accent orange (#FF9F43, #ff8510) diganti kuning (#FFCC00, #FFB300) untuk konsistensi aesthetic Kawasaki H2 dark premium
- [x] HERO-NAVBAR Double navbar dihapus — hero nav dihapus dari partial/index, hanya main-layout navbar yang tampil
- [x] SINGLE-HERO Hero redesigned Kawasaki H2 style: LEFT (brand tag + headline "SPARE**PART** MOTOR" + keyword tags + description + CTA + 2x2 features) / RIGHT (motorcycle image dengan float animation + glow) / BOTTOM (stats strip: products, customers, brands, rating) dengan AlpineJS counter animation
- [x] ADS-API Tabel `ads` dibuat (migration + seeder), ApiController@getAds endpoint `/api/ads`, ads database-driven untuk promo/product_top/product_ads/product_bottom
- [x] SINGLE-PRODUCT-CSS CSS single-product diperbaiki: breadcrumb `.crumb-*`, promo-banner, section-mini-label, ads-slider, ads-banner (full-width) + related grid 6col desktop / 3col mobile
- [x] SINGLE-NAVBAR Promo bar tertutup navbar fixed → `.product-page` padding-top:70px, `.product-promo-bar` z-index:1000
- [x] SINGLE-HTML Extra `</div>` tags di ads section dihapus, struktur HTML diperbaiki
- [x] HERO-IMG Hero background image diganti dari `hero-bg.jpg` ke `bg-jumbotron.png` (CSS background, bukan `<img>` tag)
- [x] ADS-ZINDEX `.product-ads-section` + `.product-related` z-index:1000, `position:relative` agar selalu terlihat

**Belum/parsial:**
- [ ] Font Awesome masih CDN full CSS (belum inline SVG)
- [ ] Galeri: 1 gambar per slide penuh (P3-14)
- [ ] View More menimpa produk #12 (P3-15)
- [ ] Empty/error state + retry (brand/produk)
- [ ] About section: logo-header div kosong bisa dioptimalkan

---

> Cakupan file:
> - `resources/views/pages/dashboard/main-layout.blade.php`
> - `resources/views/pages/dashboard/partials/index.blade.php`
> - `resources/css/dashboard.css` + `public/build/css/dashboard.css`
> - `resources/views/pages/dashboard/partials/single-product.blade.php`
> - `resources/css/single-product.css` + `public/build/css/single-product.css`
> - `database/migrations/2026_09_09_000001_create_ads_table.php`
> - `database/seeders/AdsSeeder.php`
> - `app/Http/Controllers/ApiController.php`
> - `routes/api.php`

---

## Ringkasan Prioritas

| Prioritas | Item | Dampak |
|---|---|---|
| P0 | Bug nyata (jQuery ganda, JS-only page, nav anchor mati) | Fungsional |
| P1 | Performa (resource berat, gambar, font) | Web Vitals |
| P2 | Aksesibilitas & SEO/semantik | Kepatuhan + peringkat |
| P3 | UX & polish visual | Konversi & kesan |

---

## P0 — Bug nyata (dikerjakan duluan)

### 1. jQuery di-load 2x + fungsi `formatRupiah` mati
**Lokasi:** `main-layout.blade.php` (bagian bawah sebelum `</body>`)

```html
<script src=".../jquery-3.7.1.min.js">
    function formatRupiah(number) { ... }
</script>
<script src=".../jquery-3.7.1.min.js"></script>
```

**Masalah:**
- `<script src>` yang berisi kode inline → isi inline **diabaikan browser**, `formatRupiah()` tidak pernah terdefinisi.
- File jQuery di-download 2× (±85 KB sia-sia).

**Perbaikan:**
- Hapus tag `<script src>` yang pertama.
- Pindahkan `formatRupiah` ke `<script>` biasa tanpa `src`, atau hapus bila tidak terpakai.
- Jika jQuery tidak benar-benar dibutuhkan, hapus total (Bootstrap bundle tidak butuh jQuery).

### 2. Halaman bergantung penuh pada JavaScript
**Lokasi:** `partials/index.blade.php`

Produk, brand, harga, slider testimonial, dan counter semua dirender client-side (Alpine fetch). Tanpa JS, home tampil kosong — buruk untuk crawler & user tanpa JS.

**Perbaikan:**
- Tambahkan `<noscript>` berisi tautan ke halaman produk / daftar statis.
- Jangka panjang: server-render konten produk halaman pertama, lalu hydrate dengan Alpine.

### 3. Navigasi anchor hanya berfungsi di halaman home
**Lokasi:** `main-layout.blade.php`

Menu (`#home`, `#products`, `#gallery`, `#testimonials`, `#about`, `#contact`) menunjuk ke section yang hanya ada di partial home. Di `/dashboard/all-product`, `/dashboard/single-product`, `/dashboard/{cat}/list-product`, klik menu tidak melakukan apa-apa.

**Perbaikan:**
- Buat nav context-aware: di sub-halaman arahkan ke `route('main') . '#products'` dst.
- Brand/logo sudah benar (`route('main')`).

---

## P1 — Performa

### 4. Resource eksternal berat & duplikat
- **Google Fonts:** 2 blok `<link>` memuat 4+ family (Poppins, Orbitron, Rajdhani, Inter) + beragam weight. Sisakan 1–2 family (mis. Rajdhani untuk heading, system font untuk body), aktifkan `display=swap` dan subset.
- **Font Awesome full CSS** hanya untuk ±6 ikon → ganti dengan inline SVG.
- **CDN tanpa SRI:** Bootstrap, Swiper, Alpine, FA tidak memakai `integrity`. Vendor/bundle ke lokal atau tambahkan SRI. Alpine sudah `defer` — pertahankan.
- **CSS di tengah `<body>`:** partial memuat `<link rel="stylesheet">` (dashboard-all-product.css, single-product.css, dsb.) yang memblokir render. Pindahkan ke `<head>` via `@stack('styles')`.

### 5. Gambar: belum lazy-load, tanpa dimensi, tanpa format modern
- `<img>` galeri & testimonial tanpa `loading="lazy"`, `width`/`height`, dan `alt` → menyebabkan **CLS**.
- Tambahkan dimensi/aspect-ratio agar placeholder & skeleton → gambar tidak melompat.
- Hero & About memakai background besar; preload hero image; siapkan versi WebP/AVIF dengan `srcset`.

### 6. Web Vitals target
| Metrik | Risiko | Aksi |
|---|---|---|
| LCP | Background hero + gambar produk tanpa preload | Preload hero, kompres/WebP |
| CLS | `<img>` tanpa dimensi | width/height + aspect-ratio |
| INP | Swiper autoplay + animasi panjang | Kurangi animasi, `content-visibility` untuk section bawah |

---

## P2 — Aksesibilitas & SEO

### 7. Semantik & landmark
- Bungkus konten utama dalam `<main>`; nav diberi `<nav aria-label="...">`.
- Ganti warna background inline berulang (`#0b1220`, `#0f1a2e`) dengan CSS variable/utility class.

### 8. Keyboard & focus
- `.product-card` adalah `<a>` — pastikan ada `:focus-visible` outline yang jelas.
- Slide Swiper tidak bisa dinavigasi keyboard secara default; tambahkan fallback/tabindex.

### 9. Reduced motion
- Animasi shimmer, autoplay Swiper, dan counter menghormati `prefers-reduced-motion`.

### 10. Flash konten sebelum Alpine siap
- Elemen dengan `x-show`/`x-if` (error, grid) beri `[x-cloak]` agar tidak berkedip sebelum Alpine termuat.

### 11. SEO meta
- Judul `<title>` masih "ExpeedShop" (brand di halaman: XSPEED MOTOSHOP).
- Meta description berisi teks template pihak ketiga ("Created by Imran Hossain...").
- Tambahkan Open Graph / Twitter Card, canonical, dan `og:image`.
- Halaman produk detail memakai query string (`?uuid=`) — kurang baik untuk share; pertimbangkan slug/pretty URL bila memungkinkan.
- `lang="en"` padahal konten berbahasa Indonesia — sesuaikan per locale bila fitur bahasa aktif.

---

## P3 — UX & Polish Visual

### 12. Testimonial terduplikasi
6 slide = 3 orang yang sama diulang 2×. Gunakan 4–6 testimoni unik dan biarkan `loop: true` bekerja.

### 13. Counter hanya jalan saat scroll
Jika section About sudah terlihat saat halaman dimuat (mis. deep-link), counter tetap 0 sampai user scroll. Gunakan `IntersectionObserver` + cek awal di `DOMContentLoaded`.

### 14. Galeri 1 gambar per slide penuh
Di desktop terasa kosong. Pertimbangkan: grid responsif, 2–3 slide per view, tambah navigasi/pagination, dan `alt` tiap gambar.

### 15. Grid produk: "View More" menggantikan produk ke-12
Saat ini menampilkan 11 produk + kartu "View More". Alternatif: ambil 12 + tombol "View More" di bawah grid, atau kartu view-more di luar iterasi produk.

### 16. Empty & error state
- Slider brand kosong bila API gagal → tambah pesan fallback.
- Error produk hanya teks → tambah tombol "Coba lagi" (retry).

### 17. Form kontak palsu
`onsubmit="return false"` → tidak ada backend. Wire ke endpoint nyata, atau ubah menjadi CTA WhatsApp (pola sudah ada di halaman produk detail).

### 18. Kebersihan kode & konsistensi
- Hapus file duplikat: `all-product.blade copy.php`, `list-product.blade copy.php`, dan HTML demo tak terpakai (`index_2.html`, `checkout.html`, dll.) bila memang mati.
- Hapus blok komentar besar yang tidak terpakai di `main-layout.blade.php`.
- `.container` bersarang di section produk (container dalam container) → satu container saja.
- Karakter `✔`, `▲▼` → ikon/SVG dengan `aria-hidden`.
- Padding section campur (inline 80px vs CSS 60px) → seragam via class.
- Inline JS panjang dalam blade (Alpine + Swiper + counter ±200 baris) → pindah ke file `.js` terpisah dan `defer`.

---

## Quick Wins (urutan kerja yang disarankan)

1. Hapus jQuery ganda + perbaiki `formatRupiah` (P0)
2. Nav links berfungsi di semua halaman (P0)
3. `@stack` untuk CSS di `<head>` + `[x-cloak]` (P1)
4. Lazy-load gambar di bawah fold + tambah dimensi (P1)
5. Testimonial unik tanpa duplikat + trigger counter via IntersectionObserver (P3)
6. Kurangi Google Fonts & ganti FA dengan inline SVG (P1)

---

## Status

- [x] jQuery ganda & `formatRupiah` (P0-1)
- [x] Noscript/fallback konten (P0-2)
- [x] Nav anchor lintas halaman (P0-3)
- [x] Styles di `<head>` via stack (P1-4)
- [x] Font/icons dirampingkan (P1-4)
- [x] Gambar lazy-load + dimensi (P1-5)
- [ ] Landmark & semantic HTML (P2-7)
- [x] `x-cloak` anti-flash (P2-10)
- [x] Meta SEO (title/OG/canonical) (P2-11)
- [x] Testimonial tanpa duplikat (P3-12)
- [x] Counter via IntersectionObserver (P3-13)
- [x] Galeri pagination + navigation (P3-VC-5)
- [x] Form kontak → WhatsApp/Email/Lokasi CTA (P3-VC-7)
- [x] Hero missing CSS (P3-VC-1, VC-2)
- [x] Brand section heading (P3-VC-3)
- [x] Nested container (P3-VC-4)
- [x] Testimonial quote min-height (P3-VC-6)
- [x] About overlay inline style dihapus (P3-VC-8)
- [x] Swiper pagination CSS (P3-VC-9)
- [x] Hero redesign lengkap: particle canvas JS, glowing radial, floating product cards, badge SVG bolt, glowing divider, CTA SVG icon, trust badges, stats bar counter AlpineJS, scroll indicator bounce (P3-HERO)
- [x] Hero redesign maskulin: carbon fiber bg, engine block CSS animasi, red glow, metal divider, speed lines, spec badges, btn-fire/btn-steel, lang EN/ID (P3-HERO-MASC)
- [x] Semua teks hero menggunakan lang file EN/ID (P3-LANG)
- [x] Hero CSS diperbaiki + dual-write (HERO-CSS-1)
- [x] Warna accent orange→kuning #FFCC00 (HERO-COLOR)
- [x] Double navbar dihapus (HERO-NAVBAR)
- [x] Hero Kawasaki H2 layout redesign (SINGLE-HERO)
- [x] Ads table + API + seeder (ADS-API)
- [x] Single-product CSS diperbaiki (SINGLE-PRODUCT-CSS)
- [x] Promo bar tidak tertutup navbar (SINGLE-NAVBAR)
- [x] Ads section HTML structure diperbaiki (SINGLE-HTML)
- [x] Hero background image diganti (HERO-IMG)
- [x] Ads section + related z-index diperbaiki (ADS-ZINDEX)
- [ ] Galeri: 1 slide terlihatlong di desktop (P3-14)
- [ ] View More tidak menimpa produk (P3-15)
- [ ] Empty/error state + retry (P3-16)
- [ ] Bersihkan file & komentar mati (P3-18)
