<?php

namespace App\Http\Controllers;

use App\Http\Resources\GithubFollowingResource;
use Application\UseCases\GithubUsers\ListFollowingUsers\ListGithubFollowingUsersInputDto;
use Application\UseCases\GithubUsers\ListFollowingUsers\ListGithubFollowingUsersUseCase;
use Exception;
use Infrastructure\Gateways\GithubHttpGateway;
use Infrastructure\Repositories\GithubUserRepository;
use InvalidArgumentException;

class GithubFollowingUserController extends Controller
{
    private GithubUserRepository $githubUserRepository;

    public function __construct()
    {
        $this->githubUserRepository = new GithubUserRepository(new GithubHttpGateway());
    }

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
