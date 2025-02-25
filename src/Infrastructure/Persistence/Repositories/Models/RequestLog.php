<?php

namespace Infrastructure\Persistence\Repositories\Models;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $type
 * @property string $url
 * @property string|null $method
 * @property int|null $status
 * @property array|null $payload
 * @property string|null $error
 * @property DateTimeImmutable $created_at
 * @property DateTimeImmutable|null $updated_at
 */
class RequestLog extends Model
{
    protected $table = "request_logs";

    protected $fillable = [
        'type',
        'url',
        'method',
        'status',
        'payload',
        'error',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}
