<?php

namespace My\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="backend")
     * @Template()
     */
    public function indexAction()
    {
        $modules = $this->getDoctrine()->getRepository('MyBackendBundle:Module')->findAll();

        return compact('modules');
    }
}
