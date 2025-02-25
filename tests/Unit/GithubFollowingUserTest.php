<?php

namespace Tests\Unit;

use Domain\Core\Entity\GithubFollowingUser;
use Domain\Shared\ValueObject\Id;
use Faker\Factory as Faker;
use Faker\Generator;
use InvalidArgumentException;
use Tests\TestCase;

class GithubFollowingUserTest extends TestCase
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

    public function test_it_should_fail_to_create_a_github_following_user_with_empty_username(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Username can not be empty");

        new GithubFollowingUser(
            id: new Id($this->faker->numberBetween(1)),
            name: $this->faker->name,
            username: "   ",
            avatarUrl: $this->faker->imageUrl,
            bio: null,
            company: $this->faker->company,
            location: $this->faker->city,
        );
    }

    public function test_it_should_fail_to_create_a_github_following_user_with_invalid_avatar_url(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid avatar url");

        $avatarUrl = "htto://._r829r32rh923.com";

        new GithubFollowingUser(
            id: new Id($this->faker->numberBetween(1)),
            name: $this->faker->name,
            username: $this->faker->userName,
            avatarUrl: $avatarUrl,
            bio: null,
            company: $this->faker->company,
            location: $this->faker->city,
        );
    }

    public function test_it_should_create_a_github_following_user_successfully(): void
    {
        $followingUser = new GithubFollowingUser(
            id: new Id($this->faker->numberBetween(1)),
            name: $this->faker->name,
            username: $this->faker->userName,
            avatarUrl: $this->faker->imageUrl,
            bio: $this->faker->realText(),
            company: $this->faker->company,
            location: $this->faker->city,
        );

        $this->assertNotNull($followingUser);
        $this->assertInstanceOf(GithubFollowingUser::class, $followingUser);
    }
}
