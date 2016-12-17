<?php

namespace OC\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/", name="oc_back_homepage")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('OCBackBundle:User');

        $nbUser = $repository->countAllUsers();

        $nbObservation = $this->get('oc_back_observation.manager')->countAllObservations();

        $nbSpecies = $this->get('oc_core_taxref.manager')->countAllTaxref();

        return $this->render('OCBackBundle:Admin:index.html.twig', array(
            'nbUser' => $nbUser,
            'nbObservations' => $nbObservation,
            'nbSpecies' => $nbSpecies,
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
