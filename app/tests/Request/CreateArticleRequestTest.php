<?php

namespace Request;

use App\Request\CreateArticleRequest;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateArticleRequestTest extends TestCase
{
    public function testCreateArticleRequest(): void
    {
        $title = 'title';
        $contents = 'contents';
        $thumbnail_image_url = 'https://example.com/image.jpg';
        $user_id = 1;
        $tags = ['1', '2'];

        $request = new CreateArticleRequest($title, $contents, $thumbnail_image_url, $user_id, $tags);

        $this->assertSame($title, $request->title);
        $this->assertSame($contents, $request->contents);
        $this->assertSame($thumbnail_image_url, $request->thumbnail_image_url);
        $this->assertSame($user_id, $request->user_id);
    }

    public function testCreateInvalidUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid URL');

        $title = 'title';
        $contents = 'contents';
        $thumbnail_image_url = 'invalid_url';
        $user_id = 1;
        $tags = ['1', '2'];

        new CreateArticleRequest($title, $contents, $thumbnail_image_url, $user_id, $tags);
    }

    public function testNotValidExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid file extension: pdf');

        $title = 'title';
        $contents = 'contents';
        $thumbnail_image_url = 'https://example.com/image.pdf';
        $user_id = 1;
        $tags = ['1', '2'];

        new CreateArticleRequest($title, $contents, $thumbnail_image_url, $user_id, $tags);
    }
}
