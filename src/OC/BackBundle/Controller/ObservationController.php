<?php

namespace OC\BackBundle\Controller;

use OC\BackBundle\Entity\Observation;
use OC\BackBundle\Form\Handler\ObservationFormHandler;
use OC\BackBundle\Form\Type\ObservationType;
use OC\BackBundle\Services\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller
{
    /**
     * @Route("/observation/creation", name="oc_back_observation_create")
     * @Cache(expires="tomorrow", public=true)
     */
    public function createObservationAction(Request $request)
    {
        $observation = new Observation();

        $userAgent = $request->headers->get('User-Agent');

        $geoip = $this->get('maxmind.geoip')->lookup('82.249.3.94');
        $lat = $geoip->getLatitude();
        $long = $geoip->getLongitude();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(ObservationType::class, $observation);

        $formHandler = new ObservationFormHandler($form, $request, $this->getDoctrine()->getManager(), $observation, $user);

        $mobileDetector = new MobileDetector();

        $mobile = $mobileDetector->isMobile($request);

        if ($formHandler->process()) return $this->redirectToRoute('oc_back_observations');

        return $this->render('OCBackBundle:Observation:create.html.twig', array(
            'form' => $form->createView(),
            'lat' =>$lat,
            'long' =>$long,
            'userAgent' => $userAgent,
            'mobile' => $mobile

        ));
    }

    /**
     * @Route("/observations", name="oc_back_observations")
     * @Cache(expires="tomorrow", public=true)
     */
    public function listObservationAction()
    {
        $observations = $this->get('oc_back_observation.manager')->getAll();

        return $this->render('OCBackBundle:Observation:list.html.twig', array('observations' => $observations));
    }

    /**
     * @Route("/observation/detail/{id}", name="oc_back_observation_read")
     * @Cache(expires="tomorrow", public=true)
     */
    public function detailObservationAction($id)
    {
        $observation = $this->get('oc_back_observation.manager')->find($id);

        return $this->render('OCBackBundle:Observation:detail.html.twig', array('observation' => $observation));
    }

    /**
     * @Route("/observation/suppression/{id}", name="oc_back_observation_delete")
     * @Cache(expires="tomorrow", public=true)
     */
    public function deleteObservationAction($id)
    {
        $this->get('oc_back_observation.manager')->remove($id);

        return $this->redirectToRoute('oc_back_observations');
    }

    /**
     * @Route("/observations/invalides", name="oc_back_invalidated_observations")
     * @Cache(expires="tomorrow", public=true)
     */
    public function invalidatedObservationAction()
    {
        $observations = $this->get('oc_back_observation.manager')->getUnvalidatedObservation();

        $orders = $this->get('oc_back_observation.manager')->getAllOrderTaxref();

        return $this->render('OCBackBundle:Observation:invalidated.html.twig', array(
            'observations' => $observations,
            'orders' => $orders,
        ));
    }

    /**
     * @Route("/observation/validation/detail/{id}", name="oc_back_observation_validation_read")
     *
     */
    public function invalidatedDetailObservationAction($id, Request $request)
    {

        $observation = $this->get('oc_back_observation.manager')->find($id);

        $orders = $this->get('oc_core_taxref.manager')->getAllOrderTaxref();

        if ($request->isMethod('post'))
        {

            $observation->setValidated(1);

            $observation->setFamily($request->get('ordre'));
            $observation->setOrdre($request->get('ordre'));

            $em = $this->getDoctrine()->getManager();
            $em->getRepository('OCBackBundle:Observation');

            $em->persist($observation);

            $em->flush();

            return $this->redirectToRoute('oc_back_invalidated_observations');
        }

        return $this->render('OCBackBundle:Observation:invalidatedDetail.html.twig', array(
            'observation' => $observation,
            'orders' => $orders,
        ));
    }


    
}