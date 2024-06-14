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
     * @param Tag[] $tags
     * @param ArticleImage[] $articleImages
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
     * @return Article
     */
    public static function mapping(array $row): Article
    {
        $user = new User(
            id: (int)$row['user_id'],
            name: $row['user_name'],
            mail: $row['user_mail'],
            profileUrl: $row['user_profile_url'],
        );

        $thumbnailImagePaths = $row['thumbnail_image_paths'] ? explode(',', trim($row['thumbnail_image_paths'], '{}')) : [];
        $subImagePaths = $row['sub_image_paths'] ? explode(',', trim($row['sub_image_paths'], '{}')) : [];
        $tagIds = $row['tag_ids'] ? explode(',', trim($row['tag_ids'], '{}')) : [];
        $tagNames = $row['tag_names'] ? explode(',', trim($row['tag_names'], '{}')) : [];

        $articleImages = [];
        foreach ($thumbnailImagePaths as $index => $thumbnail) {
            $subImage = $subImagePaths[$index] ?? '';
            $articleImages[] = new ArticleImage($thumbnail, $subImage);
        }


        $tags = [];
        foreach ($tagIds as $index => $tagId) {
            $tags[] = new Tag((int)$tagId, $tagNames[$index]);
        }
        return new Article(
            (int)$row['article_id'],
            $row['title'],
            $row['contents'],
            $row['article_created_at'],
            $tags,
            $articleImages,
            $user
        );
    }
}
