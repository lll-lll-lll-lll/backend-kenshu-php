<?php
declare(strict_types=1);

namespace App\Handler\User;

use App\UseCase\User\LogoutUseCase;

class LogoutUserHandler
{
    private LogoutUseCase $logoutUserUseCase;

    public function __construct(LogoutUseCase $logoutUserUseCase)
    {
        $this->logoutUserUseCase = $logoutUserUseCase;
    }

    public function execute(): void
    {
        $this->logoutUserUseCase->execute();
    }
}
