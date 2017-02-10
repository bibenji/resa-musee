<?php
namespace AppBundle\Events;

use Symfony\Component\EventDispatcher\Event;

use AppBundle\Entity\Resa;

class ResaDoneEvent extends Event
{	
	const NAME = 'resa.done';
	
	protected $resa;
	
	public function __construct(Resa $resa)
    {
        $this->resa = $resa;
    }
	
	public function getResa()
	{
		return $this->resa;
	}
}