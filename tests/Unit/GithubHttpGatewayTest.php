<?php

namespace Tests\Unit;

use Application\DTO\GithubUserOutputDto;
use Application\Interfaces\GithubGatewayInterface;
use Illuminate\Http\Client\ConnectionException;
use Infrastructure\Gateways\GithubHttpGateway;
use Tests\TestCase;

class GithubHttpGatewayTest extends TestCase
{
    protected GithubGatewayInterface $githubGateway;

    protected function setUp(): void
    {
        parent::setUp();

        $this->githubGateway = new GithubHttpGateway();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->githubGateway);
    }

    /**
     * @throws ConnectionException
     */
    public function test_it_should_fail_to_find_user_with_no_existent_username()
    {
        $username = uniqid("gh-");

        $githubUserOutputDto = $this->githubGateway->findUserByUsername($username);

        $this->assertNull($githubUserOutputDto);
    }

    /**
     * @throws ConnectionException
     */
    public function test_it_should_find_a_github_user_successfully()
    {
        $username = "joaorca";

        $githubUserOutputDto = $this->githubGateway->findUserByUsername($username);

        $this->assertNotNull($githubUserOutputDto);
        $this->assertInstanceOf(GithubUserOutputDto::class, $githubUserOutputDto);
        $this->assertEquals($username, $githubUserOutputDto->username);
    }

    /**
     * @return void
     * @throws ConnectionException
     */
    public function test_it_should_fail_to_list_a_user_followings_with_invalid_username(): void
    {
        $username = uniqid("gh-");

        $followingUsersCollection = $this->githubGateway->listFollowings($username);

        $this->assertIsArray($followingUsersCollection);
        $this->assertCount(0, $followingUsersCollection);
    }

    /**
     * @return void
     * @throws ConnectionException
     */
    public function test_it_should_list_a_user_followings_successfully(): void
    {
        $username = "joaorca";

        $followingUsersCollection = $this->githubGateway->listFollowings($username);

        $this->assertIsArray($followingUsersCollection);
        $this->assertGreaterThan(1, count($followingUsersCollection));
    }
}
