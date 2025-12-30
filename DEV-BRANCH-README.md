# Development Branch - Laravel Debugbar

## Deskripsi
Branch `dev` ini berisi Laravel Debugbar untuk memudahkan debugging dan development.

## Cara Menggunakan

### 1. Switch ke Branch Dev
```bash
git checkout dev
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Aktifkan Debugbar
Pastikan di file `.env` sudah mengaktifkan debug mode:
```env
APP_DEBUG=true
DEBUGBAR_ENABLED=true
```

### 4. Akses Aplikasi
Buka aplikasi di browser, debugbar akan otomatis muncul di bagian bawah halaman dengan informasi:
- **Queries**: Semua query database yang dijalankan
- **Models**: Model Eloquent yang digunakan
- **Views**: Template blade yang di-render
- **Route**: Informasi route yang diakses
- **Timeline**: Waktu eksekusi setiap proses
- **Memory**: Penggunaan memory
- **Messages**: Custom log messages

## Fitur Laravel Debugbar

### Melihat Database Queries
Debugbar akan menampilkan semua query SQL yang dijalankan beserta waktu eksekusinya. Ini sangat berguna untuk:
- Debugging query yang lambat
- Mendeteksi N+1 query problem
- Optimasi database queries

### Custom Logging
Tambahkan custom log di controller/model:
```php
use Debugbar;

Debugbar::info('This is a info message');
Debugbar::error('This is an error');
Debugbar::warning('This is a warning');
Debugbar::addMessage('Custom message');
```

### Timeline Profiling
```php
Debugbar::startMeasure('render','Time for rendering');
// Your code here
Debugbar::stopMeasure('render');
```

## Konfigurasi

File konfigurasi: `config/debugbar.php`

### Menonaktifkan Debugbar Sementara
Di file `.env`:
```env
DEBUGBAR_ENABLED=false
```

### Menonaktifkan di Production
Debugbar otomatis tidak aktif jika `APP_DEBUG=false`

## Important Notes

⚠️ **JANGAN merge branch dev ke master/production**

Debugbar hanya untuk development environment. Untuk production:
1. Gunakan branch `master`
2. Pastikan `APP_DEBUG=false` di `.env` production
3. Jangan install debugbar di server production

## Struktur Branch

```
master  -> Production ready code (tanpa debugbar)
dev     -> Development code (dengan debugbar)
```

## Workflow Development

1. Develop fitur baru di branch `dev`
2. Test dengan bantuan debugbar
3. Setelah selesai, cherry-pick commit yang diperlukan ke `master` (tanpa composer.json yang berisi debugbar)
4. Atau buat branch baru dari `master` untuk fitur production

## Referensi
- [Laravel Debugbar Documentation](https://github.com/barryvdh/laravel-debugbar)
- [PHP Debug Bar](http://phpdebugbar.com/)
