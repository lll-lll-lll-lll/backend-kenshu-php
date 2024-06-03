<?php
declare(strict_types=1);

namespace App\Request;

use InvalidArgumentException;

class CreateArticleRequest
{
    public string $title;
    public string $contents;
    public string $thumbnail_image_url;
    public int $user_id;
    public int $tag_id;
    // 記事コンテンツはDBでTEXT型で保存されることを考慮して、3000文字以内であることを保証する
    private int $maxContentsLength = 3000;
    private array $allowedExtensions = ['jpg', 'jpeg', 'png'];

    public function __construct(array $dollPost, array $dollSession)
    {
        $user_id = $dollSession['user_id'];
        $title = $dollPost['title'];
        $contents = $dollPost['contents'];
        $thumbnail_image_url = $dollPost['thumbnail_image_url'];
        $tags = $dollPost['tags'];

        if (empty($tags)) {
            throw new InvalidArgumentException('Tags is required');
        }
        if (!is_numeric($tags[0])) {
            throw new InvalidArgumentException('Tag id is required');
        }
        $tag_id = (int)$tags[0];
        if (!is_numeric($user_id)) {
            throw new InvalidArgumentException('User id is required');
        }
        if (empty($title)) {
            throw new InvalidArgumentException('Title is empty');
        }

        $this->validateContents($contents);
        $thumbnail_image_url = $this->validateImgUrl($thumbnail_image_url);
        $this->title = $title;
        $this->contents = $contents;
        $this->thumbnail_image_url = $thumbnail_image_url;
        $this->user_id = $user_id;
        $this->tag_id = $tag_id;
    }

    private function validateContents(string $contents): void
    {
        if (empty($contents)) {
            throw new InvalidArgumentException('Contents is empty');
        }
        if (mb_strlen($contents, 'UTF-8') >= $this->maxContentsLength) {
            throw new InvalidArgumentException('Contents is too long');
        }
    }

    private function validateImgUrl(string $filePath): string
    {
        if (!filter_var($filePath, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL');
        }
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), $this->allowedExtensions)) {
            throw new InvalidArgumentException('Invalid file extension: ' . $fileExtension);
        }
        return $filePath;
    }
}
