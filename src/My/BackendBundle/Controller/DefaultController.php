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
    	$em = $this->getDoctrine()->getManager();
        $modules = $em->getRepository('MyBackendBundle:Module')->findAll();

        return array('modules' => $modules);
    }
}
