<?php

namespace Tests\AppBundle\Services;

use AppBundle\Services\Calculator;

use AppBundle\Entity\Person;
use AppBundle\Entity\Resa;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
	private $person1, $person2, $resa1, $resa2;
	
	public function setUp()
	{
		$person1 = new Person();
		$person1->setAge(18);
		$person1->setReduction(0);
		
		$this->person1 = $person1;
		
		$person2 = new Person();
		$person2->setAge(2);
		$person2->setReduction(0);		
		
		$this->person2 = $person2;
		
		$resa1 = new Resa();
		$resa1->setTypeResa('F');
		$resa1->addPerson($person1);
		$resa1->addPerson($person2);
		
		$this->resa1 = $resa1;
		
		$resa2 = new Resa();
		$resa2->setTypeResa('H');
		$resa2->addPerson($person1);
		$resa2->addPerson($person2);
		
		$this->resa2 = $resa2;		
	}
	
    public function testCalculPersonPrice()
    {
        $calc = new Calculator();		
				
		$result1 = $calc->calculPersonPrice($this->person1);		
		$result2 = $calc->calculPersonPrice($this->person2);		
        
        $this->assertEquals(16, $result1);
        $this->assertEquals(0, $result2);
    }
	
	public function testCalculTotalPrice()
	{
		$calc = new Calculator();
		
		$result1 = $calc->calculTotalPrice($this->resa1);
		$result2 = $calc->calculTotalPrice($this->resa2);
		
		$this->assertEquals(16, $result1);
        $this->assertEquals(8, $result2);
	}
}