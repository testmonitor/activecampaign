# ActiveCampaign PHP SDK

[![Latest Stable Version](https://poser.pugx.org/testmonitor/activecampaign/v/stable)](https://packagist.org/packages/testmonitor/activecampaign)
[![Travis Build](https://travis-ci.org/testmonitor/activecampaign.svg?branch=master)](https://travis-ci.org/testmonitor/activecampaign)
[![Code Quality](https://scrutinizer-ci.com/g/testmonitor/activecampaign/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/testmonitor/activecampaign/?branch=master)
[![StyleCI](https://styleci.io/repos/176945288/shield)](https://styleci.io/repos/176945288)
[![License](https://poser.pugx.org/testmonitor/activecampaign/license)](https://packagist.org/packages/testmonitor/activecampaign)

This package provides a PHP SDK for the ActiveCampaign API (v3).

It is inspired by the code style of [Laravel's Forge SDK](https://github.com/themsaid/forge-sdk).

For more information on the ActiveCampaign API, refer to their [developer documentation](https://developers.activecampaign.com/reference).

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Tests](#tests)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)
  
## Installation

This package can be installed through Composer:

```sh
$ composer require testmonitor/activecampaign
```

Make sure to use Composer's autoload:

```php
require __DIR__.'/../vendor/autoload.php';
```

Start by creating a new instance:

```php
$activeCampaign = new ActiveCampaign(ACTIVE_CAMPAIGN_URL, ACTIVE_CAMPAIGN_KEY);
``` 

Your API key can be found in your account on the Settings page under the "Developer" tab.

## Upgrading

ActiveCampaign has announced that [Organizations will be replaced by Accounts](https://help.activecampaign.com/hc/en-us/articles/360008108619-Transitioning-from-the-Organization-field-to-Accounts). 
As of version **4.0**, this package will contain various changes to accommodate to this transition.

For this reason, some breaking changes had to be introduced. When you upgrade from 3.0 to 4.0, make sure
to check any references to organizations (for example, in the **createContact** method) and
replace them.

## Usage

Once instantiated, you can simply call one of the methods provided by the SDK:

```php
$activeCampaign->contacts();
```

This will provide you with a list of available contacts.

To create a contact, you can use the `createContact` method:

```php
$contact = $activeCampaign->createContact(
    'johndoe@example.com',
    'John',
    'Doe',
    '1-541-754-3010'
);
```

When the request was successful, `$contact` will contain a Contact object with the contact details.

To retrieve an existing contact or create it when it is missing:

```php
$contact = $activeCampaign->findOrCreateContact(
    'johndoe@example.com',
    'John',
    'Doe'
);
```

When the request was successful, `$contact` will contain a Contact object with the contact details.

## Tests

The package contains integration tests. You can run them using PHPUnit.

```
$ vendor/bin/phpunit
```

## Changelog

Refer to [CHANGELOG](CHANGELOG.md) for more information.

## Contributing

Refer to [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

## Credits

- [Thijs Kok](https://www.testmonitor.com/)
- [Stephan Grootveld](https://www.testmonitor.com/)
- [Frank Keulen](https://www.testmonitor.com/)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Refer to the [License](LICENSE.md) for more information.
