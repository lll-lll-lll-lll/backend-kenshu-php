<?php
declare(strict_types=1);

namespace App\Handler;

use App\Request\CreateUserRequest;
use App\UseCase\User\CreateUserUseCase;
use Exception;

class CreateUserHandler
{
    private CreateUserUseCase $createUserUseCase;

    public function __construct(CreateUserUseCase $createUserUseCase)
    {
        $this->createUserUseCase = $createUserUseCase;
    }

    public function execute(): void
    {
        try {
            $req = new CreateUserRequest($_POST);
            $this->createUserUseCase->execute($req);
            http_response_code(201);
        } catch (Exception $e) {
            error_log('CreateUserHandler/' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
