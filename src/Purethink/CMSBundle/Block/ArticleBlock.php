<?php

namespace Purethink\CMSBundle\Block;

use Doctrine\ORM\EntityManager;
use Purethink\CMSBundle\Entity\Article;
use Purethink\CMSBundle\Entity\ArticleView;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleBlock extends AbstractBlock
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
        return $this->renderResponse($blockContext->getTemplate(), [
                'article' => $this->getArticle(),
            ],
            $response)->setTtl(self::CACHE_TIME);
    }

    private function getArticle()
    {
        $slug = $this->requestStack->getCurrentRequest()->attributes->get('slug');

        /** @var Article $article */
        $article = $this->em
            ->getRepository('PurethinkCMSBundle:Article')
            ->getPublicArticleBySlug($slug);

        if (null == $article) {
            throw new NotFoundHttpException();
        }

        $this->incrementArticleViews($article->getViews());

        return $article;
    }

    private function incrementArticleViews(ArticleView $article)
    {
        $article->incrementArticleViews();

        $this->em->flush();
    }
}