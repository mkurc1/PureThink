<?php

namespace Purethink\CMSBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine;

class LeftMenuService
{
    private $em;

    private $templating;


    public function __construct(EntityManager $entityManager, TimedTwigEngine $templating)
    {
        $this->em = $entityManager;
        $this->templating = $templating;
    }

    public function menu($menuId)
    {
        return ["language" => $this->getLanguages($menuId)];
    }

    private function getLanguages($menuId)
    {
        $languageLeftMenuActiveInMainMenu = [1, 2, 3, 4];

        if (in_array($menuId, $languageLeftMenuActiveInMainMenu)) {
            $entities = $this->em->getRepository('PurethinkCMSBundle:Language')->getLanguages();

            return $this->templating->render("PurethinkCMSBundle:LeftMenu:_languages.html.twig",
                compact('entities'));
        }
        else {
            return false;
        }
    }
}
