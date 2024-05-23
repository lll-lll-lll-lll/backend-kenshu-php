<?php
declare(strict_types=1);

namespace App\Handler;

use App\Model\Article;
use App\Request\CreateArticleRequest;
use App\Usecase\CreateArticleUseCase;

class ArticleCreateHandler
{
    public CreateArticleUseCase $articleCreateUseCase;
    public  function __construct(CreateArticleUseCase $articleCreateUseCase)
    {
     $this->articleCreateUseCase = $articleCreateUseCase;
    }
    public function execute(CreateArticleRequest $req): int
    {
        return  $this->articleCreateUseCase->execute($req->title, $req->contents, $req->user_id);
    }
}
