<?php
namespace AppBundle\Services;

class PriceTwigFilterExtension extends \Twig_Extension
{
	private $calculator;
	
	public function __construct ($calculator) {
		$this->calculator = $calculator;
	}
	
	public function getFilters() {
		return array(
			new \Twig_SimpleFilter('price', array($this, 'priceFilter')),			
		);
	}
	
	public function priceFilter($person) {
		return $this->calculator->calculPersonPrice($person);
	}
	
	public function getName()
    {
        return 'price.twig.filter.extension';
    }
}