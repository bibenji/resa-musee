<?php
namespace AppBundle\Events\Listeners;

use AppBundle\Events\ResaDoneEvent;

use AppBundle\Entity\Resa;

class ResaDoneListener
{
	protected $confirmationSender;
	
	// public function construct($confirmationSender)
	public function setConfirmationSender($confirmationSender)
	{
		$this->confirmationSender = $confirmationSender;
	}
		
    public function sendMail(ResaDoneEvent $resaDoneEvent)
    {				
        $resa = $resaDoneEvent->getResa();
		
        // only act on some "Resa" entity
        if (!$resa instanceof Resa) {			
            return;
        }
		
		$total = '10000';
		
		$this->confirmationSender->send($resa, $total);		
    }
}