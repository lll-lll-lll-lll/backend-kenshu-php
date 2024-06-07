<?php
declare(strict_types=1);

namespace App\Handler\Article;

use App\Request\UpdateArticleRequest;
use App\UseCase\Article\UpdateArticleUseCase;
use Exception;

class UpdateArticleHandler
{
    private UpdateArticleUseCase $updateArticleUseCase;

    public function __construct(UpdateArticleUseCase $updateArticleUseCase)
    {
        $this->updateArticleUseCase = $updateArticleUseCase;
    }

    public function execute(): void
    {
        try {
            $req = new UpdateArticleRequest($_POST, $_SESSION);
            $this->updateArticleUseCase->execute($req);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }
}
