<?php
namespace AppBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TypePossible extends Constraint
{
    public $message = 'Nous sommes désolés, les billets à la journée ne sont plus disponibles pour aujourd\'hui.';
	
	public function getTargets()
	{
		return self::CLASS_CONSTRAINT;
	}
}