<?php

namespace Purethink\CMSBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComponentBlock extends AbstractBlock
{
    const CACHE_TIME = 0;

    /** @var EntityManager */
    protected $em;
    /** @var RequestStack */
    protected $requestStack;

    /**
     * @param string          $name
     * @param EngineInterface $templating
     * @param EntityManager   $em
     * @param RequestStack    $requestStack
     */
    public function __construct($name, EngineInterface $templating, EntityManager $em, RequestStack $requestStack)
    {
        parent::__construct($name, $templating);

        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => null,
            'slug'     => null,
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
        return $this->renderResponse($blockContext->getTemplate(), [
                'entities' => $this->getComponent($blockContext->getSetting('slug'))
            ],
            $response)->setTtl(self::CACHE_TIME);
    }

    /**
     * @param string $slug
     * @return array
     */
    private function getComponent($slug)
    {
        $locale = $this->requestStack->getCurrentRequest()->getLocale();

        return $this->em
            ->getRepository('PurethinkCMSBundle:ComponentHasElement')
            ->getActiveComponentBySlugAndLocale($slug, $locale);
    }
}