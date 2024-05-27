<?php
declare(strict_types=1);

namespace App\Request;

use InvalidArgumentException;

class CreateArticleRequest
{
    // 記事コンテンツはDBでTEXT型で保存されることを考慮して、3000文字以内であることを保証する
    private int $maxContentsLength = 3000;
    public string $title;
    public string $contents;
    public int $user_id;

    public function __construct(string $title, string $contents, string $user_id)
    {
        $this->validateUserId($user_id);
        $this->validateContents($contents);
        if (empty($title)) {
            throw new InvalidArgumentException('Title is empty, Contents is empty, or User id is not an integer');
        }
        $this->title = $title;
        $this->contents = $contents;
        $this->user_id = (int)$user_id;
    }

    private function validateUserId(string $user_id): void
    {
        if (filter_var($user_id, FILTER_VALIDATE_INT) === false) {
            throw new InvalidArgumentException("Invalid user_id: must be an integer.");
        }
        if ($user_id < 0) {
            throw new InvalidArgumentException('User id is required');
        }
    }

    private function validateContents(string $contents): void
    {
        if (empty($contents)) {
            throw new InvalidArgumentException('Contents is empty');
        }
        if (mb_strlen($contents, 'UTF-8') >= $this->maxContentsLength) {
            throw new InvalidArgumentException('Contents is too long');
        }
    }
}
