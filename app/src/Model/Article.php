<?php
declare(strict_types=1);

namespace App\Model;


class Article
{
    public int $id;
    public string $title;
    public string $contents;

    public string $created_at;
    public int $user_id;

    public function __construct(int $id, string $title, string $contents, string $created_at, int $user_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->contents = $contents;
        $this->created_at = $created_at;
        $this->user_id = $user_id;
    }
}
