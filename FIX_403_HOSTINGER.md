# Fix 403 Forbidden di Hostinger

## 🔍 Cara Cek Error di Hostinger

### 1. Cek Error Logs (cPanel)
1. Login cPanel
2. Cari **"Error Logs"** atau **"Errors"
3. Lihat pesan error terbaru

### 2. Cek File Permissions
1. cPanel → **File Manager**
2. Klik kanan folder/file → **Permissions**
3. Pastikan:
   - Folder: **755**
   - File: **644**

### 3. Cek .htaccess
1. File Manager → public_html/
2. Cek file `.htaccess`
3. Pastikan tidak corrupt

---

## 🛠️ Solusi 403 Forbidden

### Solusi 1: Fix Permissions (Paling Umum)
```bash
# Via cPanel Terminal (kalau ada)
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
```

**Via File Manager:**
1. Klik kanan `storage/` → Permissions → 755
2. Klik kanan `bootstrap/cache/` → Permissions → 755
3. Klik kanan `.env` → Permissions → 644

---

### Solusi 2: Fix .htaccess
Buat ulang `.htaccess` di `public_html/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Atau kalau Laravel di subfolder:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

### Solusi 3: Cek index.php
Pastikan `public/index.php` ada dan tidak corrupt.

---

### Solusi 4: PHP Version
1. cPanel → **Select PHP Version**
2. Pilih **PHP 8.3** (bukan 7.x)
3. Enable extensions:
   - pdo
   - pdo_mysql
   - mbstring
   - openssl
   - fileinfo

---

### Solusi 5: Clear Cache
Via cPanel Terminal:
```bash
cd public_html
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📞 Kontak Hostinger Support

Kalau semua sudah dicoba tapi masih 403:

1. **Live Chat**: Dashboard Hostinger → Support → Live Chat
2. **Email**: support@hostinger.co.id
3. **Ticket**: Buka ticket di dashboard

Kasih tahu mereka:
- "Saya deploy Laravel app tapi kena error 403 Forbidden"
- "Sudah cek permissions dan .htaccess"
- Minta mereka cek server error logs

---

## ✅ Checklist Fix 403

- [ ] Folder storage/ permissions 755
- [ ] Folder bootstrap/cache/ permissions 755
- [ ] File .env permissions 644
- [ ] File public/index.php ada
- [ ] .htaccess tidak corrupt
- [ ] PHP Version 8.3
- [ ] Extensions enabled (pdo, pdo_mysql, mbstring)
- [ ] Clear Laravel cache
