# Laravel Awesome Validation

![Banner](https://banners.beyondco.de/Laravel%20Awesome%20Validation.png?theme=light&packageManager=composer+require&packageName=phu1237%2Flaravel-awesome-validation&pattern=architect&style=style_1&description=Collection+of+useful+Traits%2C+etc+for+Laravel+Validation&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)
[![Version](https://img.shields.io/packagist/v/phu1237/laravel-awesome-validation?style=flat-square)](https://packagist.org/packages/phu1237/laravel-awesome-validation)
[![License](https://img.shields.io/packagist/l/phu1237/laravel-awesome-validation?style=flat-square)](https://github.com/Phu1237/laravel-awesome-validation/blob/master/LICENSE)

Collection of useful Traits, etc for Laravel Validation

## Content table

- [Installation](#installation)
- [Usage](#usage)
- [Command](#command)
- [License](#license)

## Installation

- Require this package with composer:

```bash
composer require phu1237/laravel-awesome-validation
```

### Laravel auto-discovery

Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Laravel without auto-discovery

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php:

```php
Phu1237\AwesomeValidation\ServiceProvider::class,
```

- Done. You can use all functions now.

## Usage

## Command

Copy the package config to your local config with the publish command:

```bash
php artisan vendor:publish --provider="Phu1237\AwesomeValidation\ServiceProvider" --tag=config
```

## License

The Laravel Awesome Validation is open-sourced software licensed under
the [MIT license](http://opensource.org/licenses/MIT).
