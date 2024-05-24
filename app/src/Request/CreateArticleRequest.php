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
    public function __construct(string $title, string $contents, int $user_id)
    {
        if (empty($title)) {
            throw new InvalidArgumentException('Title is empty, required');
        }
        if (mb_strlen($contents) >=$this->maxContentsLength){
            throw new InvalidArgumentException('Contents is too long');
        }
        if ($user_id < 0){
            throw new InvalidArgumentException('User id is required');
        }
        $this->title = $title;
        $this->contents = $contents;
        $this->user_id = $user_id;
    }
}
