<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    public function testCreateUser(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@example.com',
                'name' => 'Test User'
            ])
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals('test@example.com', $responseData['email']);
        $this->assertEquals('Test User', $responseData['name']);
    }

    public function testGetUser(): void
    {
        $client = static::createClient();
        
        // First create a user
        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'get@example.com',
                'name' => 'Get User'
            ])
        );
        
        $createResponse = json_decode($client->getResponse()->getContent(), true);
        $userId = $createResponse['id'];

        // Then get the user
        $client->request('GET', "/api/users/{$userId}");

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($userId, $responseData['id']);
        $this->assertEquals('get@example.com', $responseData['email']);
        $this->assertEquals('Get User', $responseData['name']);
    }

    public function testGetNonExistentUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/users/999');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testCreateUserWithDuplicateEmail(): void
    {
        $client = static::createClient();
        $userData = [
            'email' => 'duplicate@example.com',
            'name' => 'Duplicate User'
        ];

        // Create first user
        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($userData)
        );

        // Try to create second user with same email
        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($userData)
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
} 