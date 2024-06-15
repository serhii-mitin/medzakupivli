<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

#### [API Documentation](http://127.0.0.1:8080/api/documentation) {host}/api/documentation

### Installation steps

~~~
- Run docker
- cp docker/.env.dist docker/.env
- make -C docker build-nc
- make -C docker up-d
- make -C docker app-bash
- cp .env.example .env (
configure
SUPER_ADMIN_EMAIL=
SUPER_ADMIN_PASSWORD=
PATIENT_EMAIL=
PATIENT_PASSWORD=
)
- composer install
- php artisan key:generate
- php artisan migrate:fresh --seed 
~~~
