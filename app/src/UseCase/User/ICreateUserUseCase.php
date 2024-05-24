<?php
declare(strict_types=1);

namespace App\UseCase\User;

use App\Request\CreateUserRequest;

interface ICreateUserUseCase
{
    public function execute(CreateUserRequest $req): void;
}
