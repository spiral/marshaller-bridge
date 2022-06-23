<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge\Config;

use Spiral\Core\Container\Autowire;
use Spiral\Core\InjectableConfig;
use Spiral\Marshaller\Mapper\MapperFactoryInterface;
use Spiral\Marshaller\Type\DetectableTypeInterface;

/**
 * @psalm-type CallableTypeMatcher = \Closure(\ReflectionNamedType): ?string
 */
final class MarshallerConfig extends InjectableConfig
{
    public const CONFIG = 'marshaller';

    protected array $config = [
        'mapperFactory' => null,
        'matchers' => [],
    ];

    /**
     * Get registered mapper.
     */
    public function getMapperFactory(): MapperFactoryInterface|string|Autowire
    {
        return $this->config['mapperFactory'];
    }

    /**
     * Get registered matchers.
     *
     * @return array<CallableTypeMatcher|DetectableTypeInterface|class-string<DetectableTypeInterface>>
     */
    public function getMatchers(): array
    {
        return $this->config['matchers'] ?? [];
    }
}
