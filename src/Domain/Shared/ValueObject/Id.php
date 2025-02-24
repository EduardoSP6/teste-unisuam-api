<?php

namespace Domain\Shared\ValueObject;

class Id
{
    private readonly int $id;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    public function value(): int
    {
        return $this->id;
    }
}
