<?php
declare(strict_types=1);

namespace App\UseCase\User;

use App\Model\UserPassword;
use App\Repository\GetUserFromMail;
use App\Request\LoginUserRequest;
use Exception;
use PDO;

class LoginUserUseCase
{
    public GetUserFromMail $getUserFromMail;
    private PDO $pdo;

    public function __construct(PDO $pdo, GetUserFromMail $getUserFromMail)
    {
        $this->pdo = $pdo;
        $this->getUserFromMail = $getUserFromMail;
    }

    /**
     * @throws Exception
     */
    public function execute(LoginUserRequest $req): void
    {
        try {
            $user = $this->getUserFromMail->execute($this->pdo, $req->mail);
            $this->checkPassword($req->getUserPassword(), $user->getHashPassword());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception rawPasswordが間違えている場合
     */
    private function checkPassword(UserPassword $userPassword, string $hashPassword): bool
    {
        if (!password_verify($userPassword->getRawPassword(), $hashPassword)) {
            throw new Exception('failed to validate password');
        }
        return true;
    }
}
