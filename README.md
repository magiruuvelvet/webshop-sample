# Sample Webshop

## Requirements

 - PHP 7.2.5 or higher (PHP 7.3+ recommended)
 - PHP Composer
 - MariaDB (recommended) or MySQL
 - Node.js and npm *(for building the assets)*
 - PHP Module: `ctype`
 - PHP Module: `iconv`
 - PHP Module: `gmp`
 - PHP Module: `mbstring`

## Installation (Production)

 - Clone this repository
 - Create a `../data` (outside of project source) directory and make sure it is
   writable by the web server
 - Run `composer install --no-dev --optimize-autoloader` to install the dependencies
 - Run `npm run build` to build the assets
 - Point your PHP-enabled web server to the `public` directory

### Database

 - Character set: `utf8mb4`
 - Collation: `utf8mb4_unicode_ci`

## Development

### Prepare Environment

 - `composer install`
 - `npm install`
 - Create `.env.dev.local` with a `DATABASE_URL` (see example in `.env`)

### Frontend assets

 - `npm run watch`

### Unit Tests

 - `bin/phpunit`
