<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge\DataConverter;

use Spiral\Marshaller\MarshallerInterface;
use Spiral\Serializer\SerializerInterface;

final class Converter implements SerializerInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly MarshallerInterface $marshaller
    ) {
    }

    public function serialize(mixed $payload): string|\Stringable
    {
        if (\is_object($payload)) {
            $payload = $payload instanceof \stdClass ? $payload : $this->marshaller->marshal($payload);
        }

        return $this->serializer->serialize($payload);
    }

    /**
     * @throws \ReflectionException
     */
    public function unserialize(\Stringable|string $payload, object|string|null $type = null): mixed
    {
        $data = $this->serializer->unserialize($payload);

        if (!\is_array($data)) {
            return $data;
        }

        if (!\is_object($type)) {
            $type = (new \ReflectionClass($type ?? \stdClass::class))->newInstanceWithoutConstructor();
        }

        return $this->marshaller->unmarshal($data, $type);
    }
}
