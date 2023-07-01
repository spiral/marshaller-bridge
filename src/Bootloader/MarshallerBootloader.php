<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge\Bootloader;

use Spiral\Attributes\ReaderInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Bootloader\Attributes\AttributesBootloader;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Core\Container;
use Spiral\Marshaller\Mapper\AttributeMapperFactory;
use Spiral\Marshaller\Mapper\MapperFactoryInterface;
use Spiral\Marshaller\Marshaller;
use Spiral\Marshaller\MarshallerInterface;
use Spiral\MarshallerBridge\Config\MarshallerConfig;
use Spiral\MarshallerBridge\MatchersRegistry;
use Spiral\MarshallerBridge\MatchersRegistryInterface;
use Spiral\MarshallerBridge\DataConverter\Converter;
use Spiral\Serializer\Bootloader\SerializerBootloader;
use Spiral\Serializer\Serializer\JsonSerializer;
use Spiral\Serializer\Serializer\PhpSerializer;
use Spiral\Serializer\SerializerRegistryInterface;

final class MarshallerBootloader extends Bootloader
{
    protected const SINGLETONS = [
        MatchersRegistryInterface::class => [self::class, 'initMatchersRegistry'],
        MarshallerInterface::class => [self::class, 'initMarshaller'],
    ];

    protected const DEPENDENCIES = [
        SerializerBootloader::class,
        AttributesBootloader::class,
    ];

    public function init(ConfiguratorInterface $configs, ReaderInterface $reader): void
    {
        $configs->setDefaults(MarshallerConfig::CONFIG, [
            'mapperFactory' => new AttributeMapperFactory($reader),
            'matchers' => []
        ]);
    }

    public function boot(
        SerializerRegistryInterface $registry,
        JsonSerializer $jsonSerializer,
        PhpSerializer $phpSerializer,
        MarshallerInterface $marshaller
    ): void {
        $this->configureSerializer($registry, $jsonSerializer, $phpSerializer, $marshaller);
    }

    private function initMarshaller(
        MarshallerConfig $config,
        MatchersRegistryInterface $matchers,
        Container $container
    ): MarshallerInterface {
        $factory = $config->getMapperFactory();

        /** @psalm-suppress InvalidArgument */
        return new Marshaller(
            $factory instanceof MapperFactoryInterface ? $factory : $container->get($factory),
            $matchers->all()
        );
    }

    private function initMatchersRegistry(MarshallerConfig $config): MatchersRegistryInterface
    {
        return new MatchersRegistry($config->getMatchers());
    }

    private function configureSerializer(
        SerializerRegistryInterface $registry,
        JsonSerializer $jsonSerializer,
        PhpSerializer $phpSerializer,
        MarshallerInterface $marshaller
    ): void {
        $registry->register('marshaller-json', new Converter($jsonSerializer, $marshaller));
        $registry->register('marshaller-serializer', new Converter($phpSerializer, $marshaller));
    }
}
