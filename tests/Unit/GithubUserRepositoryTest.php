<?php

namespace Tests\Unit;

use Domain\Core\Entity\GithubFollowingUser;
use Domain\Core\Entity\GithubUser;
use Infrastructure\Gateways\GithubHttpGateway;
use Infrastructure\Repositories\GithubUserRepository;
use Tests\TestCase;

class GithubUserRepositoryTest extends TestCase
{
    private GithubUserRepository $githubUserRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->githubUserRepository = new GithubUserRepository(new GithubHttpGateway());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->githubUserRepository);
    }

    public function test_it_should_find_a_github_user_successfully()
    {
        $username = "joaorca";

        $githubUser = $this->githubUserRepository->findUserByUsername($username);

        $this->assertNotNull($githubUser);
        $this->assertInstanceOf(GithubUser::class, $githubUser);
        $this->assertEquals($username, $githubUser->getUsername());
    }

    public function test_it_should_list_github_user_followings_successfully()
    {
        $username = "joaorca";

        $followingUsers = $this->githubUserRepository->listFollowingUsers($username);

        $this->assertIsArray($followingUsers);
        $this->assertGreaterThan(0, count($followingUsers));

        foreach ($followingUsers as $followingUser) {
            $this->assertInstanceOf(GithubFollowingUser::class, $followingUser);
        }
    }
}
