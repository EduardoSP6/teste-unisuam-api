<?php

namespace Domain\Core\Entity;

use DateTimeImmutable;
use Domain\Core\Interfaces\GithubUserInterface;
use Domain\Shared\Entity\BaseEntity;
use Domain\Shared\ValueObject\Id;
use InvalidArgumentException;

class GithubUser extends BaseEntity implements GithubUserInterface
{
    private Id $id;
    private ?string $avatarUrl;
    private string $username;
    private ?string $bio;
    private string $githubUrl;
    private ?string $blogUrl;
    private ?string $company;
    private ?string $location;
    private int $publicRepositories;
    private int $followers;
    private int $followings;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable|null $updatedAt;

    /** @var GithubUserInterface[] $followingUsers */
    private array $followingUsers;

    public function __construct(Id $id, ?string $avatarUrl, string $username, ?string $bio, string $githubUrl, ?string $blogUrl, ?string $company, ?string $location, int $publicRepositories, int $followers, int $followings, DateTimeImmutable $createdAt, ?DateTimeImmutable $updatedAt = null, array $followingUsers = [])
    {
        parent::__construct($id, $createdAt, $updatedAt);

        $this->id = $id;
        $this->avatarUrl = $avatarUrl;
        $this->username = $username;
        $this->bio = $bio;
        $this->githubUrl = $githubUrl;
        $this->blogUrl = $blogUrl;
        $this->company = $company;
        $this->location = $location;
        $this->publicRepositories = $publicRepositories;
        $this->followers = $followers;
        $this->followings = $followings;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->followingUsers = $followingUsers;

        $this->validate();
    }

    protected function validate(): void
    {
        throw_if(
            empty(trim($this->username)),
            new InvalidArgumentException("Username can not be empty")
        );

        if (!empty($this->avatarUrl)) {
            throw_if(
                filter_var($this->avatarUrl,
                    FILTER_VALIDATE_URL,
                    FILTER_FLAG_PATH_REQUIRED) === false,
                new InvalidArgumentException("Invalid avatar url")
            );
        }

        throw_if(
            filter_var($this->githubUrl,
                FILTER_VALIDATE_URL,
                FILTER_FLAG_PATH_REQUIRED) === false,
            new InvalidArgumentException("Invalid Github url")
        );

        if (!empty($this->blogUrl)) {
            throw_if(
                filter_var($this->blogUrl,
                    FILTER_VALIDATE_URL,
                    FILTER_FLAG_PATH_REQUIRED) === false,
                new InvalidArgumentException("Invalid blog url")
            );
        }

        throw_if(
            $this->publicRepositories < 0,
            new InvalidArgumentException("Public repositories can not be negative")
        );

        throw_if(
            $this->followers < 0,
            new InvalidArgumentException("Followers can not be negative")
        );

        throw_if(
            $this->followings < 0,
            new InvalidArgumentException("Followings can not be negative")
        );
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @return string
     */
    public function getGithubUrl(): string
    {
        return $this->githubUrl;
    }

    /**
     * @return string|null
     */
    public function getBlogUrl(): ?string
    {
        return $this->blogUrl;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @return int
     */
    public function getPublicRepositories(): int
    {
        return $this->publicRepositories;
    }

    /**
     * @return int
     */
    public function getFollowers(): int
    {
        return $this->followers;
    }

    /**
     * @return int
     */
    public function getFollowings(): int
    {
        return $this->followings;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return GithubUserInterface[]
     */
    public function getFollowingUsers(): array
    {
        return $this->followingUsers;
    }

    /**
     * @param GithubUserInterface $user
     * @return void
     */
    public function addFollowing(GithubUserInterface $user): void
    {
        $this->followingUsers[] = $user;
    }
}
