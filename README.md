# Sample Webshop

## Requirements

 - PHP 7.2.5 or higher (PHP 7.3+ recommended)
 - PHP Composer
 - Node.js

## Installation (Production)

 - Clone this repository
 - Create a `../data` (outside of project source) directory and make sure it is
   writable by the web server
 - Run `composer install --no-dev --optimize-autoloader`
 - Run `npm run build` to build the assets
 - Point your PHP-enabled web server to the `public` directory

## Development

### Prepare Environment

 - `composer install`
 - `npm install`
 - Create `.env.dev.local` with a `DATABASE_URL` (see example in `.env`)

### Frontend assets

 - `npm run watch`
