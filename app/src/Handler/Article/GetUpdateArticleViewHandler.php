<?php
declare(strict_types=1);

namespace App\Handler\Article;

use App\Request\UserHasArticleAuthorityRequest;
use App\UseCase\Article\UserHasArticleAuthorityUseCase;
use Exception;

class GetUpdateArticleViewHandler
{
    private UserHasArticleAuthorityUseCase $userHasArticleAuthorityUseCase;

    public function __construct(UserHasArticleAuthorityUseCase $userHasArticleAuthorityUseCase)
    {
        $this->userHasArticleAuthorityUseCase = $userHasArticleAuthorityUseCase;
    }

    public function execute(int $article_id): void
    {
        try {
            $req = new UserHasArticleAuthorityRequest($article_id, $_SESSION);
            $this->userHasArticleAuthorityUseCase->execute($req);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
