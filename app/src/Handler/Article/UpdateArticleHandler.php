<?php
declare(strict_types=1);

namespace App\Handler\Article;

use App\Auth\Session;
use App\Request\UpdateArticleRequest;
use App\Request\UserHasArticleAuthorityRequest;
use App\UseCase\Article\UpdateArticleUseCase;
use App\UseCase\Article\UserHasArticleAuthorityUseCase;
use Exception;

class UpdateArticleHandler
{
    private UpdateArticleUseCase $updateArticleUseCase;
    private UserHasArticleAuthorityUseCase $userHasArticleAuthorityUseCase;

    public function __construct(UpdateArticleUseCase $updateArticleUseCase, UserHasArticleAuthorityUseCase $userHasArticleAuthorityUseCase)
    {
        $this->updateArticleUseCase = $updateArticleUseCase;
        $this->userHasArticleAuthorityUseCase = $userHasArticleAuthorityUseCase;
    }

    public function execute(): void
    {
        try {
            Session::start();
            $updateArticleReq = new UpdateArticleRequest($_POST, $_SESSION);
            $userHasArticleAuthorityReq = new UserHasArticleAuthorityRequest($updateArticleReq->articleId, $_SESSION);
            $this->userHasArticleAuthorityUseCase->execute($userHasArticleAuthorityReq);
            $this->updateArticleUseCase->execute($updateArticleReq);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }
}
