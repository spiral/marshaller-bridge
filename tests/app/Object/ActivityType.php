<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge\Tests\App\Object;

use Spiral\Marshaller\Meta\Marshal;

class ActivityType
{
    #[Marshal(name: 'Name')]
    public string $name = '';
}
