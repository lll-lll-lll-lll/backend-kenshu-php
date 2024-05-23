<?php
declare(strict_types=1);

namespace App\Repository\Article;

interface ICreateRepository
{
    public function execute(string $title, string $contents, int $user_id): int;
}
