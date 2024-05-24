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
        $this->createArticleUseCase = new CreateArticleMockUseCase();
        $this->articleHandler = new ArticleCreateHandler($this->createArticleUseCase);

    }
    public function testDispatchSuccess()
    {
        $path = '/';
        $expected = '';
        $router = new Router();
        $router->add('GET', '/', function (){
        $this->articleHandler->execute( new CreateArticleRequest('test', 'test', 1));
        });

        ob_start();
        $router->dispatch($path, 'GET');
        $output = ob_get_clean();
        $this->assertEquals($expected, $output);
    }
    public function testDispatch404()
    {
        $notFoundPath = '/test';
        $router = new Router();
        $router->add('GET', '/', function () {
            $this->articleHandler->execute(new CreateArticleRequest('title', 'contents', 1));
        });

        $router->dispatch($notFoundPath, 'GET');
        $this->assertEquals(404, http_response_code());
    }
    }
