<?php

namespace Purethink\CMSBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Purethink\CoreBundle\Block\AbstractBlock;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuBlock extends AbstractBlock
{
    const CACHE_TIME = 0;

    public function __construct($name, EngineInterface $templating, EntityManager $em, RequestStack $requestStack)
    {
        parent::__construct($name, $templating);

        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => 'PurethinkCMSBundle:Block:menu.html.twig',
            'name'     => null,
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
        return $this->renderResponse($blockContext->getTemplate(), [
                'menus'  => $this->getActiveMenu($blockContext->getSetting('name')),
                'home'   => $blockContext->getSetting('home'),
                'login'  => $blockContext->getSetting('login')
            ],
            $response)->setTtl(self::CACHE_TIME);
    }

    private function getActiveMenu($groupName)
    {
        $locale = $this->requestStack->getCurrentRequest()->getLocale();

        return $this->em->getRepository('PurethinkCMSBundle:Menu')
            ->getActiveMenusBySeriesNameAndLocale($groupName, $locale);
    }
}