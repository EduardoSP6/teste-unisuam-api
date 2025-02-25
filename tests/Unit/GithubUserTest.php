<?php

namespace Tests\Unit;

use DateTimeImmutable;
use Domain\Core\Entity\GithubUser;
use Domain\Shared\ValueObject\Id;
use Faker\Factory as Faker;
use Faker\Generator;
use InvalidArgumentException;
use Tests\TestCase;

class GithubUserTest extends TestCase
{
    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->faker);
    }

    public function test_it_should_fail_to_create_a_github_user_with_empty_username(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Username can not be empty");

        new GithubUser(
            id: new Id($this->faker->numberBetween(1)),
            avatarUrl: $this->faker->imageUrl,
            username: "   ",
            name: $this->faker->name,
            bio: null,
            githubUrl: $this->faker->url,
            blogUrl: null,
            company: $this->faker->company,
            location: $this->faker->city,
            publicRepositories: $this->faker->randomDigitNotZero(),
            followers: $this->faker->randomDigitNotZero(),
            followings: $this->faker->randomDigitNotZero(),
            createdAt: new DateTimeImmutable(),
        );
    }

    public function test_it_should_fail_to_create_a_github_user_with_invalid_avatar_url(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid avatar url");

        $avatarUrl = "htto://._r829r32rh923.com";

        new GithubUser(
            id: new Id($this->faker->numberBetween(1)),
            avatarUrl: $avatarUrl,
            username: $this->faker->userName,
            name: $this->faker->name,
            bio: null,
            githubUrl: $this->faker->url,
            blogUrl: null,
            company: $this->faker->company,
            location: $this->faker->city,
            publicRepositories: $this->faker->randomDigitNotZero(),
            followers: $this->faker->randomDigitNotZero(),
            followings: $this->faker->randomDigitNotZero(),
            createdAt: new DateTimeImmutable(),
        );
    }

    public function test_it_should_fail_to_create_a_github_user_with_invalid_github_url(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid Github url");

        $githubUrl = "httpx://r829r32rh923.com";

        new GithubUser(
            id: new Id($this->faker->numberBetween(1)),
            avatarUrl: $this->faker->imageUrl,
            username: $this->faker->userName,
            name: $this->faker->name,
            bio: null,
            githubUrl: $githubUrl,
            blogUrl: null,
            company: $this->faker->company,
            location: $this->faker->city,
            publicRepositories: $this->faker->randomDigitNotZero(),
            followers: $this->faker->randomDigitNotZero(),
            followings: $this->faker->randomDigitNotZero(),
            createdAt: new DateTimeImmutable(),
        );
    }

    public function test_it_should_fail_to_create_a_github_user_with_invalid_blog_url(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid blog url");

        $blogUrl = "iirno3n4r.uhihu";

        new GithubUser(
            id: new Id($this->faker->numberBetween(1)),
            avatarUrl: $this->faker->imageUrl,
            username: $this->faker->userName,
            name: $this->faker->name,
            bio: null,
            githubUrl: $this->faker->url,
            blogUrl: $blogUrl,
            company: $this->faker->company,
            location: $this->faker->city,
            publicRepositories: $this->faker->randomDigitNotZero(),
            followers: $this->faker->randomDigitNotZero(),
            followings: $this->faker->randomDigitNotZero(),
            createdAt: new DateTimeImmutable(),
        );
    }

    public function test_it_should_fail_to_create_a_github_user_with_negative_public_repositories(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Public repositories can not be negative");

        $publicRepositories = -283;

        new GithubUser(
            id: new Id($this->faker->numberBetween(1)),
            avatarUrl: $this->faker->imageUrl,
            username: $this->faker->userName,
            name: $this->faker->name,
            bio: null,
            githubUrl: $this->faker->url,
            blogUrl: $this->faker->url,
            company: $this->faker->company,
            location: $this->faker->city,
            publicRepositories: $publicRepositories,
            followers: $this->faker->randomDigitNotZero(),
            followings: $this->faker->randomDigitNotZero(),
            createdAt: new DateTimeImmutable(),
        );
    }

    public function test_it_should_fail_to_create_a_github_user_with_negative_followers(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Followers can not be negative");

        $followers = -23;

        new GithubUser(
            id: new Id($this->faker->numberBetween(1)),
            avatarUrl: $this->faker->imageUrl,
            username: $this->faker->userName,
            name: $this->faker->name,
            bio: null,
            githubUrl: $this->faker->url,
            blogUrl: $this->faker->url,
            company: $this->faker->company,
            location: $this->faker->city,
            publicRepositories: $this->faker->randomDigitNotZero(),
            followers: $followers,
            followings: $this->faker->randomDigitNotZero(),
            createdAt: new DateTimeImmutable(),
        );
    }

    public function test_it_should_fail_to_create_a_github_user_with_negative_followings(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Followings can not be negative");

        $followings = -79;

        new GithubUser(
            id: new Id($this->faker->numberBetween(1)),
            avatarUrl: $this->faker->imageUrl,
            username: $this->faker->userName,
            name: $this->faker->name,
            bio: null,
            githubUrl: $this->faker->url,
            blogUrl: $this->faker->url,
            company: $this->faker->company,
            location: $this->faker->city,
            publicRepositories: $this->faker->randomDigitNotZero(),
            followers: $this->faker->randomDigitNotZero(),
            followings: $followings,
            createdAt: new DateTimeImmutable(),
        );
    }

    public function test_it_should_create_a_github_user_successfully(): void
    {
        $githubUser = new GithubUser(
            id: new Id($this->faker->numberBetween(1)),
            avatarUrl: $this->faker->imageUrl,
            username: $this->faker->userName,
            name: $this->faker->name,
            bio: null,
            githubUrl: $this->faker->url,
            blogUrl: $this->faker->url,
            company: $this->faker->company,
            location: $this->faker->city,
            publicRepositories: $this->faker->randomDigitNotZero(),
            followers: $this->faker->randomDigitNotZero(),
            followings: $this->faker->randomDigitNotZero(),
            createdAt: new DateTimeImmutable(),
        );

        $this->assertNotNull($githubUser);
        $this->assertInstanceOf(GithubUser::class, $githubUser);
    }
}
