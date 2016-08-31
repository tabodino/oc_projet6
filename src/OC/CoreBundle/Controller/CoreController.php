<?php

namespace OC\CoreBundle\Controller;

use OC\CoreBundle\Entity\CodeCountry;
use OC\CoreBundle\Form\Handler\ContactFormHandler;
use OC\CoreBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    /**
     * @Route("/", name="oc_core_accueil")
     * @Cache(expires="tomorrow", public=true)
     */
    public function indexAction()
    {
        return $this->render('OCCoreBundle:Core:index.html.twig');
    }

    /**
     * @Route("/contact", name="oc_core_contact")
     * @Cache(expires="tomorrow", public=true)
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        // Récupération service mailer
        $mailer = $this->get('oc_core_mailer');
        // Gestion du formulaire
        $formHandler = new ContactFormHandler($form, $request, $mailer);

        if ($formHandler->process()) return $this->redirectToRoute('oc_core_contact');
        
        return $this->render('OCCoreBundle:Core:contact.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/especes", name="oc_core_especes")
     * @Cache(expires="tomorrow", public=true)
     */
    public function speciesAction()
    {
        // Récupération du manager d'entité taxref
        $orders = $this->get('oc_core_taxref.manager')->getAllOrderTaxref();

        return $this->render('OCCoreBundle:Core:species.html.twig', array('orders' => $orders));
    }

    /**
     * @Route("/detail_espece/ordre/{order}", name="oc_core_details_order_species")
     */
    public function detailOrderSpeciesAction($order)
    {
        // Récupération du manager d'entité taxref
        $orders = $this->get('oc_core_taxref.manager')->getTaxrefSpeciesByOrder($order);

        return $this->render('OCCoreBundle:Core:detailOrderSpecies.html.twig', array('orders' => $orders, 'order' => $order));
    }


    /**
     * @Route("/observations", name="oc_core_observations")
     * @Cache(expires="tomorrow", public=true)
     */
    public function observationAction()
    {
        $observations = $this->get('oc_back_observation.manager')->getValidatedObservation();

        $orders = $this->get('oc_core_taxref.manager')->getAllOrderTaxref();

        return $this->render('OCCoreBundle:Core:observations.html.twig', array(
            'observations' => $observations,
            'orders' => $orders,
        ));
    }


    /**
     * @Route("/observations/details/{id}", name="oc_core_details_observation")
     */
    public function detailObservationAction($id)
    {
        $observation = $this->get('oc_back_observation.manager')->findValidatedObservation($id);

        $orders = $this->get('oc_core_taxref.manager')->getAllOrderTaxref();

        return $this->render('OCCoreBundle:Core:detailObservation.html.twig', array(
            'observation' => $observation,
            'orders' => $orders,
        ));
    }

    /**
     * @Route("/observations/resultats", name="oc_core_result_observation")
     * @Cache(expires="tomorrow", public=true)
     */
    public function searchResultObservationAction(Request $request)
    {
        $keyword = $request->query->get('keyword');
        $observations = $this->get('oc_back_observation.manager')->searchObservation($keyword);
        $orders = $this->get('oc_core_taxref.manager')->getAllOrderTaxref();
        return $this->render('OCCoreBundle:Core:resultObservation.html.twig', array(
            'observations' => $observations,
            'orders' => $orders,
        ));
    }

    /**
     * @Route("/especes/resultats", name="oc_core_result_species")
     * @Cache(expires="tomorrow", public=true)
     */
    public function searchResultSpeciesAction(Request $request)
    {
        $keyword = $request->query->get('keyword');
        $species = $this->get('oc_core_taxref.manager')->searchSpecies($keyword);
        $orders = $this->get('oc_core_taxref.manager')->getAllOrderTaxref();

        return $this->render('OCCoreBundle:Core:resultSpecies.html.twig', array(
            'species' => $species,
            'orders' => $orders,
        ));
    }


    /**
     * @Route("/especes/detail/{id}", name="oc_core_detail_species")
     */
    public function detailSpeciesAction($id)
    {
        $species = $this->get('oc_core_taxref.manager')->find($id);

        return $this->render('OCCoreBundle:Core:detailSpecies.html.twig', array(
            'species' => $species,
        ));
    }

    /**
     * @Route("/map/{test}", name="map")
     */
    public function mapAction($test)
    {
        $countries = $this->get('oc_core_codecountry.manager')->findAll();
       // $params = $this->$request->query->get('params');

        return $this->render('OCCoreBundle:Core:map.html.twig', array(
            'countries' => $countries,
            'test' => $test
        ));
    }

}
