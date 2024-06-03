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
            'email' => 'test@gmail.com',
            'password' => 'password',
            'profile_url' => 'https://example.com/image.jpg',];
        $request = new CreateUserRequest($dollPost);
        $this->assertSame($dollPost['user_name'], $request->userName);
        $this->assertSame($dollPost['email'], $request->mail);
        $this->assertSame($dollPost['password'], $request->password);
        $this->assertSame($dollPost['profile_url'], $request->profileUrl);
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email');
        $dollPost = [
            'user_name' => 'testName',
            'email' => 'test',
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
