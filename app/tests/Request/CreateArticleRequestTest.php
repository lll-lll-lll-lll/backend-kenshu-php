<?php

namespace Request;

use App\Request\CreateArticleRequest;
use PHPUnit\Framework\TestCase;

class CreateArticleRequestTest extends TestCase
{
    public function testCreateArticleRequest(): void
    {
        $user_id = 1;
        $dollPost = [
            'title' => 'title',
            'contents' => 'contents',
            'thumbnail_image_url' => 'https://example.com/image.jpg',
            'tags' => ['1', '2'],
        ];
        $dollSession = ['user_id' => $user_id];
        $dollFiles = [
            'thumbnail_image_url' => [
                'name' => '63499912.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/63499912.jpeg',
                'error' => 0,
                'size' => 1000,
            ],
            'sub_image' => [
                'name' => '63499912.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/63499912.jpeg',
                'error' => 0,
                'size' => 1000,
            ],
        ];

        $request = new CreateArticleRequest($dollPost, $dollSession, $dollFiles);

        $this->assertSame($dollPost['title'], $request->title);
        $this->assertSame($dollPost['contents'], $request->contents);
        $this->assertSame($user_id, $request->userId);
    }
}
