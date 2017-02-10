<?php
namespace AppBundle\Services;

use AppBundle\Entity\Resa;

class ConfirmationSender
{		
	protected $mailer;
	protected $twig;
	protected $paramKernelRootDir;
	protected $calculator;
     
    public function __construct($mailer, $twig, $paramKernelRootDir, $calculator)
    {
		$this->mailer = $mailer;	
		$this->twig = $twig;
		$this->paramKernelRootDir = $paramKernelRootDir;
		$this->calculator = $calculator;
    }
			
	public function send($resa)
	{	
		$total = $this->calculator->calculTotalPrice($resa);
		
		$base_dir = realpath($this->paramKernelRootDir.'/..').DIRECTORY_SEPARATOR;
		$path_to_img = $base_dir.'web\images\90e35ed.jpg';
				
		$message = \Swift_Message::newInstance();
		
		$logo = $message->embed(\Swift_Image::fromPath($path_to_img));
				
		$message
			->setSubject('Confirmation de votre réservation du '.$resa->getDate()->format('d/m/Y'))
			->setFrom('billetterie@belugasuperstarmuseum.com')
			->setTo($resa->getEmail())
			->setBody(
				$this->twig->render(
					'AppBundle:Emails:confirmation.html.twig',
					// 'Emails/confirmation.html.twig',
					array('logo' => $logo, 'resa' => $resa, 'total' => $total)		
				), 'text/html')
			// ->attach($attachment)
			/*
			* If you also want to include a plaintext version of the message
			->addPart(
			$this->renderView(
				'Emails/registration.txt.twig',
				array('name' => $name)
			),
			'text/plain'
			)
			*/
			;		
		
		// $this->get('mailer')->send($message);		
		$this->mailer->send($message);		
	}	
}