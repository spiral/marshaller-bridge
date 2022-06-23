<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge\Tests\Feature;

use Spiral\Boot\Bootloader\ConfigurationBootloader;
use Spiral\MarshallerBridge\Bootloader\MarshallerBootloader;

abstract class TestCase extends \Spiral\Testing\TestCase
{
    public function rootDirectory(): string
    {
        return \dirname(__DIR__, 2) . '/app';
    }

    public function defineBootloaders(): array
    {
        return [
            ConfigurationBootloader::class,
            MarshallerBootloader::class,
        ];
    }
}
