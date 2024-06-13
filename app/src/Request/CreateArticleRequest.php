<?php
declare(strict_types=1);

namespace App\Request;

use App\Auth\Session;
use InvalidArgumentException;

class CreateArticleRequest
{
    const int MAX_FILE_SIZE = 5000000;
    public string $title;
    public string $contents;
    public string $thumbnailImagePath;
    public string $subImgPath;
    public int $userId;
    // 記事コンテンツはDBでTEXT型で保存されることを考慮して、3000文字以内であることを保証する
    /** @var array<int> */
    public array $tagIds;
    private int $maxContentsLength = 3000;
    private array $allowedExtensions = ['jpg', 'jpeg', 'png'];

    /**
     * tagsだけarray<int>型それ以外はstring
     * @param array<string, string|array<int>> $dollPost
     * @param array<string, string> $dollSession
     */
    public function __construct(array $dollPost, array $dollSession)
    {
        $userId = $dollSession[Session::USER_ID_KEY];
        $title = $dollPost['title'];
        $contents = $dollPost['contents'];
        $tags = $dollPost['tags'];

        if (empty($tags)) {
            throw new InvalidArgumentException('Tags is required');
        }
        if (!isset($userId)) {
            throw new InvalidArgumentException('User id is required');
        }
        if (!is_numeric($userId)) {
            throw new InvalidArgumentException('User id is required');
        }
        if (empty($title)) {
            throw new InvalidArgumentException('Title is empty');
        }

        $this->validateContents($contents);
        $thumbnailFile = $_FILES['thumbnail_image_url'];
        $subImg = $_FILES['sub_image'];

        $thumbnailImagePath = $this->validateImgUrl($thumbnailFile);
        $subFilePath = $this->validateImgUrl($subImg);

        $this->title = $title;
        $this->contents = $contents;
        $this->thumbnailImagePath = $thumbnailImagePath;
        $this->subImgPath = $subFilePath;
        $this->userId = (int)$userId;
        $this->tagIds = $tags;
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

    private function validateImgUrl(array $file): string
    {
        $target_dir = "tmp/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        if (!isset($file) || $_FILES['thumbnail_image_url']['error'] !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException('File is required and must be uploaded successfully');
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, $this->allowedExtensions)) {
            throw new InvalidArgumentException('File is not an image');
        }

        $check = getimagesize($file["tmp_name"]);
        if (!$check) {
            throw new InvalidArgumentException('File is not an image');
        }

        if ($file["size"] > self::MAX_FILE_SIZE) {
            throw new InvalidArgumentException('File is too large');
        }
        return $target_file;
    }
}
