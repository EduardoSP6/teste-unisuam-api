<?php

namespace Application\UseCases\GithubUsers\ListFollowingUsers;

use Application\Interfaces\GithubUserRepositoryInterface;
use InvalidArgumentException;

class ListGithubFollowingUsersUseCase
{
    private GithubUserRepositoryInterface $githubUserRepository;

    public function __construct(GithubUserRepositoryInterface $githubUserRepository)
    {
        $this->githubUserRepository = $githubUserRepository;
    }

    public function execute(ListGithubFollowingUsersInputDto $inputDto): ListGithubFollowingUsersOutputDto
    {
        $username = $inputDto->username;

        throw_if(
            empty($username),
            new InvalidArgumentException("Username can not be empty")
        );

        $followingUsers = $this->githubUserRepository->listFollowingUsers($username);

        return new ListGithubFollowingUsersOutputDto(
            followingUsers: $followingUsers
        );
    }
}
