<?php

namespace Tests\AppBundle\Services;

use AppBundle\Services\Calculator;
use AppBundle\Services\PriceTwigFilterExtension;

use AppBundle\Entity\Person;
use AppBundle\Entity\Resa;

class PriceTwigFilterExtensionTest extends \PHPUnit_Framework_TestCase
{
	private $filter;	
	private $person1, $person2;	
	
	public function setUp()
	{
		$calc = new Calculator();
		$this->filter = new PriceTwigFilterExtension($calc);
		
		$person1 = new Person();
		$person1->setAge(18);
		$person1->setReduction(0);
		
		$this->person1 = $person1;
		
		$person2 = new Person();
		$person2->setAge(2);
		$person2->setReduction(0);		
		
		$this->person2 = $person2;			
	}
	
    public function testPriceFilter()
    {			
		$result1 = $this->filter->priceFilter($this->person1);		
		$result2 = $this->filter->priceFilter($this->person2);				
        
        $this->assertEquals(16, $result1);
        $this->assertEquals(0, $result2);
    }
}