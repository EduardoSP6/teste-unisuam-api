<?php

namespace Infrastructure\Persistence\Repositories\InMemory;

use Application\Interfaces\GithubGatewayInterface;
use Application\Interfaces\GithubUserRepositoryInterface;
use Domain\Core\Entity\GithubFollowingUser;
use Domain\Core\Entity\GithubUser;
use Domain\Shared\ValueObject\Id;

class GithubUserRepository implements GithubUserRepositoryInterface
{
    private GithubGatewayInterface $githubGateway;

    public function __construct(GithubGatewayInterface $githubGateway)
    {
        $this->githubGateway = $githubGateway;
    }

    public function findUserByUsername(string $username): ?GithubUser
    {
        $userOutputDto = $this->githubGateway->findUserByUsername($username);

        if (!$userOutputDto) return null;

        return new GithubUser(
            id: new Id($userOutputDto->id),
            avatarUrl: $userOutputDto->avatarUrl,
            username: $userOutputDto->username,
            name: $userOutputDto->name,
            bio: $userOutputDto->bio,
            githubUrl: $userOutputDto->githubUrl,
            blogUrl: $userOutputDto->blogUrl,
            company: $userOutputDto->company,
            location: $userOutputDto->location,
            publicRepositories: $userOutputDto->publicRepositories,
            followers: $userOutputDto->followers,
            followings: $userOutputDto->followings,
            createdAt: $userOutputDto->createdAt,
            updatedAt: $userOutputDto->updatedAt
        );
    }

    public function listFollowingUsers(string $username): array
    {
        $followingsOutputDto = $this->githubGateway->listFollowings($username);

        if (count($followingsOutputDto) === 0) return [];

        $followingUsers = [];

        foreach ($followingsOutputDto as $fUserDto) {
            $followingUsers[] = new GithubFollowingUser(
                id: new Id($fUserDto->id),
                name: $fUserDto->name,
                username: $fUserDto->username,
                avatarUrl: $fUserDto->avatarUrl,
                bio: $fUserDto->bio,
                company: $fUserDto->company,
                location: $fUserDto->location,
            );
        }

        return $followingUsers;
    }
}
