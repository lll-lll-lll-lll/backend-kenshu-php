<?php
declare(strict_types=1);

namespace App\Handler\User;

use App\Request\LoginUserRequest;
use App\UseCase\User\LoginUserUseCase;
use App\View\LoginView;
use Exception;

class LoginUserHandler
{
    private LoginUserUseCase $loginUserUseCase;

    public function __construct(LoginUserUseCase $loginUserUseCase)
    {
        $this->loginUserUseCase = $loginUserUseCase;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        try {
            $req = new LoginUserRequest($_POST);
            $this->loginUserUseCase->execute($req);
        } catch (Exception $e) {
            echo LoginView::FailedLogin();
        }
    }
}
