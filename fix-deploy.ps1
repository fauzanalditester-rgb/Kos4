# Script Perbaikan Otomatis untuk Deploy Railway
# Jalankan di PowerShell: .\fix-deploy.ps1

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  RAILWAY DEPLOYMENT FIX SCRIPT" -ForegroundColor Cyan
Write-Host "  Laravel Kos Harmoni Pro" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Hapus Migration Duplikat
Write-Host "[1/10] Checking for duplicate migrations..." -ForegroundColor Yellow
$duplicates = @(
    "database\migrations\2026_03_30_112649_create_whatsapp_tables.php"
)

foreach ($file in $duplicates) {
    if (Test-Path $file) {
        Remove-Item $file -Force
        Write-Host "  ✓ Removed duplicate: $file" -ForegroundColor Green
    }
}
Write-Host ""

# 2. Cek dan Fix Dockerfile
Write-Host "[2/10] Checking Dockerfile..." -ForegroundColor Yellow
$dockerfileContent = @"
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \\
    git \\
    curl \\
    libpng-dev \\
    oniguruma-dev \\
    libxml2-dev \\
    zip \\
    unzip \\
    libzip-dev \\
    nginx \\
    supervisor

# Install PHP extensions
RUN docker-php-ext-configure zip \\
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first for better caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copy application files
COPY . .

# Create necessary directories
RUN mkdir -p /var/www/storage/logs /var/www/bootstrap/cache \\
    && chown -R www-data:www-data /var/www \\
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Generate app key
RUN php artisan key:generate --force || true

# Cache config, routes, and views
RUN php artisan config:cache && \\
    php artisan route:cache && \\
    php artisan view:cache

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copy supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port
EXPOSE 80

# Start supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
"@

$dockerfileContent | Out-File -FilePath "Dockerfile" -Encoding UTF8 -Force
Write-Host "  ✓ Dockerfile created/updated" -ForegroundColor Green
Write-Host ""

# 3. Cek dan Buat docker directory & configs
Write-Host "[3/10] Checking docker configurations..." -ForegroundColor Yellow
if (!(Test-Path "docker")) {
    New-Item -ItemType Directory -Path "docker" -Force | Out-Null
}

# Nginx config
$nginxConf = @"
server {
    listen 80;
    server_name localhost;
    root /var/www/public;
    index index.php index.html;

    # Logging
    error_log /var/www/storage/logs/nginx_error.log;
    access_log /var/www/storage/logs/nginx_access.log;

    # Handle Laravel routes
    location / {
        try_files `$uri `$uri/ /index.php?`$query_string;
    }

    # PHP-FPM configuration
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME `$realpath_root`$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;
    }

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }

    # Deny access to storage and bootstrap
    location ~ ^/(storage|bootstrap)/ {
        deny all;
    }

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml application/json application/javascript application/rss+xml application/atom+xml image/svg+xml;
}
"@
$nginxConf | Out-File -FilePath "docker\nginx.conf" -Encoding UTF8 -Force
Write-Host "  ✓ docker/nginx.conf created" -ForegroundColor Green

# Supervisor config
$supervisorConf = @"
[supervisord]
nodaemon=true
user=root
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid

[program:php-fpm]
command=/usr/local/sbin/php-fpm -F
autostart=true
autorestart=true
stdout_logfile=/var/www/storage/logs/php-fpm.log
stderr_logfile=/var/www/storage/logs/php-fpm-error.log
priority=5

[program:nginx]
command=/usr/sbin/nginx -g 'daemon off;'
autostart=true
autorestart=true
stdout_logfile=/var/www/storage/logs/nginx.log
stderr_logfile=/var/www/storage/logs/nginx-error.log
priority=10
"@
$supervisorConf | Out-File -FilePath "docker\supervisord.conf" -Encoding UTF8 -Force
Write-Host "  ✓ docker/supervisord.conf created" -ForegroundColor Green
Write-Host ""

# 4. Cek dan Fix railway.json
Write-Host "[4/10] Checking railway.json..." -ForegroundColor Yellow
$railwayJson = @"
{
  `"`$schema`": "https://railway.app/railway.schema.json",
  "build": {
    "builder": "DOCKERFILE",
    "dockerfilePath": "Dockerfile"
  },
  "deploy": {
    "startCommand": "/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf",
    "healthcheckPath": "/",
    "healthcheckTimeout": 100,
    "restartPolicyType": "ON_FAILURE",
    "restartPolicyMaxRetries": 10
  }
}
"@
$railwayJson | Out-File -FilePath "railway.json" -Encoding UTF8 -Force
Write-Host "  ✓ railway.json created/updated" -ForegroundColor Green
Write-Host ""

# 5. Cek .env.example
Write-Host "[5/10] Checking .env.example..." -ForegroundColor Yellow
if (!(Test-Path ".env.example")) {
    $envExample = @"
APP_NAME="Kos Harmoni Pro"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kos_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
"@
    $envExample | Out-File -FilePath ".env.example" -Encoding UTF8 -Force
    Write-Host "  ✓ .env.example created" -ForegroundColor Green
} else {
    Write-Host "  ✓ .env.example exists" -ForegroundColor Green
}
Write-Host ""

# 6. Cek storage permissions script
Write-Host "[6/10] Creating storage fix script..." -ForegroundColor Yellow
$storageFix = @"
#!/bin/bash
# Fix storage permissions for Railway

mkdir -p /var/www/storage/logs
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/app/public
mkdir -p /var/www/bootstrap/cache

chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache

echo "Storage permissions fixed!"
"@
$storageFix | Out-File -FilePath "fix-storage.sh" -Encoding UTF8 -Force
Write-Host "  ✓ fix-storage.sh created" -ForegroundColor Green
Write-Host ""

# 7. Cek composer.json exist
Write-Host "[7/10] Checking composer.json..." -ForegroundColor Yellow
if (Test-Path "composer.json") {
    Write-Host "  ✓ composer.json exists" -ForegroundColor Green
} else {
    Write-Host "  ✗ composer.json NOT FOUND!" -ForegroundColor Red
    Write-Host "  Please ensure you have a valid Laravel project" -ForegroundColor Red
}
Write-Host ""

# 8. Create .dockerignore
Write-Host "[8/10] Creating .dockerignore..." -ForegroundColor Yellow
$dockerignore = @"
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log
/.fleet
/.idea
/.vscode
node_modules
git
.gitignore
README.md
.DS_Store
"@
$dockerignore | Out-File -FilePath ".dockerignore" -Encoding UTF8 -Force
Write-Host "  ✓ .dockerignore created" -ForegroundColor Green
Write-Host ""

# 9. Create Procfile (fallback)
Write-Host "[9/10] Creating Procfile..." -ForegroundColor Yellow
$procfile = "web: /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf"
$procfile | Out-File -FilePath "Procfile" -Encoding UTF8 -Force
Write-Host "  ✓ Procfile created" -ForegroundColor Green
Write-Host ""

# 10. Summary
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  FIX COMPLETE!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Files created/fixed:" -ForegroundColor White
Write-Host "  ✓ Dockerfile" -ForegroundColor Green
Write-Host "  ✓ railway.json" -ForegroundColor Green
Write-Host "  ✓ docker/nginx.conf" -ForegroundColor Green
Write-Host "  ✓ docker/supervisord.conf" -ForegroundColor Green
Write-Host "  ✓ .env.example (checked)" -ForegroundColor Green
Write-Host "  ✓ .dockerignore" -ForegroundColor Green
Write-Host "  ✓ Procfile" -ForegroundColor Green
Write-Host "  ✓ fix-storage.sh" -ForegroundColor Green
Write-Host ""
Write-Host "Duplicate migrations removed:" -ForegroundColor White
Write-Host "  ✓ 2026_03_30_112649_create_whatsapp_tables.php" -ForegroundColor Green
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  NEXT STEPS:" -ForegroundColor Yellow
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "1. Commit all changes:" -ForegroundColor White
Write-Host "   git add ." -ForegroundColor Cyan
Write-Host "   git commit -m 'Ready for Railway deploy'" -ForegroundColor Cyan
Write-Host "   git push origin main" -ForegroundColor Cyan
Write-Host ""
Write-Host "2. Deploy to Railway:" -ForegroundColor White
Write-Host "   - Open https://railway.app" -ForegroundColor Cyan
Write-Host "   - Login with GitHub" -ForegroundColor Cyan
Write-Host "   - New Project -> Deploy from GitHub repo" -ForegroundColor Cyan
Write-Host "   - Select: fauzanaldi360-bot/koskoskos" -ForegroundColor Cyan
Write-Host "   - Add MySQL Database" -ForegroundColor Cyan
Write-Host "   - Set Environment Variables" -ForegroundColor Cyan
Write-Host ""
Write-Host "3. After deploy, run migrations:" -ForegroundColor White
Write-Host "   railway run php artisan migrate --force" -ForegroundColor Cyan
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
