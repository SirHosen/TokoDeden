#!/bin/bash

# Script untuk troubleshooting masalah production TokoDeden
# Jalankan dengan: bash troubleshoot.sh

echo "=== TokoDeden Production Troubleshoot Script ==="
echo ""

# Check basic Laravel setup
echo "1. Checking Laravel configuration..."
php artisan --version
echo ""

# Check .env file
echo "2. Checking .env configuration..."
echo "APP_ENV: $(grep APP_ENV .env)"
echo "APP_URL: $(grep APP_URL .env)"
echo "SESSION_DOMAIN: $(grep SESSION_DOMAIN .env)"
echo "DB_DATABASE: $(grep DB_DATABASE .env)"
echo "DB_USERNAME: $(grep DB_USERNAME .env)"
echo ""

# Check database connection
echo "2a. Testing database connection..."
php artisan tinker --execute="
try {
    \DB::connection()->getPdo();
    echo 'Database: ✓ Connected successfully';
} catch (\Exception \$e) {
    echo 'Database: ✗ Connection failed - ' . \$e->getMessage();
}
" 2>/dev/null
echo ""

# Check storage link
echo "3. Checking storage link..."
if [ -L "public/storage" ]; then
    echo "✓ Storage link exists"
    echo "Link target: $(readlink public/storage)"
else
    echo "✗ Storage link does not exist"
    echo "Creating storage link..."
    php artisan storage:link
fi
echo ""

# Check permissions
echo "4. Checking permissions..."
echo "Storage permissions: $(ls -ld storage/)"
echo "Public/storage permissions: $(ls -ld public/storage/ 2>/dev/null || echo 'Directory not found')"
echo ""

# Check if we can write to storage
echo "5. Testing storage write access..."
touch storage/logs/test.log 2>/dev/null && echo "✓ Can write to storage/logs" || echo "✗ Cannot write to storage/logs"
rm storage/logs/test.log 2>/dev/null
echo ""

# Clear all caches
echo "6. Clearing all caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo "✓ All caches cleared"
echo ""

# Cache configuration for production
echo "7. Caching configuration for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✓ Production caches created"
echo ""

# Check database connection
echo "8. Testing database connection..."
php artisan migrate:status | head -5
echo ""

# Final checks
echo "9. Final recommendations:"
echo "- Ensure SESSION_DOMAIN=tokodeden.page (WITHOUT leading dot)"
echo "- Ensure APP_URL=https://tokodeden.page"
echo "- Check that storage directory has correct permissions"
echo "- Test CSRF functionality with browser dev tools"
echo ""

echo "=== Troubleshoot Complete ==="
echo "If issues persist, check Laravel logs: tail -f storage/logs/laravel.log"
