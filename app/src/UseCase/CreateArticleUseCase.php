<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Repository\CreateArticleImageRepository;
use App\Repository\CreateArticleRepository;
use App\Repository\CreateArticleTagRepository;
use App\Repository\GetTagRepository;
use App\Request\CreateArticleRequest;
use Exception;
use PDO;

class CreateArticleUseCase
{
    private PDO $pdo;
    private CreateArticleRepository $createArticleRepository;
    private CreateArticleTagRepository $createArticleTagRepository;
    private CreateArticleImageRepository $createArticleImageRepository;
    private GetTagRepository $getTagRepository;

    public function __construct(
        PDO                          $pdo,
        CreateArticleRepository      $createRepository,
        CreateArticleTagRepository   $createArticleTagRepository,
        CreateArticleImageRepository $createArticleImageRepository,
        GetTagRepository             $getTagRepository)
    {
        $this->pdo = $pdo;
        $this->createArticleRepository = $createRepository;
        $this->createArticleTagRepository = $createArticleTagRepository;
        $this->createArticleImageRepository = $createArticleImageRepository;
        $this->getTagRepository = $getTagRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(CreateArticleRequest $req): void
    {
        try {
            $this->pdo->beginTransaction();
            try {
                $articleId = $this->createArticleRepository->execute($this->pdo, $req->title, $req->contents, $req->user_id);
                $this->createArticleImageRepository->execute($this->pdo, $req->thumbnail_image_url, $articleId);
                $tag_id = $this->getTagRepository->execute($this->pdo, $req->tag_id);
                $this->createArticleTagRepository->execute($this->pdo, $articleId, $tag_id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
