<?php
declare(strict_types=1);

namespace App\Model;

class ArticleImage
{
    public string $thumbnail_image_path;
    public string $sub_image_path;

    public function __construct(string $thumbnail_image_path, string $sub_image_path)
    {
        $this->thumbnail_image_path = $thumbnail_image_path;
        $this->sub_image_path = $sub_image_path;
    }
}
