<?php

namespace My\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * LeftMenu controller.
 *
 * @Route("/left_menu")
 */
class CMSLeftMenuController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var TemplateEngine
     */
    private $templateEngine;

    public function __construct($entityManager = false, $templateEngine = false)
    {
        $this->em = $entityManager;
        $this->templateEngine = $templateEngine;
    }

    /**
     * Get menu
     *
     * @param integer $menuId
     * @return array
     */
    Public function menu($menuId)
    {
        return array(
            "language" => $this->getLanguages()
            );
    }

    /**
     * Get languages
     *
     * @return array
     */
    Private function getLanguages()
    {
        $entities = $this->em->getRepository('MyCMSBundle:CMSLanguage')->getLanguages();

        return $this->templateEngine->render("MyCMSBundle:CMSLeftMenu:_languages.html.twig", array('entities' => $entities));
    }
}
