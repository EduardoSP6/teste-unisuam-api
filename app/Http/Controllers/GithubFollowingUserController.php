<?php

namespace App\Http\Controllers;

use App\Http\Resources\GithubFollowingResource;
use Application\UseCases\GithubUsers\ListFollowingUsers\ListGithubFollowingUsersInputDto;
use Application\UseCases\GithubUsers\ListFollowingUsers\ListGithubFollowingUsersUseCase;
use Exception;
use Infrastructure\Gateways\GithubHttpGateway;
use Infrastructure\Persistence\Repositories\InMemory\GithubUserRepository;
use InvalidArgumentException;
use OpenApi\Annotations as OA;

class GithubFollowingUserController extends Controller
{
    private GithubUserRepository $githubUserRepository;

    public function __construct()
    {
        $this->githubUserRepository = new GithubUserRepository(new GithubHttpGateway());
    }

    /**
     * @OA\Get(
     *     path="/api/github-users/{username}/followings",
     *     operationId="listFollowingUsers",
     *     tags={"GithubUsers"},
     *     summary="Lista todos usuários seguidos.",
     *     description="Lista todos usuários seguidos.",
     *
     *     @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/GithubFollowingResource")
     *          ),
     *     ),
     * )
     */
    public function index(string $username)
    {
        try {
            $inputDto = new ListGithubFollowingUsersInputDto(
                username: $username
            );

            $listFollowingUsersUseCase = new ListGithubFollowingUsersUseCase(
                $this->githubUserRepository
            );

            $outputDto = $listFollowingUsersUseCase->execute($inputDto);

            return GithubFollowingResource::collection($outputDto->followingUsers);
        } catch (InvalidArgumentException $e) {
            abort(400, $e->getMessage());
        } catch (Exception) {
            abort(500, "Internal server error");
        }
    }
}
