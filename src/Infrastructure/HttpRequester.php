<?php

namespace Infrastructure;

use Application\Interfaces\RequestLogRepositoryInterface;
use DateTimeImmutable;
use Domain\Core\Entity\RequestLog;
use Domain\Core\Enum\RequestLogType;
use Domain\Shared\ValueObject\Id;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Infrastructure\Persistence\Repositories\Eloquent\RequestLogEloquentRepository;
use InvalidArgumentException;

class HttpRequester
{
    protected const AUTH_HEADER_NAME = 'Authorization';

    private RequestLogRepositoryInterface $requestLogRepository;

    public function __construct()
    {
        $this->requestLogRepository = new RequestLogEloquentRepository();
    }

    /**
     * @param string $baseUrl
     * @param string|null $tokenPrefix
     * @param string|null $token
     * @param string|null $authHeaderName
     * @return PendingRequest
     */
    public function prepareRequest(
        string      $baseUrl,
        string|null $tokenPrefix = null,
        string|null $token = null,
        string|null $authHeaderName = null
    ): PendingRequest
    {
        if (empty($baseUrl)) {
            throw new InvalidArgumentException("Base URL cannot be empty");
        }

        if (filter_var($baseUrl, FILTER_VALIDATE_URL, FILTER_FLAG_HOSTNAME) === false) {
            throw new InvalidArgumentException("Invalid Base URL");
        }

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($token) {
            $strToken = $tokenPrefix ? trim($tokenPrefix) . ' ' : '';
            $strToken .= trim($token);
            $headers[$authHeaderName ?? self::AUTH_HEADER_NAME] = $strToken;
        }

        $request = Http::baseUrl($baseUrl)->withHeaders($headers);

        // log the request
        $request->beforeSending(function (Request $callback) {
            $requestLog = new RequestLog(
                id: new Id(),
                type: RequestLogType::REQUEST,
                url: $callback->url(),
                method: $callback->method(),
                status: null,
                payload: $callback->data(),
                createdAt: new DateTimeImmutable(),
            );

            $this->saveLog($requestLog);
        });

        return $request;
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function getResponse(Response $response): Response
    {
        // handle response error
        $response->onError(function (Response $callback) {
            $url = isset($callback->handlerStats()['url']) ? $callback->handlerStats()['url'] : '';

            $requestLog = new RequestLog(
                id: new Id(),
                type: RequestLogType::RESPONSE,
                url: $url,
                method: null,
                status: $callback->status(),
                payload: $callback->json(),
                createdAt: new DateTimeImmutable(),
                error: $callback->reason()
            );

            $this->saveLog($requestLog);
        });

        // handle response data
        $url = isset($response->handlerStats()['url']) ? $response->handlerStats()['url'] : '';

        $requestLog = new RequestLog(
            id: new Id(),
            type: RequestLogType::RESPONSE,
            url: $url,
            method: null,
            status: $response->status(),
            payload: $response->json(),
            createdAt: new DateTimeImmutable(),
        );

        $this->saveLog($requestLog);

        return $response;
    }

    /**
     * Save the request calls log in database.
     *
     * @param RequestLog $requestLog
     * @return void
     */
    protected function saveLog(RequestLog $requestLog): void
    {
        $this->requestLogRepository->save($requestLog);
    }
}
