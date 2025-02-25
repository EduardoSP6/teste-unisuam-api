<?php

namespace Application\UseCases\GithubUsers\ListFollowingUsers;

use Domain\Core\Entity\GithubFollowingUser;

final class ListGithubFollowingUsersOutputDto
{
    /** @param GithubFollowingUser[] $followingUsers */
    public function __construct(
        public readonly array $followingUsers = []
    )
    {
    }
}
