<?php
declare(strict_types=1);

namespace App\Request;

use App\Auth\Session;
use Exception;

class UserHasArticleAuthorityRequest
{
    public int $articleId;
    public int $sessionUserId;

    public function __construct(string $articleId, array $dollSession)
    {
        $sessionUserId = (int)$dollSession[Session::USER_ID_KEY];
        $articleIdInt = (int)$articleId;

        if ($articleId < 1 || $sessionUserId < 1) {
            throw new Exception('記事IDまたはユーザーIDが正しくありません');
        }
        $this->articleId = $articleIdInt;
        $this->sessionUserId = $sessionUserId;
    }
}
