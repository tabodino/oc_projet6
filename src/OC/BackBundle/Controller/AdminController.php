<?php

namespace OC\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/", name="oc_back_homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('OCBackBundle:User');

        $nbUser = $repository->countAllUsers();
        $nbObservation = $this->get('oc_back_observation.manager')->countAllObservations();
        $nbSpecies = $this->get('oc_core_taxref.manager')->countAllTaxref();
        $nbInvalidated = $this->get('oc_back_observation.manager')->countInvalidatedObservations();

        return $this->render('OCBackBundle:Admin:index.html.twig', array(
            'nbUser' => $nbUser,
            'nbObservations' => $nbObservation,
            'nbSpecies' => $nbSpecies,
            'nbInvalidated' => $nbInvalidated,
        ));
    }

    /**
    * @Route("/aide", name="oc_back_help")
    */
    public function helpAction()
    {
        return $this->render('OCBackBundle:Admin:help.html.twig');
    }
}
