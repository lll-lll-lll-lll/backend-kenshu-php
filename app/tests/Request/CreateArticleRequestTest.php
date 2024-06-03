<?php

namespace Request;

use App\Request\CreateArticleRequest;
use InvalidArgumentException;
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

        $request = new CreateArticleRequest($dollPost, $dollSession);

        $this->assertSame($dollPost['title'], $request->title);
        $this->assertSame($dollPost['contents'], $request->contents);
        $this->assertSame($dollPost['thumbnail_image_url'], $request->thumbnailImageUrl);
        $this->assertSame($user_id, $request->userId);
    }

    public function testCreateInvalidUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid URL');
        $user_id = 1;
        $dollPost = [
            'title' => 'title',
            'contents' => 'contents',
            'thumbnail_image_url' => 'invalid_url',
            'tags' => ['1', '2'],
        ];
        $dollSession = ['user_id' => $user_id];
        new CreateArticleRequest($dollPost, $dollSession);
    }

    public function testNotValidExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid file extension: pdf');

        $user_id = 1;
        $dollPost = [
            'title' => 'title',
            'contents' => 'contents',
            'thumbnail_image_url' => 'https://example.com/image.pdf',
            'tags' => ['1', '2'],
        ];
        $dollSession = ['user_id' => $user_id];

        new CreateArticleRequest($dollPost, $dollSession);
    }
}
