<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge\Tests\App\Object;

use Carbon\CarbonImmutable;
use Spiral\Marshaller\Meta\Marshal;
use Spiral\Marshaller\Type\DateTimeType;
use Spiral\Marshaller\Type\NullableType;
use Spiral\Marshaller\Type\ObjectType;

final class ActivityInfo
{
    #[Marshal(name: 'TaskToken')]
    public string $taskToken;

    #[Marshal(name: 'WorkflowType', type: NullableType::class, of: WorkflowType::class)]
    public ?WorkflowType $workflowType = null;

    #[Marshal(name: 'WorkflowNamespace')]
    public string $workflowNamespace = 'default';

    #[Marshal(name: 'WorkflowExecution', type: NullableType::class, of: WorkflowExecution::class)]
    public ?WorkflowExecution $workflowExecution = null;

    #[Marshal(name: 'ActivityID')]
    public string $id;

    #[Marshal(name: 'ActivityType', type: ObjectType::class, of: ActivityType::class)]
    public ActivityType $type;

    #[Marshal(name: 'TaskQueue')]
    public string $taskQueue = 'foo';

    #[Marshal(name: 'ScheduledTime', type: DateTimeType::class)]
    public \DateTimeInterface $scheduledTime;

    #[Marshal(name: 'StartedTime', type: DateTimeType::class)]
    public \DateTimeInterface $startedTime;

    #[Marshal(name: 'Deadline', type: DateTimeType::class)]
    public \DateTimeInterface $deadline;

    #[Marshal(name: 'Attempt')]
    public int $attempt = 1;

    public function __construct()
    {
        $this->id = '0';
        $this->taskToken = 'token';
        $this->type = new ActivityType();

        $this->scheduledTime = CarbonImmutable::now();
        $this->startedTime = CarbonImmutable::now();
        $this->deadline = CarbonImmutable::now();
    }
}
