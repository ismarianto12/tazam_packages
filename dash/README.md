# How to Install

## Clone and install laravel
```bash
git clone https://github.com/laravel/laravel.git {PROJECT_NAME}
cd {PROJECT_NAME}
composer install
```

Setelah composer install selesai, jalankan command berikut
```bash
cp .env.example .env
php artisan key:generate
```

## Jalankan perintah berikut untuk install modul dash
Di public_html, jalankan command berikut
```bash
mkdir ~/public_html/packages
cd ~/public_html/packages
git clone {URL_GIT_MODULE}
```

## Masuk ke direktori project
```bash
cd ~/public_html/{PROJECT_NAME}
vi composer.json
```

Rubah line paling bawah yang tadinya:
```json
    "scripts": {
        ...
    }
}
```

menjadi:
```json
    "scripts": {
        ...
    },
    "repositories": [
        {
            "type": "path",
            "url": "../packages/*"
        }
    ]
}
```

Jalankan command berikut untuk menambahkan modul dash:
```bash
composer require bryanjack/dash
php artisan dash:install
```

### Untuk membuat user Admin
```bash
php artisan dash:install
```