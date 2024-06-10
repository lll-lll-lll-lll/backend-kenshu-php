<?php
declare(strict_types=1);

namespace App\UseCase\Article;

use App\Model\Article;
use App\Repository\Article\GetArticleByUseIdRepository;
use App\Request\UserHasArticleAuthorityRequest;
use Exception;
use PDO;

/**
 * Check if the user has the authority to update the article
 */
class UserHasArticleAuthorityUseCase
{
    private PDO $pdo;
    private GetArticleByUseIdRepository $getArticleByUseId;

    public function __construct(PDO $pdo, GetArticleByUseIdRepository $getArticleByUseId)
    {
        $this->pdo = $pdo;
        $this->getArticleByUseId = $getArticleByUseId;
    }

    public function execute(UserHasArticleAuthorityRequest $req): Article
    {
        try {
            return $this->getArticleByUseId->execute($this->pdo, $req->articleId, $req->sessionUserId);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
