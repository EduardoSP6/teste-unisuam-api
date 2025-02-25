<?php

namespace Domain\Core\Entity;

use Domain\Core\Interfaces\GithubUserInterface;
use Domain\Shared\ValueObject\Id;
use InvalidArgumentException;

class GithubFollowingUser implements GithubUserInterface
{
    private Id $id;
    private ?string $name;
    private string $username;
    private ?string $avatarUrl;
    private ?string $bio;
    private ?string $company;
    private ?string $location;

    public function __construct(Id $id, ?string $name, string $username, ?string $avatarUrl, ?string $bio, ?string $company, ?string $location)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->avatarUrl = $avatarUrl;
        $this->bio = $bio;
        $this->company = $company;
        $this->location = $location;

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
    public function getName(): ?string
    {
        return $this->name;
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
    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    /**
     * @return string|null
     */
    public function getBio(): ?string
    {
        return $this->bio;
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
}
