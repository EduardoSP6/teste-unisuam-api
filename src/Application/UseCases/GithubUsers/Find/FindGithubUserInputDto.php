<?php

namespace Application\UseCases\GithubUsers\Find;

final class FindGithubUserInputDto
{
    public function __construct(
        public readonly string $username
    )
    {
    }
}
