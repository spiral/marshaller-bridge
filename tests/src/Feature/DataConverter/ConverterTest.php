<?php

declare(strict_types=1);

namespace Spiral\MarshallerBridge\Tests\DataConverter;

use Carbon\Carbon;
use Spiral\Marshaller\Support\DateInterval;
use Spiral\MarshallerBridge\Tests\App\Object\ActivityInfo;
use Spiral\MarshallerBridge\Tests\App\Object\ActivityType;
use Spiral\MarshallerBridge\Tests\App\Object\WorkflowExecution;
use Spiral\MarshallerBridge\Tests\App\Object\WorkflowType;
use Spiral\MarshallerBridge\Tests\Feature\TestCase;
use Spiral\Serializer\SerializerManager;

final class ConverterTest extends TestCase
{
    public function testSerialize(): void
    {
        $serializer = $this->getContainer()->get(SerializerManager::class);

        $dto = $this->createTestObject();

        $this->assertSame(
            preg_replace('/\s+/', '', '{"TaskToken":"sometoken","WorkflowType":{"Name":"workflow"},
            "WorkflowNamespace":"namespace","WorkflowExecution":{"ID":"foo","RunID":"bar"},"ActivityID":"uuid","ActivityType":
            {"Name":"activity"},"TaskQueue":"sometask","HeartbeatTimeout":0,"ScheduledTime":"2010-01-28T15:00:00+02:00",
            "StartedTime":"2010-01-28T15:00:00+02:00","Deadline":"2010-01-28T15:00:00+02:00","Attempt":10}'),
            preg_replace('/\s+/', '', $serializer->serialize($dto, 'marshaller-json'))
        );

        $this->assertSame(
            preg_replace('/\s+/', '', 'a:12:{s:9:"TaskToken";s:10:"sometoken";s:12:"WorkflowType";
            a:1:{s:4:"Name";s:8:"workflow";}s:17:"WorkflowNamespace";s:9:"namespace";s:17:"WorkflowExecution";a:2:{s:2:"ID";
            s:3:"foo";s:5:"RunID";s:3:"bar";}s:10:"ActivityID";s:4:"uuid";s:12:"ActivityType";a:1:{s:4:"Name";s:8:
            "activity";}s:9:"TaskQueue";s:9:"sometask";s:16:"HeartbeatTimeout";i:0;s:13:"ScheduledTime";s:25:"
            2010-01-28T15:00:00+02:00";s:11:"StartedTime";s:25:"2010-01-28T15:00:00+02:00";s:8:"Deadline";s:25:
            "2010-01-28T15:00:00+02:00";s:7:"Attempt";i:10;}'),
            preg_replace('/\s+/', '', $serializer->serialize($dto, 'marshaller-serializer'))
        );
    }

    public function testUnserialize(): void
    {
        $serializer = $this->getContainer()->get(SerializerManager::class);

        $dto = $this->createTestObject();

        $this->assertEquals(
            $dto,
            $serializer->unserialize(
                $serializer->serialize($dto, 'marshaller-json'),
                ActivityInfo::class,
                'marshaller-json'
            )
        );
        $this->assertEquals(
            $dto,
            $serializer->unserialize(
                $serializer->serialize($dto, 'marshaller-serializer'),
                ActivityInfo::class,
                'marshaller-serializer'
            )
        );
    }

    private function createTestObject(): ActivityInfo
    {
        $type = new ActivityType();
        $type->name = 'activity';

        $workflow = new WorkflowType();
        $workflow->name = 'workflow';

        $dto = new ActivityInfo();
        $dto->taskToken = 'some token';
        $dto->workflowType = $workflow;
        $dto->workflowNamespace = 'namespace';
        $dto->type = $type;
        $dto->attempt = 10;
        $dto->id = 'uuid';
        $dto->deadline = new Carbon('2010-01-28T15:00:00+02:00');
        $dto->heartbeatTimeout = DateInterval::parse('');
        $dto->startedTime = new Carbon('2010-01-28T15:00:00+02:00');
        $dto->taskQueue = 'some task';
        $dto->workflowExecution = new WorkflowExecution('foo', 'bar');
        $dto->scheduledTime = new Carbon('2010-01-28T15:00:00+02:00');

        return $dto;
    }
}
