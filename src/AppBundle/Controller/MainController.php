<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

// use Symfony\Component\HttpFoundation\Response;

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
		$session = $this->get('session');
		$session->clear();
        
        return $this->render('AppBundle:Main:index.html.twig');
    }
	
	
	/**
	 * @Route("/reservation", name="reservation")
	 */
	public function reservationAction(Request $request)
	{		
		$session = $this->get('session');
		
		$resa = $session->get('resa');
		
		if(!$resa) {
			$resa = new Resa();
		}			
		else {
			$this->get('session')->getFlashBag()->clear();
			$this->addFlash('info', 'Une réservation est toujours en cours...');
		}					
				
		$form = $this->createForm(ResaType::class, $resa);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			
			if (!$resa->getPersons()) {
				throw $this->createNotFoundException('Pas de personnes enregistrées !');
			}
			
			$token = $request->request->get('stripeToken');			
			$resa->setToken($token);
			
			$session->set('resa', $resa);
			
			$card = substr($request->request->get('card'), 0, 4).strtr(substr($request->request->get('card'), 4), '0123456789', '**********');
			$session->set('card', $card);
			
			return $this->redirectToRoute('validation');	
		}
		
		// dates pleines pour le datepicker
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
		$session = $this->get('session');
		
		$resa = $session->get('resa');
		
		if (!$resa) throw $this->createNotFoundException('Réservation introuvable !');
		
		$total = $this->get('calculator')->calculTotalPrice($resa);
		
		$cardNumber = $session->get('card');
				
		return $this->render('AppBundle:Main:validation.html.twig', [
			'resa' => $resa,
			'total' => $total,
			'cardNumber' => $cardNumber,
		]);
	}
	
	
	/**
	 * @Route("/confirmation", name="confirmation")
	 */
	public function confirmationAction(Request $request)
	{		
		$session = $this->get('session');
		
		$resa = $session->get('resa');		
		if (!$resa) throw $this->createNotFoundException('Réservation introuvable !');
				
		$session->clear();
		
		try {
			
			$apiKey = $this->getParameter('stripe_api_key');
		
			\Stripe\Stripe::setApiKey($apiKey);
			
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
		
		$resa->setCode(uniqid(strtoupper($resa->getNom()))); // préfix à changer
		
		$total = $this->get('calculator')->calculTotalPrice($resa);		
		$this->get('confirmation_sender')->send($resa, $total);		
		
		$em->persist($resa);
		$em->flush();
		
		return $this->render('AppBundle:Main:confirmation.html.twig', [
            'resa' => $resa,
        ]);		
	}
	
	
	/**
	 * Route de test 1
	 *
	 * @Route("/full_days", name="full_days")
	 */
	public function fullDaysAction()
	{
		$fullDays = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Resa')->getFullDays();
				
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
	 * Route de test 2
	 *
	 * @Route("/test", name="test")
	 */
	public function testAction(Request $request)
	{			
		$resa = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Resa')->findOneById(4);		
		if (!$resa) throw $this->createNotFoundException('Réservation introuvable !');
		
		$total = $this->get('calculator')->calculTotalPrice($resa);
		
		$this->get('confirmation_sender')->send($resa, $total);		
		
		return $this->render('AppBundle:Emails:confirmation.html.twig', [
			'logo' => 'logo',
			'resa' => $resa,
			'total' => $total,
        ]);			
	}
}