<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiRestTest extends WebTestCase
{
    public function testGetCollection(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/bookmarks');


        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);



       // $this->assertResponseIsSuccessful();
    }


    public function testAddbookmark(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/bookmarks',['url'=>'https://vimeo.com/194738207']);


        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);

    }


     public function testAddNotURLbookmark(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/bookmarks',['url'=>'httpsvimeo.com/194738207']);


        $response = $client->getResponse();
        $this->assertSame(500, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);

        $this->assertSame($responseData['message'], 'url not valide');

    }


     public function testAddwithNOMEDIAURL(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/bookmarks',['url'=>'https://google.com/']);


        $response = $client->getResponse();
        $this->assertSame(500, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);

        $this->assertSame($responseData['message'], 'url not valide');

    }
}
