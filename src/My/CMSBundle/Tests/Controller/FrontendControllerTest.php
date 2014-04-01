<?php

namespace My\CMSBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontendControllerTest extends WebTestCase
{
    public function testMain()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/pl');

        $this->assertTrue($crawler->filter('html:contains("Lorem Ipsum")')->count() > 0);
    }
}
