<?php
declare(strict_types=1);

namespace App\Request;

use App\Auth\Session;
use Exception;

class DeleteArticleRequest
{
    public int $articleId;
    public int $userId;

    /**
     * @throws Exception
     */
    public function __construct(array $dollPost, array $dollSession)
    {
        $articleId = $dollPost['article_id'];
        if (!is_numeric($articleId) || $articleId <= 0) {
            throw new Exception('記事が存在しません');
        }

        $this->userId = (int)$dollSession[Session::USER_ID_KEY];
        $this->articleId = (int)$articleId;
    }
}
