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
 * @Route("/admin/cms/left_menu")
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
            "language" => $this->getLanguages($menuId)
            );
    }

    /**
     * Get languages
     *
     * @param integer $menuId
     * @return array
     */
    Private function getLanguages($menuId)
    {
        $languageLeftMeneActiveInMainMenu = array(1, 2, 3, 4);

        if (in_array($menuId, $languageLeftMeneActiveInMainMenu)) {
            $entities = $this->em->getRepository('MyCMSBundle:CMSLanguage')->getLanguages();

            return $this->templateEngine->render("MyCMSBundle:CMSLeftMenu:_languages.html.twig", array('entities' => $entities));
        }
        else {
            return false;
        }
    }
}
