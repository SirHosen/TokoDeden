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

# Database Configuration (PENTING: Ganti dengan kredensial database Anda!)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=twbkawuu_tokodeden
DB_USERNAME=twbkawuu_user
DB_PASSWORD=skripsiferi

# Session Configuration untuk Production
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=tokodeden.page
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
php artisan route:cache

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

# 10. Link storage (PENTING!)
php artisan storage:link

# 11. Fix storage permissions
chmod -R 755 storage/
chmod -R 755 public/storage/
```

## 3. Permissions yang Diperlukan

```bash
# Set permissions untuk directory Laravel
chmod -R 755 /path/to/your/laravel/project
chmod -R 775 storage bootstrap/cache public/storage
chown -R www-data:www-data /path/to/your/laravel/project

# Khusus untuk shared hosting, pastikan:
chmod -R 755 public/storage/
chmod -R 755 storage/app/public/
```

## 4. Troubleshooting "Unauthorized action"

Masalah ini biasanya disebabkan oleh:

1. **CSRF Token Mismatch**: Session domain tidak cocok
2. **HTTPS Configuration**: Cookie secure settings
3. **Proxy Configuration**: TrustProxies middleware tidak dikonfigurasi dengan benar

### Solusi:

1. **Pastikan SESSION_DOMAIN TANPA titik di awal**: `SESSION_DOMAIN=tokodeden.page` (BUKAN `.tokodeden.page`)
2. Pastikan `APP_URL=https://tokodeden.page`
3. Pastikan `SANCTUM_STATEFUL_DOMAINS=tokodeden.page,www.tokodeden.page`
4. Clear cache setelah mengubah konfigurasi:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan config:cache
   ```

## 5. Troubleshooting "403 Forbidden Storage"

Masalah `GET https://tokodeden.page/storage/ 403 (Forbidden)` disebabkan oleh:

1. **Storage link tidak dibuat**: `php artisan storage:link`
2. **Permission salah**: File/folder tidak dapat diakses web server
3. **Symlink rusak**: Link simbolik tidak valid

### Solusi:

```bash
# 1. Buat ulang storage link
rm -rf public/storage
php artisan storage:link

# 2. Set permission yang benar
chmod -R 755 storage/app/public/
chmod -R 755 public/storage/

# 3. Pastikan ownership correct (di shared hosting mungkin tidak perlu)
chown -R www-data:www-data storage/
chown -R www-data:www-data public/storage/

# 4. Test akses manual
# Buka https://tokodeden.page/storage/test.txt (buat file test jika perlu)
```

## 6. File .htaccess untuk Apache (jika menggunakan Apache)

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

## 7. Cek Status Deployment

Setelah deployment, cek hal-hal berikut:

1. `https://tokodeden.page` dapat diakses
2. Login/logout berfungsi normal
3. CSRF token bekerja (form submission tidak error)
4. Session persistent
5. Database connection bekerja
6. File upload/download berfungsi

## 8. Debugging CSRF Issues

Untuk debug masalah CSRF "Unauthorized action":

```bash
# 1. Check session files
ls -la storage/framework/sessions/

# 2. Check Laravel logs
tail -f storage/logs/laravel.log

# 3. Test CSRF token di browser console:
console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

# 4. Check session data di browser (Developer Tools > Application > Cookies)
# Pastikan ada cookie dengan nama session (default: laravel_session)
```

## 9. Monitoring dan Logs

- Check error logs: `tail -f storage/logs/laravel.log`
- Check web server logs (Apache/Nginx)
- Monitor disk space untuk session files
- Monitor database connections
- Use troubleshoot script: `bash troubleshoot.sh`
