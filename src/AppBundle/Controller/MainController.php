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
			
			$em = $this->get('doctrine.orm.entity_manager');
            $em->persist($resa);
            $em->flush();
			
			$session->set('resa_id', $resa->getId());
			
			return $this->redirectToRoute('validation', array('id' => $resa->getId()));	
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
	 * @Route("/validation/{id}", requirements={"id" = "\d+"}, name="validation")
	 */
	public function validationAction(Request $request, $id)
	{
		$session = new Session();
		
		$em = $this->get('doctrine.orm.entity_manager');
		// $resa = $em->getRepository('AppBundle:Resa')->findOneById($id);
		$resa = $em->getRepository('AppBundle:Resa')->findOneById($session->get('resa_id'));
		
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
		return $this->render('AppBundle:Main:confirmation.html.twig', [
            // 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
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
}
