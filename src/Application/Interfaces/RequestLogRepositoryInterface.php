<?php

namespace Application\Interfaces;

use Domain\Core\Entity\RequestLog;

interface RequestLogRepositoryInterface
{
    public function save(RequestLog $requestLog): void;
}
