<?php

namespace Domain\Core\Entity;

use DateTimeImmutable;
use Domain\Core\Enum\RequestLogType;
use Domain\Shared\ValueObject\Id;

class RequestLog
{
    private Id $id;
    private RequestLogType $type;
    private string $url;
    private ?string $method;
    private ?int $status;
    private ?array $payload;
    private ?string $error;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt;

    public function __construct(Id $id, RequestLogType $type, string $url, ?string $method, ?int $status, ?array $payload, DateTimeImmutable $createdAt, ?string $error = null, ?DateTimeImmutable $updatedAt = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->url = $url;
        $this->method = $method;
        $this->status = $status;
        $this->payload = $payload;
        $this->error = $error;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return RequestLogType
     */
    public function getType(): RequestLogType
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return array|null
     */
    public function getPayload(): ?array
    {
        return $this->payload;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
