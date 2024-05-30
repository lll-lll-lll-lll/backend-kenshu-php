<?php
declare(strict_types=1);

namespace App;

use App\Core\Database;
use App\Core\Router;
use App\Handler\CreateArticleHandler;
use App\Handler\CreateUserHandler;
use App\Handler\GetArticleHandler;
use App\Handler\GetArticleListHandler;
use App\Repository\CreateArticleRepository;
use App\Repository\CreateUserRepository;
use App\Repository\GetArticleListRepository;
use App\Repository\GetArticleRepository;
use App\UseCase\CreateArticleUseCase;
use App\UseCase\GetArticleListUseCase;
use App\UseCase\GetArticleUseCase;
use App\UseCase\User\CreateUserUseCase;
use Exception;
use PDO;

class Main
{
    public Router $router;
    private CreateArticleHandler $articleCreateHandler;
    private GetArticleHandler $articleHandler;
    private GetArticleListHandler $articleListHandler;
    private CreateUserHandler $userCreateHandler;
    private PDO $pdo;

    public function __construct()
    {
        $this->router = new Router();
        $config = require 'Config.php';
        $this->pdo = Database::getConnection($config);
        $this->articleCreateHandler = new CreateArticleHandler(new CreateArticleUseCase($this->pdo, new CreateArticleRepository()));
        $this->articleHandler = new GetArticleHandler(new GetArticleUseCase($this->pdo, new GetArticleRepository()));
        $this->articleListHandler = new GetArticleListHandler(new GetArticleListUseCase($this->pdo, new GetArticleListRepository()));
        $this->userCreateHandler = new CreateUserHandler(new CreateUserUseCase($this->pdo, new CreateUserRepository()));
    }

    public function run(): void
    {
        session_start();
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->router->add('GET', '/articles', function () {
            echo $this->articleListHandler->render();
        });
        $this->router->add('POST', '/articles', function () {
            $this->articleCreateHandler->execute();
            header('Location: /articles');
        });
        $this->router->add('GET', '/articles/{id}', function (int $id) {
            echo $this->articleHandler->execute($id);
        });

        $this->router->add('POST', '/api/users', function () {
            $this->userCreateHandler->execute();
        });
        try {
            $this->router->dispatch($requestUri, $requestMethod);
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(500);
        }
    }
}
