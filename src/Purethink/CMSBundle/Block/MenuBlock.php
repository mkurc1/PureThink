<?php

namespace Purethink\CMSBundle\Block;

use Purethink\CMSBundle\Service\Menu;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuBlock extends AbstractBlock
{
    const CACHE_TIME = 0;

    /** @var Menu */
    private $menu;
    /** @var RequestStack */
    private $requestStack;

    public function __construct($name, EngineInterface $templating, Menu $menu, RequestStack $requestStack)
    {
        parent::__construct($name, $templating);

        $this->menu = $menu;
        $this->requestStack = $requestStack;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => 'PurethinkCMSBundle:Block:menu.html.twig',
            'slug'     => null
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
        $locale = $this->requestStack->getCurrentRequest()->getLocale();
        $slug = $blockContext->getSetting('slug');

        return $this->renderResponse($blockContext->getTemplate(), [
                'menus' => $this->menu->getActiveMenusBySlugAndLocale($slug, $locale),
                'home'  => true
            ],
            $response)->setTtl(self::CACHE_TIME);
    }
}