<?php

namespace Core;

use App\Core\Router;
use App\Handler\ArticleCreateHandler;
use App\MockRepository\CreateArticleMockRepository;
use App\Repository\Article\ICreateRepository;
use App\Request\CreateArticleRequest;
use App\UseCase\CreateArticleUseCase;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private ICreateRepository $createRepository;
    public function testDispatchSuccess()
    {
        $this->createRepository = new CreateArticleMockRepository();
        $articleHandler = new ArticleCreateHandler( new CreateArticleUseCase($this->createRepository));
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
        $this->createRepository = new CreateArticleMockRepository();
        $articleHandler = new ArticleCreateHandler( new CreateArticleUseCase($this->createRepository));
        $notFoundPath = '/test';
        $expected = '404 Not Found';

        $router = new Router();
        $router->add('GET', '/', function () use ($articleHandler) {
            $articleHandler->execute(new CreateArticleRequest('title', 'contents', 1));
        });

        ob_start();
        $router->dispatch($notFoundPath, 'GET');
        $output = ob_get_clean();
        $this->assertEquals($expected, $output);
    }
}
