<?php
declare(strict_types=1);

namespace App\Handler;

use App\Request\CreateUserRequest;
use App\UseCase\User\ICreateUserUseCase;
use Exception;

class UserCreateHandler
{
    private ICreateUserUseCase $createUserUseCase;

    public function __construct(ICreateUserUseCase $createUserUseCase)
    {
        $this->createUserUseCase = $createUserUseCase;
    }

    public function execute(): void
    {
        try {
            $req = new CreateUserRequest($_POST['user_name'], $_POST['email'], $_POST['password']);
            $this->createUserUseCase->execute($req);
            http_response_code(201);
        } catch (Exception $e) {
            error_log('UserCreateHandler/' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
