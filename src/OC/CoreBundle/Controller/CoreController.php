<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CoreController extends Controller
{
    /**
     * @Route("/", name="oc_core_accueil")
     */
    public function indexAction()
    {
        return $this->render('OCCoreBundle:Core:index.html.twig');
    }

    /**
     * @Route("/contact", name="oc_core_contact")
     */
    public function contactAction()
    {
        return $this->render('OCCoreBundle:Core:contact.html.twig');
    }

    /**
     * @Route("/especes", name="oc_core_especes")
     */
    public function speciesAction()
    {
        // Récupération du manager d'entité taxref
        $orders = $this->get('oc_core_taxref.manager')->getAllOrderTaxref();

        return $this->render('OCCoreBundle:Core:species.html.twig', array('orders' => $orders));
    }

    /**
     * @Route("/detail_espece/{order}", name="oc_core_details_espece")
     */
    public function detailSpeciesAction($order)
    {
        // Récupération du manager d'entité taxref
        $orders = $this->get('oc_core_taxref.manager')->getTaxrefSpeciesByOrder($order);

        return $this->render('OCCoreBundle:Core:detailSpecies.html.twig', array('orders' => $orders, 'order' => $order));
    }
}
