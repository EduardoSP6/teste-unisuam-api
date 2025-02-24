<?php

namespace Application\DTO;

final class GithubFollowingUserOutputDto
{
    public function __construct(
        public readonly int     $id,
        public readonly string  $username,
        public readonly ?string $avatarUrl,
        public readonly string  $githubUrl,
    )
    {
    }

    public static function fromGithubApi(array $responseData): GithubFollowingUserOutputDto
    {
        return new self(
            id: $responseData['id'],
            username: $responseData['login'],
            avatarUrl: $responseData['avatar_url'],
            githubUrl: $responseData['html_url']
        );
    }
}
