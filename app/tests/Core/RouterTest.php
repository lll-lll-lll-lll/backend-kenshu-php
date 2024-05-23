<?php

namespace Core;

use App\Core\Router;
use App\Handler\ArticleCreateHandler;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testDispatchSuccess()
    {
        $expected = 'ArticleCreateHandler called';
        $router = new Router();
        $articleHandler = new ArticleCreateHandler();
        $router->add('GET', '/',function (
        ){
            $articleHandler = new ArticleCreateHandler();
            $articleHandler->handle();
        });

        ob_start();
        $router->dispatch('/', 'GET');
        $output = ob_get_clean();
        $this->assertEquals($expected, $output);
    }

    public function testDispatch404()
    {

        $notFoundPath = '/test';
        $expected = '404 Not Found';

        $router = new Router();
        $router->add('GET', '/', function () {
            $articleHandler = new ArticleCreateHandler();
            $articleHandler->handle();
        });

        ob_start();
        $router->dispatch($notFoundPath, 'GET');
        $output = ob_get_clean();
        $this->assertEquals($expected, $output);
    }
}
