<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge;

use Spiral\Marshaller\Type\DetectableTypeInterface;

/**
 * @psalm-type CallableTypeMatcher = \Closure(\ReflectionNamedType): ?string
 */
class MatchersRegistry implements MatchersRegistryInterface
{
    private array $matchers = [];

    /**
     * @psalm-param array<CallableTypeMatcher|DetectableTypeInterface|class-string<DetectableTypeInterface>> $matchers
     */
    public function __construct(array $matchers = [])
    {
        foreach ($matchers as $matcher) {
            $this->register($matcher);
        }
    }

    /** @psalm-param CallableTypeMatcher|DetectableTypeInterface|class-string<DetectableTypeInterface> $matcher */
    public function register(string|DetectableTypeInterface|\Closure $matcher): void
    {
        $this->matchers[] = $matcher;
    }

    /** @return array<CallableTypeMatcher|DetectableTypeInterface|class-string<DetectableTypeInterface>> */
    public function all(): array
    {
        return $this->matchers;
    }
}
