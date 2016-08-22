# MailLift notifications channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/maillift.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/maillift)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/maillift/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/maillift)
[![StyleCI](https://styleci.io/repos/65743131/shield)](https://styleci.io/repos/65743131)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/11716c52-99b4-412b-b68c-b78e0f18f844.svg?style=flat-square)](https://insight.sensiolabs.com/projects/11716c52-99b4-412b-b68c-b78e0f18f844)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/maillift.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/maillift)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/maillift/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/maillift/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/maillift.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/maillift)

This package makes it easy to create [MailLift tasks](https://maillift.com/) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the MailLift service](#setting-up-the-maillift-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

``` bash
composer require laravel-notification-channels/maillift
```

### Setting up the MailLift service

Register at [maillift.com](https://maillift.com).

Add your MailLift username and API key to your `config/services.php`:

```php
// config/services.php
...
'maillift' => [
    'user' => env('MAILLIFT_USERNAME'),
    'key' => env('MAILLIFT_API_KEY'),
],
...
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\MailLift\MailLiftChannel;
use NotificationChannels\MailLift\MailLiftMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    public function via($notifiable)
    {
        return [MailLiftChannel::class];
    }

    public function toMailLift($notifiable)
    {
        return MailLiftMessage::create('This is my handwritten letter body')
            ->sender('Laravel Notification Channels'. PHP_EOL . 'Some street 123');
    }
}
```

In order to let your notification know which address you want to send the handwritten letter to, add the `routeNotificationForMailLift` method to your Notifiable model.

This method needs to return a string with the recipient address. Use line breaks (\n character) to separate lines in the field.

```php
public function routeNotificationForMailLift()
{
    return 'Recipient Name' . PHP_EOL . 'Recipient Address' . PHP_EOL . 'Recipient State / Postal Code';
}
```

### Available methods

- `body('')`: Accepts a string value for the MailLift letter body.
- `sender('')`: Accepts a string value for the MailLift sender. Use line breaks (\n character) to separate lines in the field.
- `scheduleDelivery('')`: Accepts a string or DateTime object for the scheduled delivery date.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email m.pociot@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
