<?php
declare(strict_types=1);

namespace App;

use App\Core\Database;
use App\Core\Router;
use App\Handler\ArticleCreateHandler;
use App\Handler\GetArticleListHandler;
use App\Handler\UserCreateHandler;
use App\Repository\CreateArticleRepository;
use App\Repository\CreateUserRepository;
use App\Repository\GetArticleListRepository;
use App\UseCase\CreateArticleUseCase;
use App\UseCase\GetArticleListUseCase;
use App\UseCase\User\CreateUserUseCase;
use Exception;
use PDO;

class Main
{
    public Router $router;
    private ArticleCreateHandler $articleCreateHandler;
    private GetArticleListHandler $articleListHandler;
    private UserCreateHandler $userCreateHandler;
    private PDO $pdo;

    public function __construct()
    {
        $this->router = new Router();
        $config = require 'Config.php';
        $this->pdo = Database::getConnection($config);
        $this->articleCreateHandler = new ArticleCreateHandler(new CreateArticleUseCase($this->pdo, new CreateArticleRepository()));
        $this->articleListHandler = new GetArticleListHandler(new GetArticleListUseCase($this->pdo, new GetArticleListRepository()));
        $this->userCreateHandler = new UserCreateHandler(new CreateUserUseCase($this->pdo, new CreateUserRepository()));
    }

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->router->add('GET', '/articles', function () {
            echo $this->articleListHandler->render();
        });
        $this->router->add('POST', '/api/articles', function () {
            $this->articleCreateHandler->execute();
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
