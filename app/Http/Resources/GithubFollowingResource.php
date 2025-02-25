<?php

namespace App\Http\Resources;

use Domain\Core\Entity\GithubFollowingUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GithubFollowingResource extends JsonResource
{
    private GithubFollowingUser $followingUser;

    public function __construct(GithubFollowingUser $followingUser)
    {
        parent::__construct($this);
        $this->followingUser = $followingUser;
    }

    public function toArray(Request $request): array
    {
        return [
            'avatar' => $this->followingUser->getAvatarUrl(),
            'name' => $this->followingUser->getName(),
            'username' => $this->followingUser->getUsername(),
            'bio' => $this->followingUser->getBio(),
            'company' => $this->followingUser->getCompany(),
            'location' => $this->followingUser->getLocation(),
        ];
    }
}
