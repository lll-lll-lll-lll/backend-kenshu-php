<?php
declare(strict_types=1);

namespace App\Handler\Article;

use App\Request\CreateArticleRequest;
use App\UseCase\Article\CreateArticleUseCase;
use Exception;

class CreateArticleHandler
{
    public CreateArticleUseCase $articleCreateUseCase;

    public function __construct(CreateArticleUseCase $articleCreateUseCase)
    {
        $this->articleCreateUseCase = $articleCreateUseCase;
    }

    public function execute(): void
    {
        try {
            $req = new CreateArticleRequest($_POST, $_SESSION, $_FILES);
            $this->articleCreateUseCase->execute($req);
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(500);
            echo $this->renderFailedAlert();
        }
    }

    private function renderFailedAlert(): string
    {
        return "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'><title></title>
                </head>
                <body>
                    <script>
                        alert('失敗しました');
                        window.location.href = '/';
                    </script>
                </body>
                </html>
            ";
    }

}
