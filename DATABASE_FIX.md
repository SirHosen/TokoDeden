# Fix Database Connection Issue

## Problem
Error: `SQLSTATE[28000] [1045] Access denied for user 'your_production_db_user'@'localhost'`

This means your production `.env` file still contains placeholder database credentials instead of real ones.

## Solution

### Step 1: Check Current Configuration
```bash
# Check what's currently in your .env file
grep '^DB_' .env
```

### Step 2: Update .env File
Edit your `.env` file on the production server:

```bash
nano .env
```

Make sure the database section looks like this:
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=twbkawuu_tokodeden
DB_USERNAME=twbkawuu_user
DB_PASSWORD=skripsiferi
```

### Step 3: Clear and Recache Configuration
```bash
php artisan config:clear
php artisan config:cache
```

### Step 4: Test Database Connection
```bash
php artisan migrate:status
```

### Step 5: Run Migrations
```bash
php artisan migrate --force
```

## Alternative: Quick Fix Command

Run this one-liner to update database config:
```bash
sed -i 's/DB_DATABASE=.*/DB_DATABASE=twbkawuu_tokodeden/' .env && \
sed -i 's/DB_USERNAME=.*/DB_USERNAME=twbkawuu_user/' .env && \
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=skripsiferi/' .env && \
php artisan config:clear && \
php artisan config:cache
```

## Verification

After fixing, you should see:
```bash
php artisan migrate:status
# Should show migration table status without errors
```
