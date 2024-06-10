<?php
declare(strict_types=1);

namespace App\Request;

use App\Auth\Session;
use Exception;

class UpdateArticleRequest
{
    public int $articleId;
    public string $title;
    public string $content;
    public int $sessionUserId;

    public function __construct(array $dollPost, array $dollSession)
    {
        if (!isset($dollPost['article_id']) || !isset($dollPost['title']) || !isset($dollPost['content'])) {
            throw new Exception('invalid request');
        }
        $articleId = (int)$dollPost['article_id'];
        if ($articleId < 1) {
            throw new Exception('article_id is not int or less than 1.');
        }
        $this->articleId = $articleId;
        $this->title = $dollPost['title'];
        $this->content = $dollPost['content'];
        $this->sessionUserId = (int)$dollSession[Session::USER_ID_KEY];
    }
}
