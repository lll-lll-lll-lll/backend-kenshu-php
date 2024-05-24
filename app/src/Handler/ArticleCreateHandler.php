<?php
declare(strict_types=1);

namespace App\Handler;

use App\Request\CreateArticleRequest;
use App\UseCase\ICreateArticleUseCase;

class ArticleCreateHandler
{
    public ICreateArticleUseCase $articleCreateUseCase;
    public function __construct(ICreateArticleUseCase $articleCreateUseCase)
    {
        $this->articleCreateUseCase = $articleCreateUseCase;
    }
    public function execute(CreateArticleRequest $req): int
    {
        return  $this->articleCreateUseCase->execute($req->title, $req->contents, $req->user_id);
    }
}
