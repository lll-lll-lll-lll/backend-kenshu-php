<?php

namespace Request;

use App\Request\CreateUserRequest;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateUserRequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $dollPost = [
            'user_name' => 'testName',
            'mail' => 'test@gmail.com',
            'password' => 'password',
            'profile_url' => 'https://example.com/image.jpg',];
        $request = new CreateUserRequest($dollPost);
        $this->assertSame($dollPost['user_name'], $request->userName);
        $this->assertSame($dollPost['mail'], $request->mail);
        $this->assertSame($dollPost['password'], $request->password);
        $this->assertSame($dollPost['profile_url'], $request->profileUrl);
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid mail');
        $dollPost = [
            'user_name' => 'testName',
            'mail' => 'test',
            'password' => 'password',
            'profile_url' => 'https://example.com/image.jpg',];
        new CreateUserRequest($dollPost);
    }

    public function testInvalidProfileURL(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid URL');
        $dollPost = [
            'user_name' => 'testName',
            'mail' => 'test@test.com',
            'password' => 'password',
            'profile_url' => 'invalid_url',];
        new CreateUserRequest($dollPost);
    }
}
