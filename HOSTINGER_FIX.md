# Hostinger Deployment Guide for Laravel

## Kenapa Error "No output directory found after build"?

Hostinger static hosting mencari folder output di root project, tapi Laravel build ke `public/build/`. Solusinya: konfigurasi ulang build command.

---

## 🛠️ SOLUSI

### 1. Update netlify.toml (SUDAH DIUPDATE)
File sudah diperbaiki dengan:
```toml
[build]
  command = "npm run build && php artisan config:cache"
  publish = "public"
```

### 2. Untuk Hostinger VPS/Cloud (PHP Hosting):
Upload file ZIP project ke Hostinger File Manager:
1. Compress semua file project jadi ZIP
2. Upload ke Hostinger → File Manager → public_html
3. Extract ZIP di sana

### 3. Setup Environment di Hostinger:
Buat file `.env` di File Manager dengan isi:
```env
APP_NAME="Kos Harmoni Pro"
APP_ENV=production
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXX
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Jalankan Command di Terminal Hostinger:
```bash
cd public_html
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Set Permissions:
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## 🚀 ALTERNATIF: Deploy ke Railway (REKOMENDASI)

**Lebih mudah daripada Hostinger!**

1. Push ke GitHub (sudah)
2. Buka https://railway.app
3. New Project → Deploy from GitHub
4. Selesai! 🎉

**Keuntungan Railway:**
- Auto-deploy dari GitHub
- Database MySQL gratis
- SSL otomatis
- No "output directory" error

---

## ❌ Kenapa Hostinger Static Gagal?

| Masalah | Penjelasan |
|---------|------------|
| "No output directory" | Hostinger cari `dist/` folder, Laravel build ke `public/build/` |
| Vite build OK tapi error | Hostinger tidak support Laravel runtime |
| Butuh PHP + MySQL | Hostinger static hanya untuk HTML/CSS/JS |

**Solusi:** Pakai Hostinger VPS/Cloud Hosting (bukan static) atau Railway.

---

## ✅ REKOMENDASI

**Gunakan Railway untuk Laravel!** Sudah siap semua config (Dockerfile, railway.json, etc). Tinggal deploy dari GitHub.

Lihat panduan: `DEPLOY_RAILWAY.md`
