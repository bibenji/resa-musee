<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
// use Symfony\Component\HttpFoundation\Session\Session;

class MainControllerTest extends WebTestCase
{
    public function testIndex()
	{	
        // $session = new Session(new MockArraySessionStorage());
		// $session = new Session(new MockFileSessionStorage());
		
		/*
		$sessionMock = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session')
			->setMethods(array('clear'))
			->disableOriginalConstructor()
			->getMock();
		*/
		
		$client = static::createClient();
		
        $crawler = $client->request('GET', '/');
		
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('The Amazing BELUGA SUPERSTAR MUSEUM', $crawler->filter('.container h1')->text());
    }
	
	public function testReservation()
    {	
        $client = static::createClient();

        $crawler = $client->request('GET', '/reservation');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Make a reservation', $crawler->filter('h2')->text());
    }
	
	public function testValidation()
    {	
        $client = static::createClient();

        $crawler = $client->request('GET', '/validation');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        
		$this->markTestIncomplete(
			"Ce test n'est pas encore complet."
		);
    }
	
	public function testConfirmation()
    {	
        $client = static::createClient();

        $crawler = $client->request('GET', '/confirmation');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        
		$this->markTestIncomplete(
			"Ce test n'est pas encore complet."
		);
    }
	
	public function testTest()
    {	
        $client = static::createClient();

        $crawler = $client->request('GET', '/test');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // $this->assertContains('The Amazing BELUGA SUPERSTAR MUSEUM', $crawler->filter('.container h1')->text());
    }
}
