<?php

namespace My\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="frontend")
     */
    public function mainAction()
    {
        $request = $this->getRequest();

        $locale = $request->getLocale();

        return $this->redirect($this->generateUrl('localized_frontend', array('locale' => $locale)));
    }

    /**
     * @Route("/{locale}", name="localized_frontend")
     * @Template()
     */
    public function indexAction($locale)
    {
        $request = $this->getRequest();

        $request->setLocale($locale);

        return array();
    }
}
