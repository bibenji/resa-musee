<?php
namespace AppBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateOpenMuseum extends Constraint
{
    public $message = 'Le musée ne sera malheureusement pas ouvert à cette date !';
}