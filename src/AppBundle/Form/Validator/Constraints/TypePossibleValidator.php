<?php
namespace AppBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TypePossibleValidator extends ConstraintValidator
{	
    public function validate($resa, Constraint $constraint)
    {	
		$date = new \DateTime();
		
		if (
			$resa->getTypeResa() == 'F'
			AND
			$resa->getDate()->format('d-m-Y') == $date->format('d-m-Y')
			AND
			$date->format('H') >= '14'
		) { 
			$this
				->context->buildViolation($constraint->message)
                // ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}