<?php

namespace App\Http\Controllers;

use App\Http\Resources\GithubUserResource;
use Application\Exceptions\UserNotFoundException;
use Application\UseCases\GithubUsers\Find\FindGithubUserInputDto;
use Application\UseCases\GithubUsers\Find\FindGithubUserUseCase;
use Exception;
use Infrastructure\Gateways\GithubHttpGateway;
use Infrastructure\Persistence\Repositories\InMemory\GithubUserRepository;
use InvalidArgumentException;
use OpenApi\Annotations as OA;

class GithubUserController extends Controller
{
    private GithubUserRepository $githubUserRepository;

    public function __construct()
    {
        $this->githubUserRepository = new GithubUserRepository(new GithubHttpGateway());
    }

    /**
     * @OA\Get(
     *     path="/api/github-users/{username}",
     *     operationId="findGithubUser",
     *     tags={"GithubUsers"},
     *     summary="Exibe informaçõees de um usuário.",
     *     description="Exibe informaçõees de um usuário do Github pesquisando pelo username.",
     *
     *     @OA\Parameter(
     *          in="path",
     *          name="username",
     *          required=true,
     *          description="Username",
     *          @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/GithubUserResource"
     *          ),
     *     ),
     *
     *     @OA\Response(
     *          response="404",
     *          description="Usuário não encontrado.",
     *     ),
     *
     *     @OA\Response(
     *          response="400",
     *          description="Username fornecido é inválido.",
     *     ),
     *
     *     @OA\Response(
     *          response="500",
     *          description="Erro interno do servidor.",
     *     ),
     * )
     * @param string $username
     * @return GithubUserResource|void
     */
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
