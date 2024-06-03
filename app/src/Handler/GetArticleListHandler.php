<?php
declare(strict_types=1);

namespace App\Handler;

use App\Model\Article;
use App\UseCase\GetArticleListUseCase;

class GetArticleListHandler
{
    public GetArticleListUseCase $getArticleListUseCase;

    public function __construct(GetArticleListUseCase $getArticleListUseCase)
    {
        $this->getArticleListUseCase = $getArticleListUseCase;
    }

    /**
     * @return array<Article>
     */
    public function execute(): array
    {
        return $this->getArticleListUseCase->execute();
    }
}
