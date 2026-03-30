# Hostinger Business Deployment Script for Windows
# Run: .\build-hostinger-business.ps1

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "  HOSTINGER BUSINESS DEPLOYMENT BUILDER" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan

# 1. Check prerequisites
Write-Host "`n[1/6] Checking prerequisites..." -ForegroundColor Yellow

$hasNpm = Get-Command npm -ErrorAction SilentlyContinue
$hasComposer = Get-Command composer -ErrorAction SilentlyContinue
$hasPhp = Get-Command php -ErrorAction SilentlyContinue

if (-not $hasNpm) {
    Write-Host "ERROR: npm tidak ditemukan! Install Node.js dulu." -ForegroundColor Red
    exit 1
}
if (-not $hasComposer) {
    Write-Host "ERROR: Composer tidak ditemukan! Install Composer dulu." -ForegroundColor Red
    exit 1
}
if (-not $hasPhp) {
    Write-Host "ERROR: PHP tidak ditemukan! Install PHP dulu." -ForegroundColor Red
    exit 1
}

Write-Host "  ✓ npm found: $(npm --version)" -ForegroundColor Green
Write-Host "  ✓ composer found: $(composer --version)" -ForegroundColor Green
Write-Host "  ✓ php found: $(php --version | Select-Object -First 1)" -ForegroundColor Green

# 2. Build assets
Write-Host "`n[2/6] Building assets with Vite..." -ForegroundColor Yellow
npm run build
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Build failed!" -ForegroundColor Red
    exit 1
}
Write-Host "  ✓ Assets built successfully" -ForegroundColor Green

# 3. Install production dependencies
Write-Host "`n[3/6] Installing production dependencies..." -ForegroundColor Yellow
composer install --optimize-autoloader --no-dev --no-interaction
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Composer install failed!" -ForegroundColor Red
    exit 1
}
Write-Host "  ✓ Dependencies installed" -ForegroundColor Green

# 4. Clear caches
Write-Host "`n[4/6] Clearing caches..." -ForegroundColor Yellow
php artisan cache:clear 2>$null
php artisan config:clear 2>$null
php artisan view:clear 2>$null
Write-Host "  ✓ Caches cleared" -ForegroundColor Green

# 5. Create deployment package
Write-Host "`n[5/6] Creating deployment package..." -ForegroundColor Yellow

$deployFolder = "hostinger-deploy"
$zipFile = "kos-harmoni-hostinger.zip"

# Clean up old files
if (Test-Path $deployFolder) {
    Remove-Item $deployFolder -Recurse -Force
}
if (Test-Path $zipFile) {
    Remove-Item $zipFile -Force
}

New-Item -ItemType Directory -Path $deployFolder | Out-Null

# Copy essential files
$folders = @("app", "bootstrap", "config", "database", "lang", "public", "resources", "routes", "storage", "vendor")
$files = @(".env.example", "artisan", "composer.json", "composer.lock", "package.json")

foreach ($folder in $folders) {
    if (Test-Path $folder) {
        Copy-Item $folder "$deployFolder/" -Recurse -Force
        Write-Host "  ✓ Copied: $folder" -ForegroundColor Gray
    }
}

foreach ($file in $files) {
    if (Test-Path $file) {
        Copy-Item $file "$deployFolder/" -Force
        Write-Host "  ✓ Copied: $file" -ForegroundColor Gray
    }
}

# Create .htaccess for public folder
$htaccessPublic = @'
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
$htaccessPublic | Out-File "$deployFolder/public/.htaccess" -Encoding UTF8

# Create root .htaccess (redirect to public)
$htaccessRoot = @'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
'@
$htaccessRoot | Out-File "$deployFolder/.htaccess" -Encoding UTF8

# Create README for deployment
$readme = @'
# DEPLOYMENT INSTRUCTIONS

## Langkah 1: Upload ke Hostinger
1. Upload file ZIP ini ke Hostinger File Manager
2. Extract di folder `public_html/`

## Langkah 2: Setup Database
1. Login cPanel → MySQL Database Wizard
2. Buat database baru (contoh: kos_harmoni)
3. Buat user dan password
4. Add user to database dengan ALL PRIVILEGES

## Langkah 3: Konfigurasi .env
1. Rename `.env.example` menjadi `.env`
2. Edit dengan credential database:
   - DB_DATABASE=your_cpanel_db_name
   - DB_USERNAME=your_cpanel_db_user
   - DB_PASSWORD=your_password
   - APP_URL=https://yourdomain.com

## Langkah 4: Generate Key
Via cPanel Terminal (kalau ada):
```
php artisan key:generate --force
```

Atau via File Manager:
1. Buat file `generate-key.php` dengan isi:
```php
<?php
echo 'APP_KEY=base64:' . base64_encode(random_bytes(32));
```
2. Akses via browser
3. Copy output ke .env

## Langkah 5: Run Migrations
Via cPanel Terminal:
```
php artisan migrate --force
php artisan db:seed --force
```

Atau import database via phpMyAdmin (kalau sudah ada dump SQL).

## Langkah 6: Set Permissions
- storage/ → 755 atau 775
- bootstrap/cache/ → 755 atau 775

## Langkah 7: PHP Version
1. cPanel → Select PHP Version
2. Pilih PHP 8.3 atau 8.4
3. Enable extensions: pdo, pdo_mysql, mbstring, openssl, json, fileinfo, gd, zip, exif, bcmath

## Step 8: SSL
1. cPanel → SSL/TLS
2. Install Let's Encrypt (gratis)

## DONE!
'@
$readme | Out-File "$deployFolder/DEPLOY_README.txt" -Encoding UTF8

Write-Host "  ✓ Deployment package created" -ForegroundColor Green

# 6. Create ZIP
Write-Host "`n[6/6] Creating ZIP archive..." -ForegroundColor Yellow
Compress-Archive -Path "$deployFolder/*" -DestinationPath $zipFile -Force

# Clean up temp folder
Remove-Item $deployFolder -Recurse -Force

# Summary
$zipSize = (Get-Item $zipFile).Length / 1MB
Write-Host "`n==========================================" -ForegroundColor Green
Write-Host "  BUILD SELESAI! ✅" -ForegroundColor Green
Write-Host "==========================================" -ForegroundColor Green
Write-Host "File: $zipFile" -ForegroundColor Cyan
Write-Host "Size: $([math]::Round($zipSize, 2)) MB" -ForegroundColor Cyan
Write-Host "`nLANGKAH BERIKUTNYA:" -ForegroundColor Yellow
Write-Host "1. Upload $zipFile ke Hostinger File Manager" -ForegroundColor White
Write-Host "2. Extract di public_html/" -ForegroundColor White
Write-Host "3. Buat database di cPanel" -ForegroundColor White
Write-Host "4. Edit .env dengan credential DB" -ForegroundColor White
Write-Host "5. Baca DEPLOY_README.txt untuk detail lengkap" -ForegroundColor White
Write-Host "`nSelamat mencoba! 🚀" -ForegroundColor Green
