<?php

namespace Tests\Feature;

use Tests\TestCase;

class GithubFollowingUsersTest extends TestCase
{
    public function test_it_should_list_following_users_successfully(): void
    {
        $username = "joaorca";

        $response = $this
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->get("/api/github-users/$username/followings");

        $response->assertOk()->assertJsonStructure([
            "*" => [
                "avatar",
                "name",
                "username",
                "bio",
                "company",
                "location",
            ]
        ]);
    }
}
