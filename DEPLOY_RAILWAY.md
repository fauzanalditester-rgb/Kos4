# 🚀 PANDUAN DEPLOY KE RAILWAY - LARAVEL KOS HARMONI

## 📋 DAFTAR ISI
1. [Persiapan](#1-persiapan)
2. [Push ke GitHub](#2-push-ke-github)
3. [Setup Railway](#3-setup-railway)
4. [Deploy Aplikasi](#4-deploy-aplikasi)
5. [Konfigurasi Database](#5-konfigurasi-database)
6. [Environment Variables](#6-environment-variables)
7. [Migrasi Database](#7-migrasi-database)
8. [Seeding Data](#8-seeding-data)
9. [Verifikasi Deploy](#9-verifikasi-deploy)
10. [Troubleshooting](#10-troubleshooting)

---

## 1. PERSIAPAN

### ✅ Pastikan sudah punya:
- Akun GitHub (https://github.com)
- Akun Railway (https://railway.app) - login dengan GitHub
- Repository GitHub sudah dibuat: `koskoskos`

### 📦 File konfigurasi sudah dibuat:
- `Dockerfile.railway` - Docker config
- `railway.json` - Railway config
- `docker/nginx.conf` - Web server config
- `docker/supervisord.conf` - Process manager

---

## 2. PUSH KE GITHUB

### Langkah 1: Commit semua perubahan
```bash
# Masuk ke folder project
cd C:\Users\Asus\Downloads\kospekanbaru4-lokasi-main

# Inisialisasi git (jika belum)
git init

# Tambahkan semua file
git add .

# Commit dengan pesan
git commit -m "Ready for Railway deployment"

# Buat branch main
git branch -M main

# Tambahkan remote repository
git remote add origin https://github.com/fauzanaldi360-bot/koskoskos.git

# Push ke GitHub
git push -u origin main
```

### ⚠️ Jika error authentication:
1. Pastikan repository `koskoskos` sudah dibuat di GitHub
2. Gunakan Personal Access Token sebagai password
3. Atau setup SSH key untuk GitHub

---

## 3. SETUP RAILWAY

### Langkah 1: Login ke Railway
1. Buka https://railway.app
2. Klik "Login" atau "Get Started"
3. Pilih "Continue with GitHub"
4. Authorize Railway untuk akses repository GitHub

### Langkah 2: Buat Project Baru
1. Di dashboard Railway, klik tombol **"New"** atau **"+"**
2. Pilih **"Deploy from GitHub repo"**
3. Cari repository: `fauzanaldi360-bot/koskoskos`
4. Klik **"Deploy"**

---

## 4. DEPLOY APLIKASI

Railway akan otomatis:
- ✅ Mendeteksi Dockerfile.railway
- ✅ Build container
- ✅ Deploy aplikasi
- ✅ Generate URL public

Tunggu 2-5 menit untuk proses build selesai.

---

## 5. KONFIGURASI DATABASE

### Langkah 1: Tambah MySQL Database
1. Di dashboard project, klik **"New"** atau **"+"**
2. Pilih **"Database"**
3. Pilih **"Add MySQL"**
4. Beri nama: `kos-db`
5. Klik **"Create"**

### Langkah 2: Tunggu Database Ready
- Database akan otomatis setup
- Tunggu status menjadi "Healthy" (hijau)

---

## 6. ENVIRONMENT VARIABLES

Railway akan otomatis generate environment variables untuk MySQL:
- `MYSQLHOST` - Host database
- `MYSQLPORT` - Port (biasanya 3306)
- `MYSQLDATABASE` - Nama database
- `MYSQLUSER` - Username
- `MYSQLPASSWORD` - Password
- `MYSQL_URL` - Full connection string

### Langkah 1: Tambah Variables Laravel
1. Di dashboard project, klik tab **"Variables"**
2. Klik **"New Variable"** atau **"+"**
3. Tambahkan variabel berikut:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}
APP_KEY=(generate dengan: php artisan key:generate --show)

DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}
```

### Langkah 2: Generate APP_KEY
```bash
# Di local machine
php artisan key:generate --show

# Copy hasilnya dan paste ke RAILWAY_VARIABLES sebagai APP_KEY
```

---

## 7. MIGRASI DATABASE

### Langkah 1: Install Railway CLI (Opsional)
```bash
# Install via npm
npm install -g @railway/cli

# Login
railway login

# Link ke project
railway link
```

### Langkah 2: Jalankan Migrasi
**Opsi A: Via Railway CLI**
```bash
railway run php artisan migrate --force
```

**Opsi B: Via Railway Dashboard (Console)**
1. Di dashboard, klik service aplikasi
2. Pilih tab **"Console"**
3. Jalankan command:
```bash
php artisan migrate --force
```

### Langkah 3: Verifikasi Migrasi
```bash
php artisan migrate:status
```

---

## 8. SEEDING DATA

### Jalankan Seeder
```bash
# Via Railway CLI
railway run php artisan db:seed --force

# Atau via Railway Console
php artisan db:seed --force
```

### Data awal yang akan dibuat:
- Admin user: `admin@sewavip.com` / `password`
- Data kamar kos
- Pengaturan default
- dll

---

## 9. VERIFIKASI DEPLOY

### Cek Aplikasi Online
1. Di dashboard Railway, copy **Public Domain**
2. Buka di browser: `https://[your-domain].up.railway.app`
3. Seharusnya muncul halaman login aplikasi

### Cek Login
```
URL: https://[your-domain].up.railway.app
Email: admin@sewavip.com
Password: password
```

### Cek Fitur
- [ ] Dashboard tampil normal
- [ ] Login berhasil
- [ ] Data kamar muncul
- [ ] Navigation menu berfungsi

---

## 10. TROUBLESHOOTING

### ❌ Error: "Connection refused" Database
**Solusi:**
1. Pastikan MySQL sudah "Healthy" (status hijau)
2. Cek environment variables sudah benar
3. Redeploy aplikasi setelah database ready

### ❌ Error: "Permission denied" Storage
**Solusi:**
```bash
# Jalankan di Railway Console
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### ❌ Error: "APP_KEY not set"
**Solusi:**
1. Generate key: `php artisan key:generate --show`
2. Tambahkan ke Railway Variables sebagai `APP_KEY`
3. Redeploy

### ❌ Error: "404 Not Found"
**Solusi:**
1. Cek nginx.conf sudah benar
2. Pastikan `public` folder ada
3. Cek document root di nginx.conf

### ❌ Error: "500 Server Error"
**Solusi:**
```bash
# Cek logs di Railway Console
cat storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### ❌ Build Failed
**Solusi:**
1. Cek Dockerfile.railway tidak ada error
2. Pastikan composer.json valid
3. Cek build logs di Railway dashboard

---

## 🎉 SELAMAT! APLIKASI SUDAH ONLINE

**URL Aplikasi:** `https://[your-domain].up.railway.app`

**Fitur yang tersedia:**
- ✅ Dashboard Admin
- ✅ Manajemen Kamar
- ✅ Manajemen Penyewa
- ✅ Invoice & Pembayaran
- ✅ Laporan Keuangan
- ✅ WhatsApp Manager
- ✅ Mobile Responsive

---

## 📞 BUTUH BANTUAN?

- Railway Docs: https://docs.railway.app
- Laravel Deploy: https://docs.railway.app/guides/laravel
- Railway Discord: https://discord.gg/railway

---

**Dibuat:** 30 Maret 2026
**Versi:** 1.0
**Aplikasi:** Kos Harmoni Pro
