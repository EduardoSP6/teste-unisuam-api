<?php

namespace Infrastructure\Persistence\Repositories\Eloquent;

use Application\Interfaces\RequestLogRepositoryInterface;
use Domain\Core\Entity\RequestLog;
use Infrastructure\Persistence\Repositories\Models\RequestLog as RequestLogModel;

class RequestLogEloquentRepository implements RequestLogRepositoryInterface
{
    public function save(RequestLog $requestLog): void
    {
        RequestLogModel::query()->create([
            'type' => $requestLog->getType()->value,
            'url' => $requestLog->getUrl(),
            'method' => $requestLog->getMethod(),
            'status' => $requestLog->getStatus(),
            'payload' => $requestLog->getPayload(),
            'error' => $requestLog->getError(),
        ]);
    }
}
