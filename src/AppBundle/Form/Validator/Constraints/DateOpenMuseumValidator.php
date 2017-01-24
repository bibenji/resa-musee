<?php
namespace AppBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateOpenMuseumValidator extends ConstraintValidator
{
    public function validate($date, Constraint $constraint)
    {		
		if (
			$date->format('l') == 'Tuesday'
			OR
			$date->format('d-m') == '01-05'
			OR
			$date->format('d-m') == '01-11'
			OR
			$date->format('d-m') == '25-12'
		) { 
			$this
				->context->buildViolation($constraint->message)
                // ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}