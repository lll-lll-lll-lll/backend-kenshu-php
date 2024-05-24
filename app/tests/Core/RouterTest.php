<?php

namespace Core;

use App\Core\Router;
use App\Handler\ArticleCreateHandler;
use App\MockUseCase\CreateArticleMockUseCase;
use App\Repository\CreateArticleRepository;
use App\Request\CreateArticleRequest;
use App\UseCase\ICreateArticleUseCase;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    public function setup(): void
    {
        $this->router = new Router();
    }

    public function testDispatchSuccess()
    {
        $path = '/';
        $this->router->add('GET', $path, function () {
            http_response_code(201);
        });

        $this->router->dispatch($path, 'GET');
        $this->assertEquals(201, http_response_code());
    }

    public function testDispatch404()
    {
        $notFoundPath = '/test';
        $this->router->add('GET', '/', function () {
        });
        $this->router->dispatch($notFoundPath, 'GET');
        $this->assertEquals(404, http_response_code());
    }
}
