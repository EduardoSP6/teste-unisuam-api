<?php

namespace Domain\Shared\Entity;

use DateTimeImmutable;
use Domain\Shared\ValueObject\Id;

class BaseEntity
{
    private Id $id;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable|null $updatedAt;

    public function __construct(Id $id, DateTimeImmutable $createdAt, ?DateTimeImmutable $updatedAt = null)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
