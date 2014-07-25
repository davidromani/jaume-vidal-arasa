<?php

namespace Acme\DemoBundle\Tests\Functional;

use Acme\DemoBundle\Tests\WebTestCase;

class StaticPageTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $title = 'JAUME VIDAL ARASA';
        $this->assertCount(1, $crawler->filter(sprintf('h1:contains("%s")', $title)), 'Page does not contain an h1 tag with: ' . $title);
    }

    public function testContactePage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/contacte');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('ul.nav'), 'Page does not contain 1 ul.nav tag');
        $this->assertCount(5, $crawler->filter('ul.nav>li'), 'Page does not contain 5 ul.nav>li tags');
    }

    public function testBiografiaPage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/biografia');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testTreballRecentPage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/treball-recent');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(2, $crawler->filter('ul.nav'), 'Page does not contain 2 ul.nav tag');
        $this->assertCount(9, $crawler->filter('ul.nav>li'), 'Page does not contain 9 ul.nav>li tags');
    }

    public function testTreballRecentMondrianPage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/treball-recent/mondrian');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testArxiuPage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/arxiu');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPublicacionsPage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/publicacions');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
