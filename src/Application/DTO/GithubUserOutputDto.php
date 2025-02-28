<?php

namespace Application\DTO;

use DateTimeImmutable;
use Exception;

final class GithubUserOutputDto
{
    public function __construct(
        public readonly int                    $id,
        public readonly ?string                $avatarUrl,
        public readonly string                 $username,
        public readonly ?string                $name,
        public readonly ?string                $email,
        public readonly ?string                $bio,
        public readonly string                 $githubUrl,
        public readonly ?string                $blogUrl,
        public readonly ?string                $company,
        public readonly ?string                $location,
        public readonly int                    $publicRepositories,
        public readonly int                    $followers,
        public readonly int                    $followings,
        public readonly DateTimeImmutable      $createdAt,
        public readonly DateTimeImmutable|null $updatedAt
    )
    {
    }

    /**
     * @throws Exception
     */
    public static function fromGithubApi(array $responseData): self
    {
        return new self(
            id: $responseData['id'],
            avatarUrl: $responseData['avatar_url'],
            username: $responseData['login'],
            name: $responseData['name'] ?? null,
            email: $responseData['email'] ?? null,
            bio: $responseData['bio'],
            githubUrl: $responseData['html_url'],
            blogUrl: $responseData['blog'],
            company: $responseData['company'],
            location: $responseData['location'],
            publicRepositories: $responseData['public_repos'] ?? 0,
            followers: $responseData['followers'] ?? 0,
            followings: $responseData['following'] ?? 0,
            createdAt: new DateTimeImmutable($responseData['created_at']),
            updatedAt: $responseData['updated_at'] ? new DateTimeImmutable($responseData['updated_at']) : null,
        );
    }
}
