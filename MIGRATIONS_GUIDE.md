# Laravel Migrations Guide for Hostinger

## 🎯 Kenapa Migrations Lebih Baik

- **Version Control**: Semua perubahan database tercatat di git
- **Rollback**: Bisa undo kalau ada error
- **Teamwork**: Tim bisa sync database structure
- **Auto Setup**: Deploy ke server baru tinggal `migrate`
- **Seed Data**: Data awal bisa diisi otomatis

---

## 🚀 Cara Run Migrations di Hostinger

### Step 1: Pastikan Database Sudah Dibuat
```
cPanel → MySQL Database Wizard
✓ Database: u353387484_koskosan (sudah kamu buat)
✓ Username: u353387484_koskosan
✓ Password: OOcw0cMn?2Vo
```

### Step 2: Akses cPanel Terminal (Kalau Ada)
```
cPanel → Advanced → Terminal
```

**Jika Terminal tersedia:**
```bash
cd public_html
php artisan migrate --force
php artisan db:seed --force
```

### Step 3: Kalau Tidak Ada Terminal (Alternatif)

#### Opsi A: Buat PHP Script Migration

Buat file `run-migrations.php` di `public_html/`:

```php
<?php
// Run Laravel migrations via browser
// Akses: https://antirugi.app/run-migrations.php
// HAPUS file ini setelah selesai!

ini_set('max_execution_time', 300);

// Set working directory
chdir(__DIR__);

// Load Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h1>Running Laravel Migrations...</h1>";

// Run migrations
try {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "<p style='color: green;'>✅ Migrations: " . \Illuminate\Support\Facades\Artisan::output() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Migration Error: " . $e->getMessage() . "</p>";
}

// Run seeders
try {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    echo "<p style='color: green;'>✅ Seeders: " . \Illuminate\Support\Facades\Artisan::output() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Seeder Error: " . $e->getMessage() . "</p>";
}

// Clear cache
try {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    echo "<p style='color: blue;'>✅ Cache cleared</p>";
} catch (Exception $e) {
    // Ignore
}

echo "<hr><p><strong>🎉 Done! DELETE this file now for security!</strong></p>";
echo "<p>Delete: run-migrations.php</p>";
```

**Akses via browser:**
```
https://antirugi.app/run-migrations.php
```

**Setelah selesai → DELETE file ini!** (security risk)

---

#### Opsi B: Export SQL dari Local (Cepat)

**Jika migrations tidak bisa jalan di Hostinger:**

**1. Di Local (PowerShell):**
```bash
# Setup database local dulu
php artisan migrate
php artisan db:seed

# Export ke SQL
mysqldump -u root -p kos_harmoni > kos_harmoni_dump.sql
```

**2. Upload SQL ke Hostinger:**
```
cPanel → phpMyAdmin → Import → kos_harmoni_dump.sql
```

**3. Selesai!** Database sudah ada struktur + data.

---

## 📋 Checklist Migrations

- [ ] Database sudah dibuat di cPanel
- [ ] `.env` sudah diisi credential database
- [ ] `APP_KEY` sudah digenerate
- [ ] Pilih metode: Terminal / PHP Script / SQL Import
- [ ] Jalankan migrations
- [ ] Jalankan seeders
- [ ] Clear cache
- [ ] Test login admin
- [ ] **Hapus file migration script (security)**

---

## 🔧 Troubleshooting Migrations

### Error: "Table already exists"
```bash
# Drop all tables dulu
php artisan migrate:fresh --force
php artisan db:seed --force
```

### Error: "Access denied for user"
- Cek `.env` DB_USERNAME dan DB_PASSWORD
- Pastikan user punya ALL PRIVILEGES di cPanel

### Error: "Class not found"
```bash
php artisan optimize:clear
composer dump-autoload
```

### Error: "Maximum execution time"
- Edit `php.ini` via cPanel → Select PHP Version → Options
- Naikkan `max_execution_time` ke 300

---

## 🎉 Setelah Migrations Berhasil

Login admin:
- **URL**: `https://antirugi.app/login`
- **Email**: `admin@sewavip.com`
- **Password**: `password`

**DONE!** 🚀
