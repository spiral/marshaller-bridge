# Marshaller bridge for Spiral Framework

[![PHP](https://img.shields.io/packagist/php-v/spiral/marshaller-bridge.svg?style=flat-square)](https://packagist.org/packages/spiral/marshaller-bridge)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/spiral/marshaller-bridge.svg?style=flat-square)](https://packagist.org/packages/spiral/marshaller-bridge)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spiral/marshaller-bridge/run-tests?label=tests&style=flat-square)](https://github.com/spiral/marshaller-bridge/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spiral/marshaller-bridge.svg?style=flat-square)](https://packagist.org/packages/spiral/marshaller-bridge)

## Requirements

Make sure that your server is configured with following PHP version and extensions:

- PHP >=8.1
- Spiral Framework ^3.0

## Installation

You can install the package via composer:

```bash
composer require spiral/marshaller-bridge
```

After package install you need to register bootloader from the package.

```php
protected const LOAD = [
    // ...
    \Spiral\MarshallerBridge\Bootloader\MarshallerBootloader::class,
];
```

> **Note**
> Bootloader `Spiral\Serializer\Bootloader\SerializerBootloader` can be removed.
> If you are using [`spiral-packages/discoverer`](https://github.com/spiral-packages/discoverer),
> you don't need to register bootloader by yourself.

## Configuration
The package is already configured by default, use these features only if you need to change the default configuration.

The package provides the ability to configure the `Spiral\Marshaller\Mapper\MapperFactoryInterface` and `matchers` used by the `Spiral\Marshaller\Marshaller` class.
Create a file `app/config/marshaller.php`.
Add the `mapperFactory` and `matchers` configuration parameters. For example:
```php
<?php

declare(strict_types=1);

use Spiral\Core\Container\Autowire;
use Spiral\Marshaller\Mapper\AttributeMapperFactory

return [
    'mapperFactory' => AttributeMapperFactory::class, 
    'matchers' => [
        DateTimeType::class,
        DateIntervalType::class,
        ArrayType::class,
        ObjectType::class,
    ],      
];
```

## Usage
Using with `Spiral\Serializer\SerializerManager`. For example:
```php
use Spiral\Serializer\SerializerManager;

$serializer = $this->container->get(SerializerManager::class); 

$result = $manager->serialize($payload, 'json');
$result = $manager->serialize($payload, 'serializer');

$result = $manager->unserialize($payload, Post::class, 'json');
$result = $manager->unserialize($payload, Post::class, 'serializer');
```
Using with `Spiral\Marshaller\MarshallerInterface`. For example:
```php
use Spiral\Marshaller\MarshallerInterface;

$marshaller = $this->container->get(MarshallerInterface::class);

$result = $marshaller->marshal($from); // from object to array
$result = $marshaller->unmarshal($from, new Post()); // from array to object
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
