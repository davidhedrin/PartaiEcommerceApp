**Tahap instalasi project laravel**
1. Buka cmd ketik 'composer install' untuk download Vendor File
2. Buka cmd ketik 'composer require livewire/livewire' (Jika menggunakan livewire).
3. Jalankan 'composer require laravel/ui', Jika menggunakan Auth::routes. Kemudian 'php artisan ui bootstrap' & 'php artisan ui bootstrap --auth' Jika menggunakan tampilan auth bootsrap
4. Buka cmd ketik 'php artisan storage:link' untuk symbolick link storage
5. Buka cmd ketik 'copy .env.example .env'(win 10) / 'cp .env.example .env' (macOs)
6. Buka cmd ketik 'php artisan key:generate' untuk generate random key di file env
7. Atur nama database / koneksi di file env yg sudah dicopy
8. Buka cmd ketik 'php artisan migrate' migrage semua table ke database
9. Buka cmd ketik 'composer dump-autoload' jika ada menambahkan file halper
10. Ketik printah 'php artisan db:seed' untuk menjalankan semua seeder yg ada di DatabseSeeder secara berurutan atau 'php artisan db:seed --class=*namaSeederDiDatabaseSeeder*' untuk seeder tertentu saja.
11. Jalankan printah 'php artisan serve'
