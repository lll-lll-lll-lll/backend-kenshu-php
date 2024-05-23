<?php
declare(strict_types=1);

namespace App\MockRepository;

use App\Repository\Article\ICreateRepository;

class CreateArticleMockRepository  implements  ICreateRepository
{
    public function execute(string $title, string $contents, int $user_id): int
    {
        return 1;
    }
}
