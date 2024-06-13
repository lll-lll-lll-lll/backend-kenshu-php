<?php
declare(strict_types=1);

namespace App\Model;


class Article
{
    public int $id;
    public string $title;
    public string $contents;
    public string $created_at;
    public User $user;
    /**
     * @var Tag[]
     */
    public array $tags;
    /**
     * @var ArticleImage
     */
    public array $articleImages;

    /**
     * Article constructor.
     * @param int $id
     * @param string $title
     * @param string $contents
     * @param string $created_at
     * @param User $user
     * @param Tag[] $tag
     * @param ArticleImage[] $articleImage
     */
    public function __construct(int $id, string $title, string $contents, string $created_at, User $user, array $tags, array $articleImages)
    {
        $this->id = $id;
        $this->title = $title;
        $this->contents = $contents;
        $this->created_at = $created_at;
        $this->user = $user;
        $this->tags = $tags;
        $this->articleImages = $articleImages;
    }
}
