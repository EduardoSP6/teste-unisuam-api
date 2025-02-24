<?php

namespace Infrastructure;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class HttpRequester
{
    protected const REQUEST_LOG = 'REQUEST_API_LOG';
    protected const REQUEST_ERROR = 'REQUEST_API_ERROR';
    protected const AUTH_HEADER_NAME = 'Authorization';

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

        $request->beforeSending(function (Request $callback) {
            Log::info(self::REQUEST_LOG, [
                'type' => 'REQUEST',
                'method' => $callback->method(),
                'api' => $callback->url(),
                'content' => $callback->body()
            ]);
        });

        return $request;
    }

    public function getResponse(Response $response): Response
    {
        $response->onError(function (Response $callback) {
            Log::error(self::REQUEST_ERROR, [
                'type' => 'ERROR',
                'status' => $callback->status(),
                'api' => isset($callback->handlerStats()['url']) ? $callback->handlerStats()['url'] : '',
                'content' => $callback->json()
            ]);
        });

        Log::info(self::REQUEST_LOG, [
            'type' => 'RESPONSE',
            'status' => $response->status(),
            'api' => isset($response->handlerStats()['url']) ? $response->handlerStats()['url'] : '',
            'content' => $response->body()
        ]);

        return $response;
    }
}
