<?php
declare(strict_types=1);

namespace App;

use App\Core\Database;
use App\Core\Router;
use App\Handler\ArticleCreateHandler;
use App\Repository\CreateArticleRepository;
use App\Request\CreateArticleRequest;
use App\UseCase\CreateArticleUseCase;
use PDO;
use PDOException;

class Main
{
    public Router $router;
    private ArticleCreateHandler $articleCreateHandler;
    private PDO $pdo;
    public function __construct()
    {
        $this->router = new Router();
        $config = require 'Config.php';
        $this->pdo = Database::getConnection($config);
        $this->articleCreateHandler = new ArticleCreateHandler(new CreateArticleUseCase($this->pdo, new CreateArticleRepository()));
    }
    public function  run():void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->router->add('POST', '/article',function (
        ){
            try {
                $req = new CreateArticleRequest($_POST['title'], $_POST['contents'], (int)$_POST['user_id']);
                $this->articleCreateHandler->execute($req);
                http_response_code(201);
            }
            catch (PDOException $e){
                http_response_code(500);
                echo 'Internal Server Error';
            }
        });
        $this->router->dispatch($requestUri, $requestMethod);
    }
}
