# Nova Health

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stepanenko3/nova-health.svg?style=flat-square)](https://packagist.org/packages/stepanenko3/nova-health)
[![Total Downloads](https://img.shields.io/packagist/dt/stepanenko3/nova-health.svg?style=flat-square)](https://packagist.org/packages/stepanenko3/nova-health)
[![License](https://poser.pugx.org/stepanenko3/nova-health/license)](https://packagist.org/packages/stepanenko3/nova-health)

![screenshot of tool](screenshots/tool.png)

## Description

Laravel Nova tool for checking healthy of your Laravel app based on https://github.com/spatie/laravel-health

## Requirements

- `php: >=8.0`
- `laravel/nova: ^4.0`

## Installation

You can install the nova tool in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require stepanenko3/nova-health
```

Next up, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvder.php

// ...

public function tools()
{
    return [
        // ...
        new \Stepanenko3\NovaHealth\NovaHealth,
    ];
}
```

Publish the config file:

``` bash
php artisan vendor:publish --provider="Stepanenko3\NovaHealth\ToolServiceProvider"
```

Add your health checks usgin [spatie/laravel-health docs](https://spatie.be/docs/laravel-health/v1/basic-usage/registering-your-first-check)

## Usage

Click on the `"Health"` menu item in your Nova app to see the tool.

## Configuration

All the configuration is managed from a single configuration file located in `config/nova-health.php`

## Screenshots

![screenshot of tool](screenshots/tool-dark.png)
![screenshot of tool](screenshots/tool-mobile.png)

## Credits

- [Artem Stepanenko](https://github.com/stepanenko3)

## Contributing

Thank you for considering contributing to this package! Please create a pull request with your contributions with detailed explanation of the changes you are proposing.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).
