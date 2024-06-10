<?php
declare(strict_types=1);

namespace App\Request;

use App\Auth\Session;
use Exception;
use InvalidArgumentException;

class UpdateArticleRequest
{
    public int $articleId;
    public string $title;
    public string $content;
    public int $sessionUserId;
    /** @var array<int> */
    public array $tags;

    public function __construct(array $dollPost, array $dollSession)
    {
        if (!isset($dollPost['article_id']) || !isset($dollPost['title']) || !isset($dollPost['content']) || empty($dollPost['tags']) | !is_array($dollPost['tags'])) {
            throw new Exception('invalid request');
        }
        $articleId = (int)$dollPost['article_id'];
        if ($articleId < 1) {
            throw new Exception('article_id is not int or less than 1.');
        }
        $tags = $dollPost['tags'];
        $castedTags = [];
        foreach ($tags as $tag) {
            if (!is_numeric($tag) || (int)$tag < 1) {
                throw new InvalidArgumentException('Each tag must be a positive integer');
            }
            $castedTags[] = (int)$tag;
        }
        $this->articleId = $articleId;
        $this->title = $dollPost['title'];
        $this->content = $dollPost['content'];
        $this->sessionUserId = (int)$dollSession[Session::USER_ID_KEY];
        $this->tags = $castedTags;
    }
}
