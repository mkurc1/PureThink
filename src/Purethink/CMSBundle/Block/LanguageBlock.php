<?php

namespace Purethink\CMSBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Purethink\CoreBundle\Block\AbstractBlock;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LanguageBlock extends AbstractBlock
{
    public function __construct($name, EngineInterface $templating, EntityManager $em)
    {
        parent::__construct($name, $templating);

        $this->em = $em;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => 'PurethinkCMSBundle:Block:language.html.twig',
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
        return $this->renderResponse($blockContext->getTemplate(), [
                'languages' => $this->getPublicLanguages(),
                'locale'    => $blockContext->getSetting('locale'),
            ],
            $response);
    }

    private function getPublicLanguages()
    {
        return $this->em->getRepository('PurethinkCMSBundle:Language')
            ->getPublicLanguages();
    }
}