<?php
namespace AppBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateAvailable extends Constraint
{
    public $tuesdayClosed = 'Nous sommes désolés, le musée est fermé le mardi.';
    public $daysClosed = 'Nous sommes désolés, le musée est fermé le 1er mai, le 11 novembre et le 25 décembre.';
	public $daysFull = 'Nous sommes désolés, il n\'est plus possible de réserver pour cette date ! Merci de choisir une autre date.';
	public $dayEnd = 'Nous sommes désolés, le musée est fermé après 18 heures.';
}