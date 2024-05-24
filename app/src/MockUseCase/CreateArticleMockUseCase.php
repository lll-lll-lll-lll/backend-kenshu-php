<?php
declare(strict_types=1);

namespace App\MockUseCase;

use App\UseCase\ICreateArticleUseCase;

class CreateArticleMockUseCase  implements  ICreateArticleUseCase
{
    public function execute(string $title, string $contents, int $user_id): int
    {
        return 1;
    }
}
