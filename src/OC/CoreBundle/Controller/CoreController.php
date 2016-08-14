<?php

namespace OC\CoreBundle\Controller;

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
     * @Route("/detail_espece/{order}", name="oc_core_details_espece")
     * @Cache(expires="tomorrow", public=true)
     */
    public function detailSpeciesAction($order)
    {
        // Récupération du manager d'entité taxref
        $orders = $this->get('oc_core_taxref.manager')->getTaxrefSpeciesByOrder($order);

        return $this->render('OCCoreBundle:Core:detailSpecies.html.twig', array('orders' => $orders, 'order' => $order));
    }


    /**
     * @Route("/detail_observation/{id}", name="oc_core_details_observation")
     * @Cache(expires="tomorrow", public=true)
     */
    public function detailObservationAction($id)
    {
        return $this->render('OCCoreBundle:Core:detailObservation.html.twig');
    }
    
}
