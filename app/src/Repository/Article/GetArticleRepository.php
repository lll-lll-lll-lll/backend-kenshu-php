<?php
declare(strict_types=1);

namespace App\Repository\Article;

use App\Model\Article;
use App\Model\ArticleImage;
use App\Model\Tag;
use App\Model\User;
use Exception;
use PDO;

class GetArticleRepository
{
    /**
     * @throws Exception
     */
    public function execute(PDO $pdo, int $id): Article
    {
        try {
            $stmt = $pdo->prepare('
                SELECT 
                    a.id AS article_id,
                    a.title,
                    a.contents,
                    a.created_at AS article_created_at,
                    u.id AS user_id,
                    u.name AS user_name,
                    u.mail AS user_mail,
                    u.profile_url AS user_profile_url,
                    ai.thumbnail_image_path,
                    ai.sub_image_path,
                    t.id AS tag_id,
                    t.name AS tag_name
                FROM 
                    article a
                JOIN 
                    "user" u ON a.user_id = u.id
                LEFT JOIN 
                    article_image ai ON a.id = ai.article_id
                LEFT JOIN 
                    article_tag at ON a.id = at.article_id
                LEFT JOIN 
                    tag t ON at.tag_id = t.id
                    WHERE a.id = :id;');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new Exception("Article with ID $id not found.");
            }

            $user = new User(
                id: (int)$result['user_id'],
                name: $result['user_name'],
                mail: $result['user_mail'],
                profileUrl: $result['user_profile_url'],
            );
            $tag = new Tag(
                id: (int)$result['tag_id'],
                name: $result['tag_name']
            );

            $articleImage = new ArticleImage(
                $result['thumbnail_image_path'],
                $result['sub_image_path']
            );
            return new Article(id: $result['article_id'], title: $result['title'], contents: $result['contents'], created_at: $result['article_created_at'], user: $user, tags: (array)$tag, articleImages: (array)$articleImage);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
