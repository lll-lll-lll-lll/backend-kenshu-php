<?php
declare(strict_types=1);

namespace App\Model;

use InvalidArgumentException;


class Article
{
    public int $id;
    public string $title;
    public function __construct(int $id, string $title)
    {
        if ($id < 1) {
            throw new InvalidArgumentException("Invalid ID {$id} is provided");
        }
        if (empty($title)) {
            throw new InvalidArgumentException('Title is empty, required');
        }
        $this->id = $id;
        $this->title = $title;
    }
}
