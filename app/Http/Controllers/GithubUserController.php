<?php

namespace App\Http\Controllers;

use App\Http\Resources\GithubUserResource;
use Application\Exceptions\UserNotFoundException;
use Application\UseCases\GithubUsers\Find\FindGithubUserInputDto;
use Application\UseCases\GithubUsers\Find\FindGithubUserUseCase;
use Exception;
use Infrastructure\Gateways\GithubHttpGateway;
use Infrastructure\Repositories\GithubUserRepository;
use InvalidArgumentException;

class GithubUserController extends Controller
{
    private GithubUserRepository $githubUserRepository;

    public function __construct()
    {
        $this->githubUserRepository = new GithubUserRepository(new GithubHttpGateway());
    }

    public function show(string $username)
    {
        try {
            $inputDto = new FindGithubUserInputDto($username);

            $findGithubUserUseCase = new FindGithubUserUseCase(
                $this->githubUserRepository
            );

            $outputDto = $findGithubUserUseCase->execute($inputDto);

            return GithubUserResource::make($outputDto->githubUser);
        } catch (UserNotFoundException) {
            abort(404, "Usuário não encontrado");
        } catch (InvalidArgumentException $e) {
            abort(400, $e->getMessage());
        } catch (Exception) {
            abort(500, "Internal server error");
        }
    }
}
