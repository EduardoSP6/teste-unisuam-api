<?php

namespace Application\UseCases\GithubUsers\Find;

use Application\Exceptions\UserNotFoundException;
use Application\Interfaces\GithubUserRepositoryInterface;
use InvalidArgumentException;

class FindGithubUserUseCase
{
    private GithubUserRepositoryInterface $githubUserRepository;

    public function __construct(GithubUserRepositoryInterface $githubUserRepository)
    {
        $this->githubUserRepository = $githubUserRepository;
    }

    public function execute(FindGithubUserInputDto $inputDto): FindGithubUserOutputDto
    {
        $username = $inputDto->username;

        throw_if(
            empty($username),
            new InvalidArgumentException("Username can not be empty")
        );

        $githubUser = $this->githubUserRepository->findUserByUsername($username);

        throw_if(
            !$githubUser,
            new UserNotFoundException()
        );

        return new FindGithubUserOutputDto(
            githubUser: $githubUser
        );
    }
}
