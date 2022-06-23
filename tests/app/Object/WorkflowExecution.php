<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge\Tests\App\Object;

use Spiral\Marshaller\Meta\Marshal;

class WorkflowExecution
{
    #[Marshal(name: 'ID')]
    private string $id;

    #[Marshal(name: 'RunID')]
    private ?string $runId;

    public function __construct(string $id = null, ?string $runId = null)
    {
        $this->id = $id ?? 'some-id';
        $this->runId = $runId;
    }

    public function getID(): string
    {
        return $this->id;
    }

    public function getRunID(): ?string
    {
        return $this->runId;
    }
}
