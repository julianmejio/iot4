<?php

namespace App\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\State\DoorEventPostStateProcessor;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(normalizationContext: ['groups' => ['door_event:get']], denormalizationContext: ['groups' => 'door_event:post'], processor: DoorEventPostStateProcessor::class)
    ]
)]
class DoorEvent
{
    #[Groups(['door_event:get'])]
    private Uuid $id;

    #[Groups(['door_event:get'])]
    private \DateTimeInterface $date;
    #[Groups(['door_event:post', 'door_event:get'])]
    #[Assert\NotBlank(groups: ['door_event:post'])]
    #[Assert\Range(min: 1, max: 4, groups: ['door_event:post'])]
    private int $chipId;
    #[Groups(['door_event:get'])]
    private DoorEventType $eventType;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->date = new \DateTime();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return DoorEvent
     */
    public function setId(string $id): DoorEvent
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return DoorEvent
     */
    public function setDate(\DateTimeInterface $date): DoorEvent
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getChipId(): int
    {
        return $this->chipId;
    }

    /**
     * @param int $chipId
     * @return DoorEvent
     */
    public function setChipId(int $chipId): DoorEvent
    {
        $this->chipId = $chipId;
        return $this;
    }

    /**
     * @return DoorEventType
     */
    public function getEventType(): DoorEventType
    {
        return $this->eventType;
    }

    /**
     * @param DoorEventType $eventType
     * @return DoorEvent
     */
    public function setEventType(DoorEventType $eventType): DoorEvent
    {
        $this->eventType = $eventType;
        return $this;
    }
}
