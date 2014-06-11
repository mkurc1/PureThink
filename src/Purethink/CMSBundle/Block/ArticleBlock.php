<?php

namespace Purethink\CMSBundle\Block;

use Purethink\CMSBundle\Service\Article;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleBlock extends AbstractBlock
{
    const CACHE_TIME = 0;

    private $article;
    private $requestStack;

    public function __construct($name, EngineInterface $templating, Article $article, RequestStack $requestStack)
    {
        parent::__construct($name, $templating);

        $this->article = $article;
        $this->requestStack = $requestStack;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => 'PurethinkCMSBundle:Block:article.html.twig'
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
        $slug = $this->requestStack->getCurrentRequest()->attributes->get('slug');

        return $this->renderResponse($blockContext->getTemplate(), [
                'article' => $this->article->getArticleBySlugAndIncrementCountViews($slug),
            ],
            $response)->setTtl(self::CACHE_TIME);
    }
}