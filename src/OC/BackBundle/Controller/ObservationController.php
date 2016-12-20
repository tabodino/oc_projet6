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
     */
    public function createObservationAction(Request $request)
    {
        $observation = new Observation();
        $userAgent = $request->headers->get('User-Agent');
        // To authorize local test
        ($request->getHost() == "localhost") ? $ip = '82.249.3.94' : $ip = $request->getClientIp();

        $geoip = $this->get('maxmind.geoip')->lookup($ip);
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
            'lat' => $lat,
            'long' => $long,
            'userAgent' => $userAgent,
            'mobile' => $mobile
        ));
    }

    /**
     * @Route("/observation/liste", name="oc_back_observations")
     */
    public function listObservationAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALISTE') ||
            $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $observations = $this->get('oc_back_observation.manager')->getAll();

            return $this->render('OCBackBundle:Observation:list.html.twig', array('observations' => $observations));
        } else {
            return $this->redirectToRoute('oc_back_homepage');
        }
    }

    /**
     * @Route("/observation/mes_observations", name="oc_back_my_observations")
     */
    public function listUserObservations()
    {
        $user = $this->getUser();

        $userId = $user->getId();

        $observations = $this->get('oc_back_observation.manager')->getUserObservations($userId);

        return $this->render('OCBackBundle:Observation:userlist.html.twig', array('observations' => $observations));
    }

    /**
     * @Route("/observation/detail/{id}", name="oc_back_observation_read")
     */
    public function detailObservationAction($id)
    {
        $observation = $this->get('oc_back_observation.manager')->find($id);

        return $this->render('OCBackBundle:Observation:detail.html.twig', array('observation' => $observation));
    }

    /**
     * @Route("/observation/suppression/{id}", name="oc_back_observation_delete")
     */
    public function deleteObservationAction($id)
    {
        $this->get('oc_back_observation.manager')->remove($id);

        return $this->redirectToRoute('oc_back_observations');
    }


    /**
     * @Route("/observation/invalide", name="oc_back_observation_unvalidated")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function invalidatedObservationsAction()
    {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALISTE') ||
            $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $observations = $this->get('oc_back_observation.manager')->getUnvalidatedObservation();

            $orders = $this->get('oc_back_observation.manager')->getAllOrderTaxref();

            return $this->render('OCBackBundle:Observation:invalidated.html.twig', array(
                'observations' => $observations,
                'orders' => $orders,
            ));
        }else {
            return $this->redirectToRoute('oc_back_homepage');
        }


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