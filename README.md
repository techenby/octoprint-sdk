# OctoPrint SDK

<a href="https://github.com/techenby/octoprint-sdk/actions"><img src="https://github.com/techenby/octoprint-sdk/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/techenby/octoprint-sdk"><img src="https://img.shields.io/packagist/dt/techenby/octoprint-sdk" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/techenby/octoprint-sdk"><img src="https://img.shields.io/packagist/v/techenby/octoprint-sdk" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/techenby/octoprint-sdk"><img src="https://img.shields.io/packagist/l/techenby/octoprint-sdk" alt="License"></a>

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

## Rest Endpoints and SDK Methods

| **Resource**                                          | **Request**                                   | **Method**                                         |
|-------------------------------------------------------|-----------------------------------------------|----------------------------------------------------|
| **General Information**                                                                                                                                    |
| Login                                                 | POST `/api/login`                             | `$octoPrint->login()`                              |
| Current User                                          | GET `/api/currentuser`                        | `$octoPrint->currentUser()`                        |
| **Version Information**                                                                                                                                    |
| Version Information                                   | GET `/api/version`                            | `$octoPrint->version()`                            |
| **Server Information**                                                                                                                                     |
| Server information                                    | GET `/api/server`                             | `$octoPrint->server()`                             |
| **Connection handling**                                                                                                                                    |
| Get connection settings                               | GET `/api/connection`                         | `$octoPrint->connection()`                         |
| Get connection state                                  |                                               | `$octoPrint->state()`                              |
| _Issue a connection command_                          | POST `/api/connection`                        |                                                    |
| Connect OctoPrint to printer                          |                                               | `$octoPrint->connect()`                            |
| Disconnect OctoPrint from printer                     |                                               | `$octoPrint->dissconect()`                         |
| **File operations**                                                                                                                                        |
| Retrieve all files                                    | GET `/api/files`                              | `$octoPrint->files()`                              |
| Retrieve fiels from specific location                 | GET `/api/files/{location}`                   | `$octoPrint->files($location)`                     |
| Upload file                                           | POST `/api/files/{location}`                  |                                                    |
| Create folder                                         | POST `/api/files/{location}`                  |                                                    |
| Retrieve a specific file's or folder's information    | GET `/api/files/{location}/{filename}`        | `$octoPrint->file($location, $path)`               |
| Issue a file command                                  | POST `/api/files/{location}/{path}`           | :x:                                                |
| Delete file                                           | DELETE `/api/files/{location}/{path}`         | :x:                                                |
| **Job operations**                                                                                                                                         |
| _Issue a job command_                                 | POST `/api/job`                               |                                                    |
| Start the print of the currently selected file        |                                               | `$octoPrint->start()`                              |
| Cancel current job                                    |                                               | `$octoPrint->cancel()`                             |
| Restart job with selected file from beginning         |                                               | `$octoPrint->restart()`                            |
| Pause/Resume/Toggle current job                       |                                               | `$octoPrint->pause($action)`                       |
| Retrieve information about the current job            | GET `/api/job`                                | `$octoPrint->job()`                                |
| **Languages**                                                                                                                                              |
| Retrieve installed language packs                     | GET `/api/languages`                          | `$octoPrint->languages()`                          |
| Upload a language pack                                | POST `/api/languages`                         | :x:                                                |
| Delete a language pack                                | DELETE `/api/languages/{locale}/{pack}`       | `$octoPrint->deleteLanguage($locale, $pack)`       |
| **Printer operations**                                                                                                                                     |
| Retrieve the current printer state                    | GET `/api/printer`                            | `$octoPrint->printer()`                            |
| _Issue a print head command_                          | POST `/api/printer/printhead`                 |                                                    |
| Jog the print head                                    |                                               | `$octoPrint->jog($x, $y, $z, $absolute, $speed)`   |
| Home the print head                                   |                                               | `$octoPrint->home($axes)`                          |
| Change the feedrate factor                            |                                               | `$octoPrint->feedrate($factor)`                    |
| _Issue a total command_                               | POST `/api/printer/tool`                      |                                                    |
| Set the target temperature                            |                                               | `$octoPrint->targetTemp($temperature)`             |
| Set the offset temperature                            |                                               | `$octoPrint->offsetTemp($temperature)`             |
| Select printer's current tool                         |                                               | `$octoPrint->selectTool($tool)`                    |
| Retrieve the current tool state                       | GET `/api/printer/tool`                       | :x:                                                |
| Issue a bed command                                   | POST `/api/printer/bed`                       | :x:                                                |
| Retrieve the current bed state                        | GET `/api/printer/bed`                        | :x:                                                |
| Issue a chamber command                               | POST `/api/printer/chamber`                   | :x:                                                |
| Retrieve the current chamber state                    | GET `/api/printer/chamber`                    | :x:                                                |
| Issue an SD command                                   | POST `/api/printer/sd`                        | :x:                                                |
| Retrieve the current SD state                         | GET `/api/printer/sd`                         | :x:                                                |
| Send an arbitrary command to the printer              | POST `/api/printer/command`                   | :x:                                                |
| Retrieve custom controls                              | GET `/api/printer/command/custom`             | :x:                                                |
| **Printer profile operations**                                                                                                                             |
| Retrieve all printer profiles                         | GET `/api/printerprofiles`                    | :x:                                                |
| Retrieve a single printer profile                     | GET `/api/printerprofiles/{identifier}`       | :x:                                                |
| Add a new printer profile                             | POST `/api/printerprofiles`                   | :x:                                                |
| Update an existing printer profile                    | PATCH `/api/printerprofiles/{profile}`        | :x:                                                |
| Remove an existing printer profile                    | DELETE `/api/printerprofiles/{profile}`       | :x:                                                |
| **Settings**                                                                                                                                               |
| Retireve current settings                             | GET `/api/settings`                           | :x:                                                |
| Save settings                                         | POST `/api/settings`                          | :x:                                                |
| Regenerate the system wide API key                    | POST `/api/settings/apikey`                   | :x:                                                |
| Fetch template data                                   | GET `/api/settings/templates`                 | :x:                                                |
| **Slicing**                                                                                                                                                |
| List All Slicers and Slicing Profiles                 | GET `/api/slicing`                            | :x:                                                |
| List Slicing Profiles of a Specific Slicer            | GET `/api/slicing/{slicer}/profiles`          | :x:                                                |
| Retrieve Specific Profile                             | GET `/api/slicing/{slicer}/profiles/{key}`    | :x:                                                |
| Add Slicing Profile                                   | PUT `/api/slicing/{slicer}/profiles/{key}`    | :x:                                                |
| Update Slicing Profile                                | PATCH `/api/slicing/{slicer}/profiles/{key}`  | :x:                                                |
| Delete Slicing Profile                                | DELETE `/api/slicing/{slicer}/profiles/{key}` | :x:                                                |
| **System**                                                                                                                                                 |
| List all registered system commands                   | GET `/api/system/commands`                    | :x:                                                |
| List all registered system commands for a source      | GET `/api/system/commands/{source}`           | :x:                                                |
| Execute a registered system command                   | POST `/api/system/commands/{source}/{action}` | :x:                                                |
| **Timelapse**                                                                                                                                              |
| Retirieve a list of timelapses and the current config | GET `/api/timelapse`                          | :x:                                                |
| Delete a timelapse                                    | DELETE `/api/timelapse/{filename}`            | :x:                                                |
| Issue a command for an unrendered timelapse           | POST `/api/timelapse/unrendered/{name}`       | :x:                                                |
| Delete an unrendered timelapse                        | DELETE `/api/timelapse/unrendered/{name}`     | :x:                                                |
| Change current timelapse config                       | POST `/api/timelapse`                         | :x:                                                |
| **Access Control**                                                                                                                                         |
| List all permissions                                  | GET `/api/access/permissions`                 | :x:                                                |
| Get group list                                        | GET `/api/access/groups`                      | :x:                                                |
| Add new group                                         | POST `/api/access/groups`                     | :x:                                                |
| Retrieve a group                                      | GET `/api/access/groups/{key}`                | :x:                                                |
| Update a group                                        | PUT `/api/access/groups/{key}`                | :x:                                                |
| Delete a group                                        | DELETE `/api/access/groups/{key}`             | :x:                                                |
| Retrieve a list of users                              | GET `/api/access/users`                       | :x:                                                |
| Retrieve a user                                       | GET `/api/access/users/{username}`            | :x:                                                |
| Add a new user                                        | POST `/api/access/users`                      | :x:                                                |
| Update a user                                         | PUT `/api/access/users/{username}`            | :x:                                                |
| Delete a user                                         | DELETE `/api/access/users/{username}`         | :x:                                                |
| Change a user's password                              | PUT `/api/access/users/{username}/password`   | :x:                                                |
| Get a user's settings                                 | GET `/api/access/users/{username}/settings`   | :x:                                                |
| Update a user's settings                              | PATCH `/api/access/users/{username}/settings` | :x:                                                |
| Regenerate a user's api key                           | POST `/api/access/users/{username}/apikey`    | :x:                                                |
| Delete a user's api key                               | DELETE `/api/access/users/{username}/apikey`  | :x:                                                |

## Contributing

Thank you for considering contributing to OctoPrint SDK! All pull requests are welcome, please follow the conventions set out in existing files.

## Security Vulnerabilities

Please review [our security policy](https://github.com/techenby/octoprint-sdk/security/policy) on how to report security vulnerabilities.

## License

OctoPrint SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
