# Deploy Pola B (Best Practice) - VPS Tanpa Node/NPM

Pola B cocok jika VPS tidak bisa install Node.js.

## Prinsip Pola B

- VPS hanya menjalankan PHP + Composer.
- Tidak menjalankan `npm install`, `npm ci`, atau `npm run build` di VPS.
- Folder `public/build` tidak wajib ada (dan di-ignore di git).
- Jalur aplikasi diarahkan ke halaman CRM utama yang tidak bergantung pada Vite build.

## Prasyarat VPS

- PHP 8.2+
- Composer
- Ekstensi PHP sesuai kebutuhan Laravel (pdo, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo)
- Web server (Nginx/Apache), bukan `php artisan serve` untuk production

## 1. Deploy Source Code

Contoh jika pakai git:

```bash
cd /var/www/crm295
git pull origin main
```

## 2. Install Dependency PHP

```bash
composer install --no-dev --optimize-autoloader
```

## 3. Konfigurasi Environment

Buat/cek `.env` production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.tld

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

SESSION_DRIVER=database
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

SANCTUM_EXPIRATION=120
```

Lalu jalankan:

```bash
php artisan key:generate
```

## 4. Migrasi & Seed

```bash
php artisan migrate --force
php artisan db:seed --force
```

## 5. Optimasi Runtime Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 6. Permission Directory (Linux)

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## 7. Scheduler

Gunakan cron (direkomendasikan):

```cron
* * * * * cd /var/www/crm295 && php artisan schedule:run >> /dev/null 2>&1
```

## 8. Nginx/Apache

Set document root ke folder `public`.

Contoh Nginx block inti:

```nginx
root /var/www/crm295/public;
index index.php;

location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
}
```

## 9. Zero-Downtime Deploy Mini Checklist

Urutan aman saat update:

1. `git pull`
2. `composer install --no-dev --optimize-autoloader`
3. `php artisan migrate --force`
4. `php artisan config:cache`
5. `php artisan route:cache`
6. `php artisan view:cache`
7. reload php-fpm/nginx jika perlu

## Troubleshooting Cepat

- Error `Vite manifest not found`:
  - Pastikan route utama mengarah ke dashboard/login CRM, bukan welcome page yang memakai `@vite`.
- Error permission write cache/session:
  - Perbaiki owner/permission `storage` dan `bootstrap/cache`.
- Login gagal meski benar:
  - Cek migrasi/seed sudah dijalankan, dan cek throttle login (tunggu 1 menit jika banyak percobaan gagal).
