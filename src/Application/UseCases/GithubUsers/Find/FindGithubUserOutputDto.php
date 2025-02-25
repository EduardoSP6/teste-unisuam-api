<?php

namespace Application\UseCases\GithubUsers\Find;

use Domain\Core\Entity\GithubUser;

final class FindGithubUserOutputDto
{
    public function __construct(
        public readonly GithubUser $githubUser
    )
    {
    }
}
