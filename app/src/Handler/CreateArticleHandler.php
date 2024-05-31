<?php
declare(strict_types=1);

namespace App\Handler;

use App\Request\CreateArticleRequest;
use App\UseCase\CreateArticleUseCase;
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
        $user_id = $_SESSION['user_id'] ?? 1;
        try {
            $req = new CreateArticleRequest(
                $_POST['title'] ?? '',
                $_POST['contents'] ?? '',
                $_POST['thumbnail_image_url'] ?? '',
                $user_id,
                $_POST['tags'] ?? []
            );

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
                        window.location.href = '/articles';
                    </script>
                </body>
                </html>
            ";
    }

}
