<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CityControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/city/');       
        $this->assertResponseIsSuccessful();

        $link = $crawler
            ->filter('#create-city-link')
            ->eq(0)
            ->link()
        ;
        $crawler = $client->click($link);
        $this->assertResponseIsSuccessful();
    }
    
    public function testShow()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/city/1');
        $this->assertResponseIsSuccessful();
        
        $crawler = $client->request('GET', '/city/1000000');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
