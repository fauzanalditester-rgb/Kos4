# 🚀 DEPLOY LARAVEL KE HOSTINGER BUSINESS (cPanel)

## ✅ Keuntungan Hostinger Business vs Railway
- **Faster**: Server di Indonesia (lebih cepat untuk user lokal)
- **cPanel**: Interface familiar, mudah manage
- **Email**: Bisa buat email @domainkamu.com
- **Backup**: Auto backup harian
- **Support**: Chat 24/7 bahasa Indonesia

---

## 📋 PRE-REQUISITES

### 1. Pastikan Punya:
- [ ] Hostinger Business Plan aktif
- [ ] Domain sudah pointing ke Hostinger (atau pakai subdomain hostinger)
- [ ] Akses cPanel
- [ ] PHP 8.3+ support (cek di cPanel → Select PHP Version)

### 2. Persiapkan di Local:
```bash
# Build asset production
npm run build

# Optimasi untuk production
composer install --optimize-autoloader --no-dev

# Buat .env.production
cp .env.example .env.production
```

---

## 🛠️ STEP-BY-STEP DEPLOYMENT

### STEP 1: Build & Package Aplikasi (LOCAL)

Jalankan script ini di PowerShell:

```powershell
# Build untuk production
npm run build

# Install dependencies production only
composer install --optimize-autoloader --no-dev

# Create zip untuk upload
Compress-Archive -Path "*" -DestinationPath "kos-harmoni-deploy.zip" -Force
```

**Atau** buat script otomatis:

```powershell
# build-hostinger-business.ps1
Write-Host "=== BUILD UNTUK HOSTINGER BUSINESS ===" -ForegroundColor Green

# 1. Build asset
Write-Host "Building assets..." -ForegroundColor Yellow
npm run build

# 2. Install production dependencies
Write-Host "Installing production dependencies..." -ForegroundColor Yellow
composer install --optimize-autoloader --no-dev --no-interaction

# 3. Clear caches
Write-Host "Clearing caches..." -ForegroundColor Yellow
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 4. Create deploy folder
$deployFolder = "deploy-hostinger"
if (Test-Path $deployFolder) {
    Remove-Item $deployFolder -Recurse -Force
}
New-Item -ItemType Directory -Path $deployFolder

# 5. Copy essential files
Write-Host "Copying files..." -ForegroundColor Yellow
$filesToCopy = @(
    "app", "bootstrap", "config", "database", "lang", "public", 
    "resources", "routes", "storage", "vendor",
    ".env.example",
    "artisan", "composer.json", "composer.lock", "package.json"
)

foreach ($file in $filesToCopy) {
    if (Test-Path $file) {
        Copy-Item $file $deployFolder -Recurse -Force
        Write-Host "  ✓ $file" -ForegroundColor Gray
    }
}

# 6. Create .htaccess for public folder
$htaccess = @'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# PHP Settings
php_value upload_max_filesize 64M
php_value post_max_size 64M
php_value memory_limit 256M
php_value max_execution_time 300
php_value max_input_time 300
'@

$htaccess | Out-File "$deployFolder/public/.htaccess" -Encoding UTF8

# 7. Create database import file reminder
$dbNote = @"
# DATABASE SETUP REMINDER

1. Buat database di cPanel → MySQL Database Wizard
2. Import file SQL (kalau ada data)
3. Update .env dengan credential database

ATAU jalankan migration via terminal Hostinger (jika tersedia):
php artisan migrate --force
"@

$dbNote | Out-File "$deployFolder/DATABASE_SETUP.txt" -Encoding UTF8

# 8. Create zip
Write-Host "Creating zip archive..." -ForegroundColor Yellow
Compress-Archive -Path "$deployFolder\*" -DestinationPath "kos-harmoni-hostinger.zip" -Force

Write-Host "`n✅ BUILD SELESAI!" -ForegroundColor Green
Write-Host "File zip: kos-harmoni-hostinger.zip" -ForegroundColor Cyan
Write-Host "`nLANGKAH BERIKUTNYA:" -ForegroundColor Yellow
Write-Host "1. Upload ke Hostinger File Manager (public_html)" -ForegroundColor White
Write-Host "2. Extract zip di public_html" -ForegroundColor White
Write-Host "3. Pindahkan isi public/ ke root (atau bikin subdomain)" -ForegroundColor White
Write-Host "4. Buat database di cPanel" -ForegroundColor White
Write-Host "5. Update .env dengan credential DB" -ForegroundColor White
Write-Host "6. Jalankan: php artisan migrate --force" -ForegroundColor White
```

---

### STEP 2: Upload ke Hostinger

**Opsi A: File Manager (Recommended)**
1. Login cPanel → **File Manager**
2. Masuk folder `public_html`
3. Klik **Upload** → Pilih `kos-harmoni-hostinger.zip`
4. Klik kanan file zip → **Extract**
5. Pindahkan isi folder `public/` ke root `public_html/`

**Opsi B: FTP (FileZilla)**
```
Host: ftp.yourdomain.com (atau IP server)
Username: (dari cPanel → FTP Accounts)
Password: (password FTP kamu)
Port: 21
```
Upload ke folder `public_html`

---

### STEP 3: Setup Database (cPanel)

1. cPanel → **MySQL Database Wizard**
2. **Step 1**: Buat database
   - Database Name: `kos_harmoni` (atau sesuai keinginan)
   - Hasil: `username_kos_harmoni`

3. **Step 2**: Buat user
   - Username: `kosharmoni_user`
   - Password: (generate strong password)
   - **SIMPAN PASSWORD!**

4. **Step 3**: Add user to database
   - Centang **ALL PRIVILEGES**
   - Click **Make Changes**

5. **Step 4**: Import SQL (jika ada data)
   - cPanel → **phpMyAdmin**
   - Pilih database kamu
   - Tab **Import** → Choose File → `database.sql`

---

### STEP 4: Konfigurasi .env

Edit file `.env` di File Manager:

```env
APP_NAME="Kos Harmoni Pro"
APP_ENV=production
APP_KEY=base64:GENERATE_NEW_KEY
APP_DEBUG=false
APP_URL=https://yourdomain.com

# DATABASE - sesuaikan dengan yang dibuat di cPanel
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_kos_harmoni
DB_USERNAME=username_kosharmoni_user
DB_PASSWORD=password_yang_dibuat

# MAIL (optional - untuk notifikasi)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# WHATSAPP (jika pakai)
WHATSAPP_API_KEY=your_api_key
WHATSAPP_API_URL=https://api.wa.my.id/

# MIDTRANS (untuk payment)
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false
```

---

### STEP 5: Set Permissions & Generate Key

**Via cPanel Terminal** (kalau ada) atau **File Manager**:

```bash
# Generate app key
php artisan key:generate --force

# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage permissions (kalau bisa via terminal)
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

**Via File Manager:**
1. Klik kanan folder `storage/` → **Permissions** → 755
2. Klik kanan folder `bootstrap/cache/` → **Permissions** → 755

---

### STEP 6: Run Migrations

**Via cPanel Terminal** (kalau tersedia):
```bash
cd public_html
php artisan migrate --force
php artisan db:seed --force
```

**Via phpMyAdmin** (kalau tidak ada terminal):
1. Export database lokal dulu:
   ```bash
   php artisan migrate
   php artisan db:seed
   mysqldump -u root -p kos_harmoni > kos_harmoni.sql
   ```
2. Import ke Hostinger via phpMyAdmin

---

### STEP 7: Configure PHP Version

1. cPanel → **Select PHP Version**
2. Pilih **PHP 8.3** atau **8.4**
3. Centang extensions:
   - [x] `pdo`
   - [x] `pdo_mysql`
   - [x] `mbstring`
   - [x] `openssl`
   - [x] `json`
   - [x] `fileinfo`
   - [x] `gd`
   - [x] `zip`
   - [x] `exif`
   - [x] `bcmath`
   - [x] `xml`
4. Click **Set as current**

---

### STEP 8: SSL & HTTPS

1. cPanel → **SSL/TLS** atau **SSL/TLS Status**
2. Klik **AutoSSL** atau install SSL Let's Encrypt gratis
3. Pastikan domain bisa https://
4. Update `.env`:
   ```env
   APP_URL=https://yourdomain.com
   ```

---

## 🎯 STRUKTUR FOLDER DI HOSTINGER

```
public_html/
├── .env                    # Environment config
├── .htaccess              # Rewrite rules (root redirect ke public)
├── artisan                # Artisan CLI
├── composer.json          # Dependencies
├── index.php              # Entry point (copy dari public/)
├── app/                   # Application code
├── bootstrap/             # Bootstrap files
├── config/                # Configuration
├── database/              # Migrations & seeds
├── public/                # Public assets (css, js, images)
├── resources/             # Views & assets source
├── routes/                # Routes
├── storage/               # Logs, cache, uploads
├── vendor/                # Composer dependencies
└── ...
```

---

## 🔧 HTACCESS ROOT (Redirect ke public/)

Buat `.htaccess` di root `public_html/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**ATAU** struktur subdomain lebih aman:

---

## 🚀 DEPLOY VIA SUBDOMAIN (Recommended)

Lebih rapi dan aman:

1. cPanel → **Subdomains**
2. Buat: `kos.yourdomain.com`
3. Document Root: `public_html/kos/public`

Struktur folder:
```
public_html/
└── kos/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/          ← Root subdomain pointing here
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env
    └── artisan
```

---

## ✅ CHECKLIST DEPLOYMENT

- [ ] Build asset production (`npm run build`)
- [ ] Upload files ke Hostinger
- [ ] Setup MySQL database
- [ ] Konfigurasi `.env`
- [ ] Set folder permissions 755
- [ ] Generate app key
- [ ] Run migrations
- [ ] Konfigurasi PHP 8.3
- [ ] Install SSL
- [ ] Test login admin
- [ ] Test fitur utama

---

## 🐛 TROUBLESHOOTING

### Error 500 Internal Server Error
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### Database Connection Error
- Cek `.env` DB_HOST harus `localhost` (bukan 127.0.0.1)
- Cek username database format: `cpaneluser_dbname`

### Permission Denied
- Folder `storage/` dan `bootstrap/cache/` harus 755 atau 775

### White Screen
- Cek `APP_DEBUG=false` di production
- Cek `APP_KEY` sudah digenerate

### Assets tidak load (404)
- Pastikan `npm run build` sudah dijalankan
- Cek `public/build/` ada file manifest.json

---

## 📞 SUPPORT HOSTINGER

Kalau stuck, kontak Hostinger support:
- **Live Chat**: Dashboard Hostinger → Support
- **WhatsApp**: +62-xxx (lihat di dashboard)
- **Email**: support@hostinger.co.id

---

## 🎉 SELESAI!

Aplikasi Laravel siap jalan di Hostinger Business! 🚀
