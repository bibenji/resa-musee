<?php

namespace Tests\AppBundle\Services;

use AppBundle\Services\Calculator;

use AppBundle\Entity\Person;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculPersonPrice()
    {
        $calc = new Calculator();
		
		$person1 = new Person();
		$person1->setAge(18);
		$person1->setReduction(0);		
		$result1 = $calc->calculPersonPrice($person1);

		$person2 = new Person();
		$person2->setAge(2);
		$person2->setReduction(0);		
		$result2 = $calc->calculPersonPrice($person2);
		
        // assert that your calculator added the numbers correctly!
        $this->assertEquals(16, $result1);
        $this->assertEquals(0, $result2);
    }
}