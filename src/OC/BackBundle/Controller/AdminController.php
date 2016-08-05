<?php

namespace OC\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="oc_back_homepage")
     */
    public function indexAction()
    {
        return $this->render('OCBackBundle:Default:index.html.twig');
    }
}
