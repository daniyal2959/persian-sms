![alt text](resources/images/logo.svg)

# PHP SMS Services

[![Software License][ico-license]](LICENSE.md)
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads on Packagist][ico-download]][link-packagist]

This is a PHP library for Sms Services Integration. This library supports `PHP 8.0+`.


For PHP integration you can use [daniyal2959/persian-sms](https://github.com/daniyal2959/persian-sms) package.

> This packages works with multiple drivers, and you can create custom drivers if you can't find them in the [current drivers list](#list-of-available-drivers) (below list).

# List of available drivers
- [ippanel](https://ippanel.com/) :heavy_check_mark:
- [kavenegar](https://kavenegar.com/) :heavy_check_mark:
- Others are under way.

**Help me to add the services below by creating `pull requests`**

- farazsms.com
- sms.ir
- mellipayamak.com
- farapayamak.ir
- ...

> All services that work with ippanel can used default service `ippanel`

> you can create your own custom drivers if it's not  exists in the list, read the `Create custom drivers` section.

## Install

Via Composer

``` bash
$ composer require daniyal2959/persian-sms
```

## Configure

Just include library's `autoload.php` file in your code

```php
include_once 'vendor/autoload.php'
```

There is not any config file in this package. so you can set settings for your sms service provider in your code.

## How to use


available methods:
- `driver`: set the driver
- `text`: set the message to send without pattern
- `patten`: set your pattern code
- `data`: set array of data  pattern
- `to`: set array of numbers receivers
- `from`: set sender number
- `send`: send your sms and return response as json or plain string
- `credential`: set sms service provider credentials e.g: `token`, `username`, `password` or somethings else.

### Methods with Parameters

| Method    | driver | text   | pattern       | data  | to       | from    | credential   | send    |
|-----------|--------|--------|---------------|-------|----------|---------|--------------|---------|
| Parameter | $key   | $text  | $pattern_code | $data | $numbers | $number | $credentials | $asJson |
| Type      | string | string | string        | array | array    | string  | array        | boolean |
| Required  | *      | *      |               |       | *        | *       | *            | *       |

#### Example for sending sms message from kavenegar service provider:
```php
$sms = new SMS();
$response = $sms->driver('kavenegar')
    ->text('<MESSAGE_TO_SEND>')
    ->from('<SERVICE_PROVIDER_NUMBER>')
    ->to('<ARRAY_OF_PHONE_NUMBERS>')
    ->credential    ([
        'token' => '<YOUR_API_KEY>'
    ])
    ->send();
```

#### Example for sending sms pattern from kavenegar service provider:
```php
$sms = new SMS();
$response = $sms->driver('kavenegar')
    ->pattern('<YOUR_PATTERN_NAME>')
    ->data('<ARRAY_OF_PATTERN_VALUES>') #E.g:['%token' => '1234']
    ->from('<SERVICE_PROVIDER_NUMBER>')
    ->to('<ARRAY_OF_PHONE_NUMBERS>')
    ->credential    ([
        'token' => '<YOUR_API_KEY>'
    ])
    ->send();
```

#### Example for sending sms message from ippanel service provider:
```php
$sms = new SMS();
$response = $sms->driver('ippanel')
    ->text('<MESSAGE_TO_SEND>')
    ->from('<SERVICE_PROVIDER_NUMBER>')
    ->to('<ARRAY_OF_PHONE_NUMBERS>')
    ->credential    ([
        'username' => '<YOUR_USERNAME>',
        'password' => '<YOUR_PASSWORD>'
    ])
    ->send();
```

#### Example for sending sms pattern from ippanel service provider:
```php
$sms = new SMS();
$response = $sms->driver('ippanel')
    ->pattern('<YOUR_PATTERN_CODE>')
    ->data('<ARRAY_OF_PATTERN_VALUES>')
    ->from('<SERVICE_PROVIDER_NUMBER>')
    ->to('<ARRAY_OF_PHONE_NUMBERS>')
    ->credential    ([
        'username' => '<YOUR_USERNAME>',
        'password' => '<YOUR_PASSWORD>'
    ])
    ->send();
```

#### Create custom drivers:

You can create your custom driver with one step. this step is:

Created a class: `Sms\Driver\MyDriver`.

```php
namespace Sms\Driver;

use Sms\Contract\IDriver;
use Sms\Driver;

class MyDrive extends Driver implements IDriver
{
    const NORMAL_URL = '';

    const PATTERN_URL = '';
    
    /**
     * @return bool|mixed|string
     */
    public function sendPattern()
    {
        // TODO: Implement send pattern code for current service provider
    }

    /**
     * @param $text
     * @return bool|mixed|string
     */
    public function message($text)
    {
        // TODO: Implement send message code for current service provider
    }
}
```

## Donate (if you like it ❤️)

<a href="https://www.coffeebede.com/daniyal_s"><img class="img-fluid" src="https://coffeebede.ir/DashboardTemplateV2/app-assets/images/banner/default-yellow.svg" /></a>

## Security

If you discover any security related issues, please email daniyal.s.2959@yahoo.com instead of using the issue tracker.

## Credits

- [daniyal2959][link-author]

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/daniyal2959/persian-sms.svg?style=flat-square
[ico-download]: https://img.shields.io/packagist/dt/daniyal2959/persian-sms.svg?color=%23F18&style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/daniyal2959/persian-sms
[link-author]: https://github.com/daniyal2959