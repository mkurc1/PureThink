<?php

namespace My\CMSBundle\Service;

class LeftMenuService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var TemplateEngine
     */
    private $templateEngine;


    public function __construct($entityManager, $templateEngine)
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
    public function menu($menuId)
    {
        return ["language" => $this->getLanguages($menuId)];
    }

    /**
     * Get languages
     *
     * @param integer $menuId
     * @return array
     */
    private function getLanguages($menuId)
    {
        $languageLeftMeneActiveInMainMenu = [1, 2, 3, 4];

        if (in_array($menuId, $languageLeftMeneActiveInMainMenu)) {
            $entities = $this->em->getRepository('MyCMSBundle:Language')->getLanguages();

            return $this->templateEngine->render("MyCMSBundle:LeftMenu:_languages.html.twig", compact('entities'));
        }
        else {
            return false;
        }
    }
}
