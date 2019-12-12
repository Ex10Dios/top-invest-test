## Install

- setup web host to `/public` directory
- `cp .env.example .env` and add your DB & SMTP credentials and app URL
- `composer install`
- `npm install`
- `npm run prod`
- `php artisan key:generate`
- `php artisan migrate`