<?php

namespace Domain\Shared\ValueObject;

class Id
{
    private readonly int $id;

    public function __construct(?int $id = null)
    {
        $this->id = $id ?? rand(1, 9999999);
    }

    public function value(): int
    {
        return $this->id;
    }
}
