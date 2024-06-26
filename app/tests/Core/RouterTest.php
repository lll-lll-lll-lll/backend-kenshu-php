<?php

namespace Core;

use App\Core\Router;
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

    public function testDifferentHTTPMethod404()
    {
        $reqMethod = 'POST';
        $path = '/';
        $this->router->add('GET', $path, function () {
        });
        $this->router->dispatch($path, $reqMethod);
        $this->assertEquals(404, http_response_code());
    }

    public function testDispatch404()
    {
        $notFoundPath = '/test';
        $this->router->add('GET', '/', function () {
        });
        $this->router->dispatch($notFoundPath, 'GET');
        $this->assertEquals(404, http_response_code());
    }

    public function testGetPathParameter()
    {
        $path = '/articles/{id}';
        $this->router->add('GET', $path, function (int $id) {
            echo $id;
        });
        ob_start();
        $this->router->dispatch('/articles/1', 'GET');
        $output = ob_get_clean();
        $this->assertSame('1', $output);
    }

    public function testInvalidPathParameter()
    {
        $path = '/articles/${id}';
        $this->router->add('GET', $path, function (int $id) {
            echo $id;
        });
        ob_start();
        $this->router->dispatch('/articles/abc', 'GET');
        $output = ob_get_clean();
        $this->assertEquals('Not Found', $output);
    }
}
