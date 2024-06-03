<?php
declare(strict_types=1);

namespace App\UseCase\User;

use App\Model\UserPassword;
use App\Repository\CreateUserRepository;
use App\Request\CreateUserRequest;
use Exception;
use PDO;
use PDOException;

class CreateUserUseCase
{
    private PDO $pdo;

    private CreateUserRepository $createUserRepository;

    public function __construct(PDO $pdo, CreateUserRepository $createUserRepository)
    {
        $this->pdo = $pdo;
        $this->createUserRepository = $createUserRepository;
    }

    public function execute(CreateUserRequest $req): void
    {
        $this->pdo->beginTransaction();
        try {
            $userPassword = new UserPassword($req->password);
            $this->createUserRepository->execute($this->pdo, $req->userName, $req->mail, $userPassword->getHashPassword(), $req->profileUrl);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log('CreateUserUseCase/' . $e->getMessage());
            throw new PDOException($e->getMessage());
        }
    }
}
