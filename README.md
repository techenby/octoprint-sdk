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

## Rest Endpoints and SDK Methods

| **Resource**                                          | **Request**                                   | **Method**                                         |
|-------------------------------------------------------|-----------------------------------------------|----------------------------------------------------|
| ##General Information                                                                                                                                  |
| Login                                                 | POST `/api/login`                             | `$octoPrint->login()`                              |
| Current User                                          | GET `/api/currentuser`                        | `$octoPrint->currentUser()`                        |
| **Version Information**                                                                                                                                    |
| Version Information                                   | GET `/api/version`                            | `$octoPrint->version()`                            |
| **Server Information**                                                                                                                                     |
| Server information                                    | GET `/api/server`                             | `$octoPrint->server()`                             |
| **Connection handling**                                                                                                                                    |
| Get connection settings                               | GET `/api/connection`                         | `$octoPrint->connection()`                         |
| Get connection state                                  |                                               | `$octoPrint->state()`                              |
| Issue a connection command                            | POST `/api/connection`                        | `$octoPrint->connect()` `$octoPrint->dissconect()` |
| **File operations**                                                                                                                                        |
| Retrieve all files                                    | GET `/api/files`                              | `$octoPrint->files()`                              |
| Retrieve fiels from specific location                 | GET `/api/files/{location}`                   | `$octoPrint->files($location)`                     |
| Upload file                                           | POST `/api/files/{location}`                  | `$octoPrint->uploadFile($location, $path, $file)`  |
| Create folder                                         | POST `/api/files/{location}`                  | `$octoPrint->createFolder($location, $path)`       |
| Retrieve a specific file's or folder's information    | GET `/api/files/{location}/{filename}`        | `$octoPrint->file($location, $path)`               |
| Issue a file command                                  | POST `/api/files/{location}/{path}`           |                                                    |
| Delete file                                           | DELETE `/api/files/{location}/{path}`         |                                                    |
| **Job operations**                                                                                                                                         |
| Issue a job command                                   | POST `/api/job`                               |                                                    |
| Retrieve information about the current job            | GET `/api/job`                                |                                                    |
| **Languages**                                                                                                                                              |
| Retrieve installed language packs                     | GET `/api/languages`                          |                                                    |
| Upload a language pack                                | POST `/api/languages`                         |                                                    |
| Delete a language pack                                | DELETE `/api/languages/{locale}/{pack}`       |                                                    |
| **Printer operations**                                                                                                                                     |
| Retrieve the current printer state                    | GET `/api/printer`                            |                                                    |
| Issue a print head command                            | POST `/api/printer/printhead`                 |                                                    |
| Issue a total command                                 | POST `/api/printer/tool`                      |                                                    |
| Retrieve the current tool state                       | GET `/api/printer/tool`                       |                                                    |
| Issue a bed command                                   | POST `/api/printer/bed`                       |                                                    |
| Retrieve the current bed state                        | GET `/api/printer/bed`                        |                                                    |
| Issue a chamber command                               | POST `/api/printer/chamber`                   |                                                    |
| Retrieve the current chamber state                    | GET `/api/printer/chamber`                    |                                                    |
| Issue an SD command                                   | POST `/api/printer/sd`                        |                                                    |
| Retrieve the current SD state                         | GET `/api/printer/sd`                         |                                                    |
| Send an arbitrary command to the printer              | POST `/api/printer/command`                   |                                                    |
| Retrieve custom controls                              | GET `/api/printer/command/custom`             |                                                    |
| **Printer profile operations**                                                                                                                             |
| Retrieve all printer profiles                         | GET `/api/printerprofiles`                    |                                                    |
| Retrieve a single printer profile                     | GET `/api/printerprofiles/{identifier}`       |                                                    |
| Add a new printer profile                             | POST `/api/printerprofiles`                   |                                                    |
| Update an existing printer profile                    | PATCH `/api/printerprofiles/{profile}`        |                                                    |
| Remove an existing printer profile                    | DELETE `/api/printerprofiles/{profile}`       |                                                    |
| **Settings**                                                                                                                                               |
| Retireve current settings                             | GET `/api/settings`                           |                                                    |
| Save settings                                         | POST `/api/settings`                          |                                                    |
| Regenerate the system wide API key                    | POST `/api/settings/apikey`                   |                                                    |
| Fetch template data                                   | GET `/api/settings/templates`                 |                                                    |
| **Slicing**                                                                                                                                                |
| List All Slicers and Slicing Profiles                 | GET `/api/slicing`                            |                                                    |
| List Slicing Profiles of a Specific Slicer            | GET `/api/slicing/{slicer}/profiles`          |                                                    |
| Retrieve Specific Profile                             | GET `/api/slicing/{slicer}/profiles/{key}`    |                                                    |
| Add Slicing Profile                                   | PUT `/api/slicing/{slicer}/profiles/{key}`    |                                                    |
| Update Slicing Profile                                | PATCH `/api/slicing/{slicer}/profiles/{key}`  |                                                    |
| Delete Slicing Profile                                | DELETE `/api/slicing/{slicer}/profiles/{key}` |                                                    |
| **System**                                                                                                                                                 |
| List all registered system commands                   | GET `/api/system/commands`                    |                                                    |
| List all registered system commands for a source      | GET `/api/system/commands/{source}`           |                                                    |
| Execute a registered system command                   | POST `/api/system/commands/{source}/{action}` |                                                    |
| **Timelapse**                                                                                                                                              |
| Retirieve a list of timelapses and the current config | GET `/api/timelapse`                          |                                                    |
| Delete a timelapse                                    | DELETE `/api/timelapse/{filename}`            |                                                    |
| Issue a command for an unrendered timelapse           | POST `/api/timelapse/unrendered/{name}`       |                                                    |
| Delete an unrendered timelapse                        | DELETE `/api/timelapse/unrendered/{name}`     |                                                    |
| Change current timelapse config                       | POST `/api/timelapse`                         |                                                    |
| **Access Control**                                                                                                                                         |
| List all permissions                                  | GET `/api/access/permissions`                 |                                                    |
| Get group list                                        | GET `/api/access/groups`                      |                                                    |
| Add new group                                         | POST `/api/access/groups`                     |                                                    |
| Retrieve a group                                      | GET `/api/access/groups/{key}`                |                                                    |
| Update a group                                        | PUT `/api/access/groups/{key}`                |                                                    |
| Delete a group                                        | DELETE `/api/access/groups/{key}`             |                                                    |
| Retrieve a list of users                              | GET `/api/access/users`                       |                                                    |
| Retrieve a user                                       | GET `/api/access/users/{username}`            |                                                    |
| Add a new user                                        | POST `/api/access/users`                      |                                                    |
| Update a user                                         | PUT `/api/access/users/{username}`            |                                                    |
| Delete a user                                         | DELETE `/api/access/users/{username}`         |                                                    |
| Change a user's password                              | PUT `/api/access/users/{username}/password`   |                                                    |
| Get a user's settings                                 | GET `/api/access/users/{username}/settings`   |                                                    |
| Update a user's settings                              | PATCH `/api/access/users/{username}/settings` |                                                    |
| Regenerate a user's api key                           | POST `/api/access/users/{username}/apikey`    |                                                    |
| Delete a user's api key                               | DELETE `/api/access/users/{username}/apikey`  |                                                    |
| **Util**                                                                                                                                                   |
| Various tests                                         | POST `/api/util/test`                         |                                                    |
| **Wizard**                                                                                                                                                 |
| Retrieve additional data about registered wizards     | GET `/setup/wizard`                           |                                                    |
| Finish wizards                                        | POST `/setup/wizard`                          |                                                    |

## Contributing

Thank you for considering contributing to OctoPrint SDK! All pull requests are welcome, please follow the conventions set out in existing files.

## Security Vulnerabilities

Please review [our security policy](https://github.com/techenby/octoprint-sdk/security/policy) on how to report security vulnerabilities.

## License

OctoPrint SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
