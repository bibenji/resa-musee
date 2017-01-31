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
		// $session = new Session(); // fait planter les tests		
		$session = $this->get('session');
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
		// $session = new Session(); // fait planter les tests
		$session = $this->get('session');
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
		// $session = new Session(); // fait planter les tests
		$session = $this->get('session');
		
		$resa = $session->get('resa');
		
		if (!$resa) throw $this->createNotFoundException('Réservation introuvable !');
		
		$total = $this->get('calculator')->calculTotalPrice($resa);
				
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
		// $session = new Session(); // fait planter les tests
		$session = $this->get('session');
		
		$resa = $session->get('resa');		
		if (!$resa) throw $this->createNotFoundException('Réservation introuvable !');
				
		$session->clear();
		
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
		
		$total = $this->get('calculator')->calculTotalPrice($resa);		
		$this->get('confirmation_sender')->send($resa, $total);		
		
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