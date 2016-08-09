<?php

namespace OC\BackBundle\Controller;

use OC\BackBundle\Entity\Observation;
use OC\BackBundle\Form\Handler\ObservationFormHandler;
use OC\BackBundle\Form\Type\ObservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller
{
    /**
     * @Route("/observation/creation", name="oc_back_observation_create")
     */
    public function createObservationAction(Request $request)
    {
        $observation = new Observation();

        $form = $this->createForm(ObservationType::class, $observation);

        $formHandler = new ObservationFormHandler($form, $request, $this->getDoctrine()->getManager(), $observation);

        if ($formHandler->process()) return $this->redirectToRoute('oc_back_homepage');

        return $this->render('OCBackBundle:Observation:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/observations", name="oc_back_observations")
     */
    public function listObservationAction()
    {
        $observations = $this->get('oc_back_observation.manager')->getAll();

        return $this->render('OCBackBundle:Observation:list.html.twig', array('observations' => $observations));
    }

    /**
     * @Route("/observation/detail/{id}", name="oc_back_observation_read")
     */
    public function detailObservationAction($id)
    {
        $observation = $this->get('oc_back_observation.manager')->find($id);

        return $this->render('OCBackBundle:Observation:list.html.twig', array('observation' => $observation));
    }
    
}