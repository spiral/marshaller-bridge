# Marshaller bridge for Spiral Framework

[![PHP Version Require](https://poser.pugx.org/spiral/marshaller-bridge/require/php)](https://packagist.org/packages/spiral/marshaller-bridge)
[![Latest Stable Version](https://poser.pugx.org/spiral/marshaller-bridge/v/stable)](https://packagist.org/packages/spiral/marshaller-bridge)
[![phpunit](https://github.com/spiral/marshaller-bridge/actions/workflows/phpunit.yml/badge.svg)](https://github.com/spiral/marshaller-bridge/actions)
[![psalm](https://github.com/spiral/marshaller-bridge/actions/workflows/psalm.yml/badge.svg)](https://github.com/spiral/marshaller-bridge/actions)
[![Codecov](https://codecov.io/gh/spiral/marshaller-bridge/branch/1.x/graph/badge.svg)](https://codecov.io/gh/spiral/marshaller-bridge)
[![Total Downloads](https://poser.pugx.org/spiral/marshaller-bridge/downloads)](https://packagist.org/packages/spiral/marshaller-bridge)
[![type-coverage](https://shepherd.dev/github/spiral/marshaller-bridge/coverage.svg)](https://shepherd.dev/github/spiral/marshaller-bridge)
[![psalm-level](https://shepherd.dev/github/spiral/marshaller-bridge/level.svg)](https://shepherd.dev/github/spiral/marshaller-bridge)

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
use Spiral\Marshaller\Mapper\AttributeMapperFactory;
use Spiral\Marshaller\Type\ArrayType;
use Spiral\Marshaller\Type\DateTimeType;
use Spiral\Marshaller\Type\DateIntervalType;
use Spiral\Marshaller\Type\EnumType;
use Spiral\Marshaller\Type\ObjectType;

return [
    'mapperFactory' => AttributeMapperFactory::class,
    'matchers' => [
        EnumType::class,
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

$result = $manager->serialize($payload, 'marshaller-json');
$result = $manager->serialize($payload, 'marshaller-serializer');

$result = $manager->unserialize($payload, Post::class, 'marshaller-json');
$result = $manager->unserialize($payload, Post::class, 'marshaller-serializer');
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

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
