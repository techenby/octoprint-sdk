# OctoPrint SDK

WORK IN PROGRESS

The [OctoPrint](https://octoprint.org/) SDK provides an expressive interface for interacting with [OctoPrint's Rest API](https://docs.octoprint.org/en/master/api/files.html) and managing OctoPrint instances servers. The structure of this repository is based on the [Laravel Forge SDK](https://github.com/laravel/forge-sdk).

## Installation

To install the SDK in your project you need to require the package via composer:

```bash
composer require techenby/octoprint-sdk
```

## Basic Usage

You can create an instance of the SDK like so:

```php
$pikachu = new TechEnby\OctoPrint(PRINTER_URL, API_TOKEN);
```

Using the `OctoPrint` instance you may perform multiple actions as well as retrieve the different resources OctoPrint's API provides:

```php
$files = $pikachu->files();
```

## Currently implemented endpoints

| API resource       | Status                              |
|--------------------|-------------------------------------|
| Version            | :heavy\_check\_mark:                |
| Server             | :heavy\_check\_mark:                |
| Connection         | :heavy\_check\_mark:                |
| Files              | in progress                         |
| Jobs               | :x:                                 |
| Languages          | :x:                                 |
| Log files          | :x:                                 |
| Printer operations | :x:                                 |
| Printer profiles   | :x:                                 |
| Settings           | :x:                                 |
| Slicing            | :x:                                 |
| System             | :x:                                 |
| Timelapse          | :x:                                 |
| Access control     | :x:                                 |
| Util               | :x:                                 |

## Contributing

Thank you for considering contributing to OctoPrint SDK! All pull requests are welcome, please follow the conventions set out in existing files.

## Security Vulnerabilities

Please review [our security policy](https://github.com/techenby/octoprint-sdk/security/policy) on how to report security vulnerabilities.

## License

OctoPrint SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
