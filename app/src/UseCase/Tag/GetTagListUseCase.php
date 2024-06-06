<?php
declare(strict_types=1);

namespace App\UseCase\Tag;

use App\Model\Tag;
use App\Repository\Tag\GetTagListRepository;
use Exception;
use PDO;

class GetTagListUseCase
{
    public GetTagListRepository $getTagListRepository;
    public PDO $pdo;

    public function __construct(PDO $pdo, GetTagListRepository $getTagListRepository)
    {
        $this->pdo = $pdo;
        $this->getTagListRepository = $getTagListRepository;
    }

    /**
     * @return array<Tag>
     * @throws Exception
     */
    public function execute(): array
    {
        try {
            return $this->getTagListRepository->execute($this->pdo);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
