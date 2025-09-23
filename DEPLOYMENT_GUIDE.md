# Panduan Deploy TokoDeden ke Production

## 1. Konfigurasi .env untuk Production

Pastikan file `.env` di server production memiliki konfigurasi berikut:

```bash
APP_NAME=TokoDeden
APP_ENV=production
APP_KEY=base64:KRYrkjRKvidh/uPM1oloIJ0vQTK/MI1ZKtFBEfA4n3k=
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
APP_URL=https://tokodeden.page

# Database (sesuaikan dengan hosting Anda)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database_production
DB_USERNAME=username_database_production
DB_PASSWORD=password_database_production

# Session Configuration untuk Production
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.tokodeden.page
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# CSRF Protection untuk Production
SANCTUM_STATEFUL_DOMAINS=tokodeden.page,www.tokodeden.page

# Logging untuk Production
LOG_CHANNEL=stack
LOG_LEVEL=error

# Mail Configuration
MAIL_FROM_ADDRESS="noreply@tokodeden.page"
MAIL_FROM_NAME="${APP_NAME}"
```

## 2. Commands yang Harus Dijalankan di Server Production

```bash
# 1. Install dependencies
composer install --no-dev --optimize-autoloader

# 2. Generate application key (jika belum ada)
php artisan key:generate

# 3. Cache configuration
php artisan config:cache

# 4. Cache routes
php artisan route:cache

# 5. Cache views
php artisan view:cache

# 6. Optimize autoloader
composer dump-autoload --optimize

# 7. Migrate database
php artisan migrate --force

# 8. Seed database (jika diperlukan)
php artisan db:seed --force

# 9. Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 10. Link storage
php artisan storage:link
```

## 3. Permissions yang Diperlukan

```bash
# Set permissions untuk directory Laravel
chmod -R 755 /path/to/your/laravel/project
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data /path/to/your/laravel/project
```

## 4. Troubleshooting "Unauthorized action"

Masalah ini biasanya disebabkan oleh:

1. **CSRF Token Mismatch**: Session domain tidak cocok
2. **HTTPS Configuration**: Cookie secure settings
3. **Proxy Configuration**: TrustProxies middleware tidak dikonfigurasi dengan benar

### Solusi:

1. Pastikan `SESSION_DOMAIN=.tokodeden.page` di file .env
2. Pastikan `APP_URL=https://tokodeden.page`
3. Pastikan `SANCTUM_STATEFUL_DOMAINS=tokodeden.page,www.tokodeden.page`
4. Clear cache setelah mengubah konfigurasi

## 5. File .htaccess untuk Apache (jika menggunakan Apache)

```apache
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
```

## 6. Cek Status Deployment

Setelah deployment, cek hal-hal berikut:

1. `https://tokodeden.page` dapat diakses
2. Login/logout berfungsi normal
3. CSRF token bekerja (form submission tidak error)
4. Session persistent
5. Database connection bekerja
6. File upload/download berfungsi

## 7. Monitoring dan Logs

- Check error logs: `tail -f storage/logs/laravel.log`
- Check web server logs (Apache/Nginx)
- Monitor disk space untuk session files
- Monitor database connections
