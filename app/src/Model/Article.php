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
    public function __construct(int $id, string $title, string $contents, string $created_at, array $tags, array $articleImages, User $user)
    {
        $this->id = $id;
        $this->title = $title;
        $this->contents = $contents;
        $this->created_at = $created_at;
        $this->user = $user;
        $this->tags = $tags;
        $this->articleImages = $articleImages;
    }

    /**
     * DBの出力結果をArticleクラスにマッピングする
     * @param mixed $row
     * @return Article[]
     */
    public static function mapping(mixed $row): array
    {
        $articleId = $row['article_id'];

        $user = new User(
            id: (int)$row['user_id'],
            name: $row['user_name'],
            mail: $row['user_mail'],
            profileUrl: $row['user_profile_url'],
        );
        $tag = new Tag(
            id: (int)$row['tag_id'],
            name: $row['tag_name']
        );

        $articleImage = new ArticleImage(
            $row['thumbnail_image_path'],
            $row['sub_image_path']
        );

        if (!isset($articles[$articleId])) {
            $articles[$articleId] = new Article(
                (int)$articleId,
                $row['title'],
                $row['contents'],
                $row['article_created_at'],
                [],
                [],
                $user
            );
        }

        $articles[$articleId]->tags[] = $tag;
        $articles[$articleId]->articleImages[] = $articleImage;
        $articles[$articleId]->user = $user;
        return $articles;
    }
}
