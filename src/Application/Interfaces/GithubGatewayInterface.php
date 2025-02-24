<?php

namespace Application\Interfaces;

use Application\DTO\GithubUserOutputDto;

interface GithubGatewayInterface
{
    public function findUserByUsername(string $username): ?GithubUserOutputDto;

    public function listFollowings(string $username): array;
}
