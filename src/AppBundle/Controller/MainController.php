<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Resa;
use AppBundle\Form\ResaType;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		$session = new Session();		
		$session->clear();
		
        // replace this example code with whatever you need
        return $this->render('AppBundle:Main:index.html.twig', [
            // 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
	
	/**
	 * @Route("/reservation", name="reservation")
	 */
	public function reservationAction(Request $request)
	{
		$session = new Session();
		$session->set('resa_id', 22);		
		
		$resa = new Resa();
		$form = $this->createForm(ResaType::class, $resa);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			
			if (!$resa->getPersons()) {
				throw $this->createNotFoundException('Pas de personnes enregistrées !');
			}
			
			$token = $request->request->get('stripeToken');
			
			$resa->setToken($token);
			
			// $em = $this->get('doctrine.orm.entity_manager');
            // $em->persist($resa);
            // $em->flush();
			
			$session->set('resa', $resa);
			
			return $this->redirectToRoute('validation');	
		}
		
		$fullDays = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Resa')->getFullDays();

		$fullDates = array();
		foreach ($fullDays as $oneDay) {
			$fullDates[] = $oneDay['date']->format('Y-n-d');			
		}
		
		return $this->render('AppBundle:Main:reservation.html.twig', [
            'form' => $form->createView(),
			'fullDates' => $fullDates,
        ]);		
	}
	
	/**
	 * @Route("/validation", name="validation")
	 */
	public function validationAction(Request $request)
	{
		$session = new Session();
		
		// $em = $this->get('doctrine.orm.entity_manager');
		// $resa = $em->getRepository('AppBundle:Resa')->findOneById($id);
		// $resa = $em->getRepository('AppBundle:Resa')->findOneById($session->get('resa_id'));
		$resa = $session->get('resa');
		
		if (!$resa) throw $this->createNotFoundException('Réservation introuvable !');
		
		$total = $this->get('calculator')->calculTotalPrice($resa);
				
		/*
		$total = 0;
		$persons = $resa->getPersons();
		foreach ($persons as $person) {
			if ($person->getAge() >= 4 && $person->getAge() < 12) $total += 8;
			elseif ($person->getReduction() == 1) $total += 10;
			elseif ($person->getAge() >= 12 && $person->getAge() < 60) $total += 16;
			else $total += 12;
		}
		*/
		
		return $this->render('AppBundle:Main:validation.html.twig', [
			'resa' => $resa,
			'total' => $total,
		]);		
	}
	
	/**
	 * @Route("/confirmation", name="confirmation")
	 */
	public function confirmationAction(Request $request)
	{
		$session = new Session();
		
		$resa = $session->get('resa');		
		if (!$resa) throw $this->createNotFoundException('Réservation introuvable !');
				
		// $session->clear();
		
		try {	
		
			\Stripe\Stripe::setApiKey("sk_test_IqL8pyMzT0nC8QmXksCOwMCO");
			
			$charge = \Stripe\Charge::create(array(
				"amount" => $this->get('calculator')->calculTotalPrice($resa).'00',
				"currency" => "eur",
				"description" => "BSM Reservation",
				"source" => $resa->getToken(),
			));
			
		} catch (Exception $e) {
			throw $this->createException('Votre réservation a été interrompue, merci de réessayer !');
		}				
		
		$em = $this->get('doctrine.orm.entity_manager');
		$em->persist($resa);
		$em->flush();
		
		$resa->setCode(uniqid($resa->getNom())); // prefix à changer
		
		$em->persist($resa);
		$em->flush();
		
		return $this->render('AppBundle:Main:confirmation.html.twig', [
            'resa' => $resa,
        ]);		
	}
	
	/**
	 * @Route("/full_days", name="full_days")
	 */
	public function fullDaysAction()
	{
		$fullDays = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Resa')->getFullDays();
		
		// return json_encode($fullDays);
		
		$fullDates = array();
		foreach ($fullDays as $oneDay) {
			$fullDates[] = $oneDay['date']->format('Y-m-d');			
		}
		
		$response = new JsonResponse();
		$response->setData(
			// array()			
			$fullDates
		);
		return $response;
		
	}
	
	/**
	 * @Route("/test", name="test")
	 */
	public function testAction(Request $request)
	{			
		$base_dir = realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR;
		$path_to_img = $base_dir.'web\images\90e35ed.jpg';
				
		$message = \Swift_Message::newInstance();
		
		$logo = $message->embed(\Swift_Image::fromPath($path_to_img));
		
		$message
			->setSubject('Confirmation de votre réservation')
			->setFrom('billetterie@belugasuperstarmuseum.com')
			->setTo('bibibeb@hotmail.fr')
			->setBody(
				$this->renderView(
					'AppBundle:Emails:confirmation.html.twig',
					// 'Emails/confirmation.html.twig',
					array('logo' => $logo)
				), 'text/html'
			)
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
		
		$this->get('mailer')->send($message);		
		
		return $this->render('AppBundle:Main:test.html.twig', [
        
        ]);			
	}
}