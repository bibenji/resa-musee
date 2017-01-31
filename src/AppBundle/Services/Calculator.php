<?php
namespace AppBundle\Services;

class Calculator
{		
	public function calculPersonPrice($person)
	{			
		if ($person->getAge() < 4) $price = 0;
		elseif ($person->getAge() >= 4 && $person->getAge() < 12) $price = 8;		
		elseif ($person->getReduction() == 1) $price = 10;		
		elseif ($person->getAge() >= 12 && $person->getAge() < 60) $price = 16;
		else $price = 12;
				
		return $price;
	}
	
	public function calculTotalPrice($resa)
	{
		$total = 0;
		$persons = $resa->getPersons();
		foreach ($persons as $person) {
			$total += $this->calculPersonPrice($person);
		}
		
		if ($resa->getTypeResa() == 'H') {
			$total /= 2;
		}
		
		return $total;
	}			
}