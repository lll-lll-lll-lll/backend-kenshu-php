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
    private ICreateArticleUseCase $createArticleUseCase;
    public ArticleCreateHandler $articleHandler;
    public function setup():void {
        $this->createArticleUseCase = new CreateArticleMockUseCase(new CreateArticleRepository());
        $this->articleHandler = new ArticleCreateHandler($this->createArticleUseCase);

    }
    public function testDispatchSuccess()
    {
        $articleHandler = new ArticleCreateHandler($this->createArticleUseCase);
        $path = '/';
        $expected = '';
        $router = new Router();
        $router->add('GET', '/', function () use ($articleHandler) {
            $articleHandler->execute( new CreateArticleRequest('test', 'test', 1));
        });

        ob_start();
        $router->dispatch($path, 'GET');
        $output = ob_get_clean();
        $this->assertEquals($expected, $output);
    }
    public function testDispatch404()
    {
        $notFoundPath = '/test';
        $expected = '404 Not Found';

        $router = new Router();
        $router->add('GET', '/', function () {
            $this->articleHandler->execute(new CreateArticleRequest('title', 'contents', 1));
        });

        ob_start();
        $router->dispatch($notFoundPath, 'GET');
        $output = ob_get_clean();
        $this->assertEquals($expected, $output);
    }
}
