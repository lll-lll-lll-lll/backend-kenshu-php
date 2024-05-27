<?php
declare(strict_types=1);

namespace App\Handler;

use App\Request\CreateArticleRequest;
use App\UseCase\CreateArticleUseCase;
use Exception;

class ArticleCreateHandler
{
    public CreateArticleUseCase $articleCreateUseCase;

    public function __construct(CreateArticleUseCase $articleCreateUseCase)
    {
        $this->articleCreateUseCase = $articleCreateUseCase;
    }

    public function execute(): int
    {
        try {
            $req = new CreateArticleRequest($_POST['title'], $_POST['contents'], $_POST['user_id']);
            $lastInsertedId = $this->articleCreateUseCase->execute($req);
            http_response_code(201);
            return $lastInsertedId;
        } catch (Exception $e) {
            throw  new Exception($e->getMessage());
        }
    }
}
