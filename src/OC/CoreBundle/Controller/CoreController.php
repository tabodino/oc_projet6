<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CoreController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('OCCoreBundle:Core:index.html.twig');
    }
}
