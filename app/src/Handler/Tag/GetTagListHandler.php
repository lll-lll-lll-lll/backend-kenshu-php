<?php
declare(strict_types=1);

namespace App\Handler\Tag;

use App\Model\Tag;
use App\UseCase\Tag\GetTagListUseCase;
use Exception;

class GetTagListHandler
{
    public GetTagListUseCase $getTagListUseCase;

    public function __construct(GetTagListUseCase $getTagListUseCase)
    {
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
