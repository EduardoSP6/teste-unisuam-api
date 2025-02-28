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
    private ?string $name;
    private ?string $email;
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

    public function __construct(Id $id, ?string $avatarUrl, string $username, ?string $name, ?string $email, ?string $bio, string $githubUrl, ?string $blogUrl, ?string $company, ?string $location, int $publicRepositories, int $followers, int $followings, DateTimeImmutable $createdAt, ?DateTimeImmutable $updatedAt = null)
    {
        parent::__construct($id, $createdAt, $updatedAt);

        $this->id = $id;
        $this->avatarUrl = $avatarUrl;
        $this->username = $username;
        $this->name = $name;
        $this->email = $email;
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

        if (!empty($this->email)) {
            throw_if(
                filter_var($this->email, FILTER_VALIDATE_EMAIL) === false,
                new InvalidArgumentException("Invalid user email")
            );
        }

        if (!empty($this->blogUrl)) {
            throw_if(
                filter_var($this->blogUrl,
                    FILTER_VALIDATE_URL) === false,
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
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
}
