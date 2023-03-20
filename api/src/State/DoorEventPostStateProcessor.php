<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Model\DoorEvent;
use App\Model\DoorEventType;
use JoliCode\Elastically\IndexBuilder;
use JoliCode\Elastically\Indexer;
use JoliCode\Elastically\Model\Document;

class DoorEventPostStateProcessor implements ProcessorInterface
{
    public function __construct(private readonly IndexBuilder $indexBuilder, private readonly Indexer $indexer)
    {
    }

    /**
     * @param DoorEvent $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $data->setEventType(1 === $data->getChipId() ? DoorEventType::Ingress : DoorEventType::Egress);
        $index = $this->indexBuilder->createIndex('door_event');
        $this->indexBuilder->markAsLive($index, 'door_event');
        $this->indexer->scheduleIndex('door_event', new Document($data->getId(), $data));
        $this->indexer->flush();
        $this->indexer->refresh($index);
    }
}
