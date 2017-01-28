<?php
namespace AppBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateAvailable extends Constraint
{
    public $message = 'Nous sommes désolés, il n\'est pas possible de réserver à la date indiquée ! Merci de choisir une autre date.';
}