<?php

namespace Application\Interfaces;

use Domain\Core\Entity\GithubUser;

interface GithubUserRepositoryInterface
{
    public function findUserByUsername(string $username): ?GithubUser;

    public function listFollowingUsers(string $username): array;
}
