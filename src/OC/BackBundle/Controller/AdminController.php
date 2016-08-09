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
        return $this->render('OCBackBundle:Admin:index.html.twig');
    }

    /**
    * @Route("/aide", name="oc_back_help")
    */
    public function helpAction()
    {
        return $this->render('OCBackBundle:Admin:help.html.twig');
    }
}
