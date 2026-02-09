# ArdaKos Laravel

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About ArdaKos

ArdaKos is a modern property management system built on Laravel 12, migrating from a legacy Google Apps Script architecture. It features:
- **Multi-Tenancy:** Single-database architecture with `landlord_id` isolation.
- **Fintech Integration:** Midtrans/Xendit payment gateway support with polymorphic design.
- **IoT Readiness:** Smart lock integration (TTLock) via event-driven architecture.
- **Enterprise Quality:** PHPStan Level 8, Pest Testing, and strict SOLID principles.

## Getting Started

1. **Clone the repository**
2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```
3. **Setup Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Run Migrations & Seed:**
   ```bash
   php artisan migrate:fresh --seed
   ```
5. **Start Server:**
   ```bash
   php artisan serve
   npm run dev
   ```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
