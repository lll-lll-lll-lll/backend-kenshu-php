<?php
declare(strict_types=1);

namespace App\UseCase\User;

use App\Auth\Cookie;
use App\Auth\Session;
use App\Repository\GetUserFromMail as GetUserFromMailRepository;
use App\Request\LoginUserRequest;
use Exception;
use PDO;

class LoginUserUseCase
{
    public GetUserFromMailRepository $getUserFromMailRepository;
    private PDO $pdo;

    public function __construct(PDO $pdo, GetUserFromMailRepository $getUserFromMailRepository)
    {
        $this->pdo = $pdo;
        $this->getUserFromMailRepository = $getUserFromMailRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(LoginUserRequest $req): void
    {
        try {
            $user = $this->getUserFromMailRepository->execute($this->pdo, $req->mail);
            $this->checkPassword($req->getRawPassword(), $user->getHashPassword());
            Session::start();
            Session::setSession($user->id);
            Cookie::setCookie(Session::SESSION_ID_KEY, session_id());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function checkPassword(string $rawPassword, string $hashPassword): void
    {
        if (!password_verify($rawPassword, $hashPassword)) {
            throw new Exception('failed to validate password');
        }
    }
}
