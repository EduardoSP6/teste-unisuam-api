<?php

namespace Tests\Feature;

use Tests\TestCase;

class GithubUserTest extends TestCase
{
    public function test_it_should_find_a_github_user_successfully(): void
    {
        $username = "joaorca";

        $response = $this
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->get("/api/github-users/$username");

        $response->assertOk()->assertJsonStructure([
            "avatar",
            "name",
            "username",
            "bio",
            "githubUrl",
            "blogUrl",
            "company",
            "location",
            "publicRepositories",
            "followers",
            "followings",
        ]);
    }
}
