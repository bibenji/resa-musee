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
        $this->assertContains('Faire une réservation', $crawler->filter('h2')->text());
    }
	
	public function testPostUnvalidReservation()
	{
		$this->markTestIncomplete(
			"Ce test n'est pas encore complet."
		);
	}
	
	public function testPostValidReservation()
	{
		$client = static::createClient();
				
		// $crawler = $client->request('POST', '/reservation', $data);
		$crawler = $client->request('GET', '/reservation');
				
		$form = $crawler->selectButton('Payer')->form();
		
		// Get the raw values.
		$values = $form->getPhpValues();

		// Add fields to the raw values.
		// $values['task']['tags'][0]['name'] = 'foo';
		$values['appbundle_resa']['date'] = '01/01/2018';
		$values['appbundle_resa']['typeResa'] = 'F';
		$values['appbundle_resa']['persons'][0]['lastname'] = 'Doe';
		$values['appbundle_resa']['persons'][0]['firstname'] = 'John';
		$values['appbundle_resa']['persons'][0]['age'] = '30';
		$values['appbundle_resa']['persons'][0]['reduction'] = '0';
		$values['appbundle_resa']['nom'] = 'DOE';
		$values['appbundle_resa']['email'] = 'john.doe@gmail.com';
		
		// Submit the form with the existing and new values.
		$crawler = $client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());
				
		$this->assertTrue(
			$client->getResponse()->isRedirect('/validation'),
			'Redirection vers la page validation'
		);
						
		/*
		$this->markTestIncomplete(
			"Ce test n'est pas encore complet."
		);
		*/
	}
	
	public function testValidation()
    {	
        $client = static::createClient();

        $crawler = $client->request('GET', '/validation');

        // $this->assertEquals(404, $client->getResponse()->getStatusCode());
		$this->assertTrue($client->getResponse()->isNotFound());
        
		/*		
		$this->markTestIncomplete(
			"Ce test n'est pas encore complet."
		);
		*/
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
