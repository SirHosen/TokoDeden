#!/bin/bash

# Script untuk memperbaiki konfigurasi database production
echo "=== Database Configuration Fix ==="
echo ""

# Check current database config
echo "Current database configuration in .env:"
echo "DB_CONNECTION: $(grep '^DB_CONNECTION=' .env 2>/dev/null || echo 'NOT SET')"
echo "DB_HOST: $(grep '^DB_HOST=' .env 2>/dev/null || echo 'NOT SET')"
echo "DB_DATABASE: $(grep '^DB_DATABASE=' .env 2>/dev/null || echo 'NOT SET')"
echo "DB_USERNAME: $(grep '^DB_USERNAME=' .env 2>/dev/null || echo 'NOT SET')"
echo ""

# Show what should be the correct values
echo "Correct database configuration should be:"
echo "DB_CONNECTION=mysql"
echo "DB_HOST=localhost"
echo "DB_PORT=3306"
echo "DB_DATABASE=twbkawuu_tokodeden"
echo "DB_USERNAME=twbkawuu_user"
echo "DB_PASSWORD=skripsiferi"
echo ""

# Check if .env file exists
if [ ! -f ".env" ]; then
    echo "❌ .env file not found!"
    echo "Please create .env file with correct configuration."
    exit 1
fi

# Test database connection
echo "Testing database connection..."
php artisan tinker --execute="
try {
    \DB::connection()->getPdo();
    echo 'Database connection: SUCCESS' . PHP_EOL;
} catch (\Exception \$e) {
    echo 'Database connection: FAILED - ' . \$e->getMessage() . PHP_EOL;
}
"

echo ""
echo "If database connection failed, please update your .env file with correct credentials:"
echo "1. Edit .env file: nano .env"
echo "2. Update database section with correct values"
echo "3. Clear config cache: php artisan config:clear"
echo "4. Cache new config: php artisan config:cache"
echo "5. Test connection again: php artisan migrate:status"
