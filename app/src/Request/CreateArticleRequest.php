<?php
declare(strict_types=1);

namespace App\Request;

use InvalidArgumentException;

class CreateArticleRequest
{
    public string $title;
    public string $contents;
    public string $thumbnail_image_url;
    public int $userId;
    public array $tags;
    // 記事コンテンツはDBでTEXT型で保存されることを考慮して、3000文字以内であることを保証する
    private int $maxContentsLength = 3000;
    private array $allowedExtensions = ['jpg', 'jpeg', 'png'];

    /**
     * @param array<string> $tags
     */
    public function __construct(string $title, string $contents, string $thumbnail_image_url, int $userId, array $tags)
    {
        if (empty($tags)) {
            throw new InvalidArgumentException('Tags is required');
        }
        if ($userId <= 0) {
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
        $this->userId = $userId;
        $this->tags = $tags;
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
