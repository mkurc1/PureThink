<?php

namespace My\CMSBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use My\CoreBundle\Block\AbstractBlock;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuBlock extends AbstractBlock
{
    public function __construct($name, EngineInterface $templating, EntityManager $em)
    {
        parent::__construct($name, $templating);

        $this->em = $em;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => 'MyCMSBundle:Block:menu.html.twig',
            'name'     => null,
            'locale'   => null,
            'home'     => false,
            'login'    => false
        ]);
    }

    public function getCacheKeys(BlockInterface $block)
    {
        return [
            'type' => $this->name
        ];
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $locale = $blockContext->getSetting('locale');

        return $this->renderResponse($blockContext->getTemplate(), [
                'menus'  => $this->getActiveMenu($blockContext->getSetting('name'), $locale),
                'locale' => $locale,
                'home'   => $blockContext->getSetting('home'),
                'login'  => $blockContext->getSetting('login')
            ],
            $response);
    }

    private function getActiveMenu($groupName, $locale)
    {
        return $this->em->getRepository('MyCMSBundle:Menu')
            ->getActiveMenusBySeriesNameAndLocale($groupName, $locale);
    }
}