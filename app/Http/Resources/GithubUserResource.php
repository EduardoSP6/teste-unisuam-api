<?php

namespace App\Http\Resources;

use Domain\Core\Entity\GithubUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GithubUserResource extends JsonResource
{
    private GithubUser $githubUser;

    public function __construct(GithubUser $githubUser)
    {
        parent::__construct($this);
        $this->githubUser = $githubUser;
    }

    public function toArray(Request $request): array
    {
        $followingUsers = $this->githubUser->getFollowingUsers();

        return [
            'avatar' => $this->githubUser->getAvatarUrl(),
            'name' => $this->githubUser->getName(),
            'username' => $this->githubUser->getUsername(),
            'bio' => $this->githubUser->getBio(),
            'githubUrl' => $this->githubUser->getGithubUrl(),
            'blogUrl' => $this->githubUser->getBlogUrl(),
            'company' => $this->githubUser->getCompany(),
            'location' => $this->githubUser->getLocation(),
            'publicRepositories' => $this->githubUser->getPublicRepositories(),
            'followers' => $this->githubUser->getFollowers(),
            'followings' => $this->githubUser->getFollowings(),
            'followingUsers' => count($followingUsers) > 0 ? GithubFollowingResource::collection($followingUsers) : [],
        ];
    }
}
