<?php
namespace AppBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Doctrine\ORM\EntityManager;

class DateAvailableValidator extends ConstraintValidator
{
	private $mng;
	
	public function __construct (EntityManager $entityManager)
	{
		$this->mng = $entityManager;	
	}
	
    public function validate($date, Constraint $constraint)
    {	
		$fullDays = $this->mng->getRepository('AppBundle:Resa')->getFullDays();

		$fullDates = array();
		foreach ($fullDays as $oneDay) {
			$fullDates[] = $oneDay['date']->format('Y-n-d');			
		}
		
		if ($date->format('l') == 'Tuesday') {
			$this
				->context->buildViolation($constraint->tuesdayClosed)
                // ->setParameter('%string%', $value)
                ->addViolation();
		}
		
		if (
			$date->format('d-m') == '01-05'
			OR
			$date->format('d-m') == '01-11'
			OR
			$date->format('d-m') == '25-12'						
		) { 
			$this
				->context->buildViolation($constraint->daysClosed)
                // ->setParameter('%string%', $value)
                ->addViolation();
        }
		
		if (in_array($date->format('Y-n-d'), $fullDates)) {
			$this
				->context->buildViolation($constraint->daysFull)
                // ->setParameter('%string%', $value)
                ->addViolation();
		}
    }
}