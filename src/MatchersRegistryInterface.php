<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge;

use Spiral\Marshaller\Type\DetectableTypeInterface;

/**
 * @psalm-type CallableTypeMatcher = \Closure(\ReflectionNamedType): ?string
 */
interface MatchersRegistryInterface
{
    /** @psalm-param CallableTypeMatcher|DetectableTypeInterface|class-string<DetectableTypeInterface> $matcher */
    public function register(string|DetectableTypeInterface|\Closure $matcher): void;

    /** @return array<CallableTypeMatcher|DetectableTypeInterface|class-string<DetectableTypeInterface>> */
    public function all(): array;
}
