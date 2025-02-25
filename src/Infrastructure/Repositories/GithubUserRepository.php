<?php

namespace Infrastructure\Repositories;

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

        $githubUser = new GithubUser(
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

        if ($githubUser->getFollowings() > 0) {
            $followingsOutputDto = $this->githubGateway->listFollowings($githubUser->getUsername());

            if (count($followingsOutputDto) > 0) {
                foreach ($followingsOutputDto as $fUserDto) {
                    $followingUser = new GithubFollowingUser(
                        id: new Id($fUserDto->id),
                        name: $fUserDto->name,
                        username: $fUserDto->username,
                        avatarUrl: $fUserDto->avatarUrl,
                        bio: $fUserDto->bio,
                        company: $fUserDto->company,
                        location: $fUserDto->location,
                    );

                    $githubUser->addFollowing($followingUser);
                }
            }
        }

        return $githubUser;
    }
}
