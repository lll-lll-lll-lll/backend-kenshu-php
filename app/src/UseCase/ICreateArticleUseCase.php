<?php
declare(strict_types=1);

namespace App\UseCase;

interface ICreateArticleUseCase
{
    public function execute(string $title, string $contents, int $user_id): int;
}
