<?php

namespace My\CMSBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use My\CoreBundle\Block\AbstractBlock;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComponentBlock extends AbstractBlock
{
    public function __construct($name, EngineInterface $templating, EntityManager $em)
    {
        parent::__construct($name, $templating);

        $this->em = $em;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => null,
            'slug'     => null,
            'locale'   => null
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
                'entities' => $this->getComponent($blockContext->getSetting('slug'), $locale),
                'locale'   => $locale
            ],
            $response);
    }

    private function getComponent($slug, $locale)
    {
        return $this->em->getRepository('MyCMSBundle:ComponentHasElement')
            ->getActiveComponentBySlugAndLocale($slug, $locale);
    }
}