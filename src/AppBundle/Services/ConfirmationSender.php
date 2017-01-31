<?php
namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\Resa;

class ConfirmationSender
{	
	protected $container;
	protected $mailer;
	protected $twig;
 
    public function __construct(ContainerInterface $container)
    {
		$this->container = $container;
		$this->mailer = $container->get('mailer');
		$this->twig = $container->get('templating');		
    }
		
	public function send($resa, $total)
	{			
		$base_dir = realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR;
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