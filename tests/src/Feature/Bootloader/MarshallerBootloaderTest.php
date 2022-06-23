<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge\Tests\Feature\Bootloader;

use Spiral\Marshaller\Mapper\AttributeMapperFactory;
use Spiral\Marshaller\Marshaller;
use Spiral\Marshaller\MarshallerInterface;
use Spiral\MarshallerBridge\Config\MarshallerConfig;
use Spiral\MarshallerBridge\MatchersRegistry;
use Spiral\MarshallerBridge\MatchersRegistryInterface;
use Spiral\MarshallerBridge\DataConverter\Converter;
use Spiral\MarshallerBridge\Tests\Feature\TestCase;
use Spiral\Serializer\SerializerManager;

final class MarshallerBootloaderTest extends TestCase
{
    public function testMatchersRegistryInterfaceShouldBeAsSingleton(): void
    {
        $this->assertContainerBoundAsSingleton(MatchersRegistryInterface::class, MatchersRegistry::class);
    }

    public function testMarshallerInterfaceShouldBeAsSingleton(): void
    {
        $this->assertContainerBoundAsSingleton(MarshallerInterface::class, Marshaller::class);
    }

    public function testDefaultConfigIsLoaded(): void
    {
        $config = $this->getConfig(MarshallerConfig::CONFIG);

        $this->assertIsArray($config['matchers']);
        $this->assertCount(0, $config['matchers']);

        $this->assertInstanceOf(AttributeMapperFactory::class, $config['mapperFactory']);
    }

    public function testSerializerIsConfigured(): void
    {
        $manager = $this->getContainer()->get(SerializerManager::class);

        $this->assertInstanceOf(Converter::class, $manager->getSerializer('json'));
        $this->assertInstanceOf(Converter::class, $manager->getSerializer('serializer'));
    }
}
