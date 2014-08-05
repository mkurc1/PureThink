<?php

namespace Purethink\CMSBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

class MenuBlock extends AbstractBlock
{
    const CACHE_TIME = 0;

    /** @var EntityManager */
    private $entityManager;
    /** @var RequestStack */
    private $requestStack;

    /**
     * @param string          $name
     * @param EngineInterface $templating
     * @param EntityManager   $entityManager
     * @param RequestStack    $requestStack
     */
    public function __construct($name, EngineInterface $templating, EntityManager $entityManager, RequestStack $requestStack)
    {
        parent::__construct($name, $templating);

        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => 'PurethinkCMSBundle:Block:menu.html.twig',
            'slug'     => null
        ]);
    }

    /**
     * @param BlockInterface $block
     * @return array|void
     */
    public function getCacheKeys(BlockInterface $block)
    {
        return [
            'type' => $this->name
        ];
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response              $response
     * @return Response
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $locale = $this->requestStack->getCurrentRequest()->getLocale();
        $slug = $blockContext->getSetting('slug');

        return $this->renderResponse($blockContext->getTemplate(), [
                'menu' => $this->getActiveMenu($slug, $locale),
                'home' => true
            ],
            $response)->setTtl(self::CACHE_TIME);
    }

    /**
     * @param $slug
     * @param $locale
     * @return ArrayCollection
     */
    public function getActiveMenu($slug, $locale)
    {
        /** @var ArrayCollection $menu */
        $menu = $this->entityManager
            ->getRepository('PurethinkCMSBundle:Menu')
            ->getActiveMenu($slug, $locale);

        return $menu;
    }
}