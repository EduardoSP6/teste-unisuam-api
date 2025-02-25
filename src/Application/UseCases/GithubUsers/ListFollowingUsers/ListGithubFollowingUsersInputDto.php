<?php

namespace Application\UseCases\GithubUsers\ListFollowingUsers;

final class ListGithubFollowingUsersInputDto
{
    public function __construct(
        public readonly string $username
    )
    {
    }
}
