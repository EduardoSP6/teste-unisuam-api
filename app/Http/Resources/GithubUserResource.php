<?php

namespace App\Http\Resources;

use Domain\Core\Entity\GithubUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="GithubUserResource",
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
 *          property="githubUrl",
 *          type="string",
 *          description="Url do perfil no Github."
 *     ),
 *
 *     @OA\Property(
 *          property="blogUrl",
 *          type="string",
 *          description="Url do blog."
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
 *
 *     @OA\Property(
 *          property="publicRepositories",
 *          type="number",
 *          description="Quantidade de repositórios públicos."
 *     ),
 *
 *     @OA\Property(
 *          property="followers",
 *          type="number",
 *          description="Quantidade de seguidores."
 *     ),
 *
 *     @OA\Property(
 *          property="followings",
 *          type="number",
 *          description="Quantidade de pessoas que o seguem."
 *     ),
 * )
 */
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
        ];
    }
}
