<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Model\Article;
use App\Repository\Article\ICreateRepository;

class CreateArticleUseCase
{
    private ICreateRepository $createRepository;
    public function __construct(ICreateRepository $createRepository)
    {
        $this->createRepository = $createRepository;
    }

    public function execute(string $title, string $contents, int $user_id): int
    {
        return $this->createRepository->execute($title,$contents,$user_id);
    }
}
