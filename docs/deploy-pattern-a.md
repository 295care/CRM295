# Deploy Pola A (VPS Tanpa Node/NPM)

Dokumen ini untuk skenario: build frontend dilakukan di lokal/CI, lalu hasil build dikirim ke VPS.

## Ringkasan

- Build Vite dilakukan di mesin yang punya Node.js.
- Hasil build (`public/build`) ikut di-deploy ke VPS.
- VPS hanya menjalankan PHP/Composer, tanpa `npm install` atau `npm run build`.

## 1. Build di Lokal / CI

Jalankan di mesin lokal (atau CI) yang punya Node:

```bash
npm ci
npm run build
```

Pastikan file berikut terbentuk:

- `public/build/manifest.json`
- file asset hashed di `public/build/assets/*`

## 2. Commit Hasil Build (opsional tapi disarankan)

Jika deploy berbasis `git pull` di VPS, commit hasil build:

```bash
git add public/build
git commit -m "chore: include built assets for VPS deploy"
git push
```

## 3. Deploy ke VPS

### Opsi A: Git Pull di VPS

```bash
cd /path/to/project
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Opsi B: Upload Artefak Manual (scp/rsync)

Upload project + folder `public/build` ke VPS, lalu jalankan perintah finalisasi yang sama.

## 4. Konfigurasi Production di VPS

Pastikan `.env` production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.tld

SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SANCTUM_EXPIRATION=120
```

## 5. Catatan Penting

- Jangan jalankan `php artisan serve` untuk production. Gunakan Nginx/Apache ke `public/index.php`.
- Jika update frontend, ulangi proses build di lokal/CI lalu deploy ulang `public/build`.
- Jika route/config berubah, jalankan ulang cache command di VPS.
