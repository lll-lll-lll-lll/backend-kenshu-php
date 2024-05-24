<?php
declare(strict_types=1);

namespace App\Handler;

use App\Request\CreateArticleRequest;
use App\UseCase\ICreateArticleUseCase;
use Exception;

class ArticleCreateHandler
{
    public ICreateArticleUseCase $articleCreateUseCase;

    public function __construct(ICreateArticleUseCase $articleCreateUseCase)
    {
        $this->articleCreateUseCase = $articleCreateUseCase;
    }

    public function execute(): int
    {
        try {
            $req = new CreateArticleRequest($_POST['title'], $_POST['contents'], $_POST['user_id']);
            $lastInsertedId = $this->articleCreateUseCase->execute($req->title, $req->contents, $req->user_id);
            http_response_code(201);
            return $lastInsertedId;
        } catch (Exception $e) {
            throw  new Exception($e->getMessage());
        }
    }
}
