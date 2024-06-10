<?php
declare(strict_types=1);

namespace App\View;

use App\Handler\Tag\GetTagListHandler;
use Exception;

class TagListView
{
    private GetTagListHandler $tagListHandler;

    public function __construct(GetTagListHandler $tagListHandler)
    {
        $this->tagListHandler = $tagListHandler;
    }

    public function execute(): string
    {
        try {
            $tags = $this->tagListHandler->execute();
            return $this->renderTags($tags);
        } catch (Exception) {
            header('Location: /', response_code: 500);
            return '';
        }
    }

    private function renderTags(array $tags): string
    {
        $tagsHTML = '';
        foreach ($tags as $tag) {
            $tagName = htmlspecialchars($tag->name, ENT_QUOTES, 'UTF-8');
            $tagsHTML .= "<option value='{$tag->id}'>{$tagName}</option>";
        }
        return $tagsHTML;
    }

}
