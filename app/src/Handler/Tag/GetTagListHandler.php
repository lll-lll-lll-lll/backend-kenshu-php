<?php
declare(strict_types=1);

namespace App\Handler\Tag;

use App\Model\Tag;
use App\UseCase\Tag\GetTagListUseCase;
use Exception;
use PDO;

class GetTagListHandler
{
    public GetTagListUseCase $getTagListUseCase;
    public PDO $pdo;

    public function __construct(PDO $pdo, GetTagListUseCase $getTagListUseCase)
    {
        $this->pdo = $pdo;
        $this->getTagListUseCase = $getTagListUseCase;
    }

    /**
     * @return array<Tag>
     * @throws Exception
     */
    public function execute(): array
    {
        try {
            return $this->getTagListUseCase->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
