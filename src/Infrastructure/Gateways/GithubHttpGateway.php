<?php

namespace Infrastructure\Gateways;

use Application\DTO\GithubFollowingUserOutputDto;
use Application\DTO\GithubUserOutputDto;
use Application\Interfaces\GithubGatewayInterface;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Validation\UnauthorizedException;
use Infrastructure\HttpRequester;

class GithubHttpGateway implements GithubGatewayInterface
{
    protected const API_BASE_URL = "https://api.github.com/";
    protected const TOKEN_PREFIX = 'token';

    protected HttpRequester $httpRequester;
    protected string $apiSecret;

    public function __construct()
    {
        $this->httpRequester = new HttpRequester();
        $this->apiSecret = config('services.github.client_secret');
    }

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function findUserByUsername(string $username): ?GithubUserOutputDto
    {
        $response = $this->httpRequester->getResponse(
            $this->httpRequester
                ->prepareRequest(
                    self::API_BASE_URL,
                    self::TOKEN_PREFIX,
                    $this->apiSecret
                )->get("users/$username")
        );

        if ($response->unauthorized()) {
            throw new UnauthorizedException("401 - Unauthorized");
        }

        if ($response->notFound()) {
            return null;
        }

        $data = $response->json();

        return GithubUserOutputDto::fromGithubApi($data);
    }

    /**
     * @param string $username
     * @return array
     * @throws ConnectionException
     */
    public function listFollowings(string $username): array
    {
        $response = $this->httpRequester->getResponse(
            $this->httpRequester->prepareRequest(
                self::API_BASE_URL,
                self::TOKEN_PREFIX,
                $this->apiSecret
            )->get("users/$username/following")
        );

        if ($response->unauthorized()) {
            throw new UnauthorizedException("401 - Unauthorized");
        }

        if ($response->notFound()) {
            return [];
        }

        $followingUsersCollection = $response->json();

        $followings = [];

        if (count($followingUsersCollection) > 0) {
            foreach ($followingUsersCollection as $followingUserData) {
                $followingUserOutputDto = GithubFollowingUserOutputDto::fromGithubApi($followingUserData);

                $userOutputDto = $this->findUserByUsername($followingUserOutputDto->username);
                if ($userOutputDto) {
                    $followings[] = $userOutputDto;
                }
            }
        }

        return $followings;
    }
}
