<?php

namespace App\Http\Resources;

use Domain\Core\Entity\GithubFollowingUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="GithubFollowingResource",
 *     type="object",
 *
 *     @OA\Property(
 *          property="avatar",
 *          type="string",
 *          description="Url do avatar"
 *     ),
 *
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nome"
 *     ),
 *
 *     @OA\Property(
 *          property="username",
 *          type="string",
 *          description="Nome de usuário"
 *     ),
 *
 *     @OA\Property(
 *          property="bio",
 *          type="string",
 *          description="Bio"
 *     ),
 *
 *     @OA\Property(
 *          property="company",
 *          type="string",
 *          description="Nome da empresa."
 *     ),
 *
 *     @OA\Property(
 *          property="location",
 *          type="string",
 *          description="Local."
 *     ),
 * )
 */
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
