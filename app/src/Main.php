<?php
declare(strict_types=1);

namespace App;

use App\Auth\Session;
use App\Core\Database;
use App\Core\Router;
use App\Handler\Article\CreateArticleHandler;
use App\Handler\Article\GetArticleHandler;
use App\Handler\Article\GetArticleListHandler;
use App\Handler\Tag\GetTagListHandler;
use App\Handler\User\CreateUserHandler;
use App\Handler\User\LoginUserHandler;
use App\Handler\User\LogoutUserHandler;
use App\Middleware\CheckLoginStatus as CheckLoginStatusMiddleware;
use App\Repository\Article\CreateArticleImageRepository;
use App\Repository\Article\CreateArticleRepository;
use App\Repository\Article\CreateArticleTagRepository;
use App\Repository\Article\GetArticleListRepository;
use App\Repository\Article\GetArticleRepository;
use App\Repository\Tag\GetTagListRepository;
use App\Repository\User\CreateUserRepository;
use App\Repository\User\GetUserFromMail;
use App\UseCase\Article\CreateArticleUseCase;
use App\UseCase\Article\GetArticleListUseCase;
use App\UseCase\Article\GetArticleUseCase;
use App\UseCase\Tag\GetTagListUseCase;
use App\UseCase\User\CreateUserUseCase;
use App\UseCase\User\LoginUserUseCase;
use App\UseCase\User\LogoutUseCase;
use App\View\ArticleListView;
use App\View\Header;
use App\View\LoginView;
use App\View\LogoutView;
use App\View\MainView;
use App\View\RegisterUserView;
use Exception;
use PDO;

class Main
{
    public Router $router;
    private CreateArticleHandler $articleCreateHandler;
    private GetArticleHandler $articleHandler;
    private GetArticleListHandler $articleListHandler;
    private CreateUserHandler $userCreateHandler;
    private GetTagListHandler $tagListHandler;
    private ArticleListView $articleListView;
    private RegisterUserView $registerUserView;
    private PDO $pdo;
    private LoginView $loginView;
    private LogoutView $logoutView;
    private LoginUserHandler $loginUserHandler;
    private LogoutUserHandler $logoutUserHandler;

    public function __construct()
    {
        $this->router = new Router();
        $config = require 'Config.php';
        $this->pdo = Database::getConnection($config);
        $this->articleCreateHandler = new CreateArticleHandler(
            new CreateArticleUseCase(
                $this->pdo,
                new CreateArticleRepository(),
                new CreateArticleTagRepository(),
                new CreateArticleImageRepository())
        );
        $this->articleHandler = new GetArticleHandler(new GetArticleUseCase($this->pdo, new GetArticleRepository()));
        $this->articleListHandler = new GetArticleListHandler(new GetArticleListUseCase($this->pdo, new GetArticleListRepository()));
        $this->userCreateHandler = new CreateUserHandler(new CreateUserUseCase($this->pdo, new CreateUserRepository()));
        $this->tagListHandler = new GetTagListHandler($this->pdo, new GetTagListUseCase($this->pdo, new GetTagListRepository()));
        $this->articleListView = new ArticleListView($this->articleListHandler, $this->tagListHandler);
        $this->registerUserView = new RegisterUserView();
        $this->loginUserHandler = new LoginUserHandler(new LoginUserUseCase($this->pdo, new GetUserFromMail()));
        $this->loginView = new LoginView();
        $this->logoutView = new LogoutView();
        $this->logoutUserHandler = new LogoutUserHandler(new LogoutUseCase());
    }

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->router->add('GET', '/articles', function () {
            echo $this->articleListView->render();
        });
        $this->router->add('POST', '/articles', function () {
            $this->articleCreateHandler->execute();
            header('Location: /articles');
        }, function () {
            Session::start();
            if (!CheckLoginStatusMiddleware::isLogin($_SESSION, $_COOKIE)) {
                echo LoginView::renderNotLogin();
                exit();
            }
        });
        $this->router->add('GET', '/articles/{id}', function (int $id) {
            echo $this->articleHandler->execute($id);
        }, function () {
            Session::start();
            if (!CheckLoginStatusMiddleware::isLogin($_SESSION, $_COOKIE)) {
                header(header: 'Location: /login');
            }
        });
        $this->router->add('GET', '/register', function () {
            echo $this->registerUserView->execute();
        });
        $this->router->add('GET', '/login', function () {
            echo $this->loginView->execute();
        }, function () {
            Session::start();
            if (CheckLoginStatusMiddleware::isLogin($_SESSION, $_COOKIE)) {
                header('Location: /articles');
            }
        });
        $this->router->add('POST', '/api/login', function () {
            $this->loginUserHandler->execute();
            header('Location: /articles');
        });
        $this->router->add('GET', '/logout', function () {
            echo $this->logoutView->execute();
        }, function () {
            Session::start();
            if (!CheckLoginStatusMiddleware::isLogin($_SESSION, $_COOKIE)) {
                header('Location: /');
                exit();
            }
        });
        $this->router->add('POST', '/api/logout', function () {
            $this->logoutUserHandler->execute();
            header('Location: /');
        }, function () {
            Session::start();
            if (!CheckLoginStatusMiddleware::isLogin($_SESSION, $_COOKIE)) {
                header('Location: /');
            }
        });
        $this->router->add('POST', '/api/users', function () {
            $this->userCreateHandler->execute();
            header('Location: /articles');
        });
        try {
            $this->router->dispatch($requestUri, $requestMethod);
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(500);
        }
    }
}
