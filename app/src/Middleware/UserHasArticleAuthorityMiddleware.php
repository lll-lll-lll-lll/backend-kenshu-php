<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Repository\Article\GetArticleRepository;
use App\Request\UserHasArticleAuthorityRequest;
use Exception;
use PDO;

/**
 * Check if the user has the authority to update the article
 */
class UserHasArticleAuthorityMiddleware
{
    /**
     * @param array $dollSession
     * @param array $dollCookie
     * @return bool if user has article return true
     */
    public static function execute(PDO $pdo, GetArticleRepository $getArticleRepository,
        string $articleId, array $dollSession, array $dollCookie): bool
    {
        try {
            $req = new UserHasArticleAuthorityRequest($articleId, $dollSession);
            // Check if the user is logged in
            if (!IsLoginMiddleware::execute($dollSession, $dollCookie)) {
                return false;
            }
            $article = $getArticleRepository->execute($pdo, $req->articleId);
            if (!self::hasAuthority($article->user_id, $req->sessionUserId)) {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return true;
    }

    /**
     * Check if the user has the authority to update the article
     * @return bool true if user has article authority
     */
    private static function hasAuthority(int $articleUserId, int $sessionUserId): bool
    {
        return $articleUserId === $sessionUserId;
    }
}
