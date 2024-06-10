<?php
declare(strict_types=1);

namespace App\Request;

use App\Auth\Session;
use Exception;

class UserHasArticleAuthorityRequest
{
    public int $articleId;
    public int $sessionUserId;

    public function __construct(int $articleId, array $dollSession)
    {
        $sessionUserId = (int)$dollSession[Session::USER_ID_KEY];

        if ($articleId < 1 || $sessionUserId < 1) {
            throw new Exception('記事IDまたはユーザーIDが正しくありません');
        }
        $this->articleId = $articleId;
        $this->sessionUserId = $sessionUserId;
    }
}
