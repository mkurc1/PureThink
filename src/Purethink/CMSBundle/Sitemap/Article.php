<?php
namespace Purethink\CMSBundle\Sitemap;

use SitemapGenerator\Entity\Url;
use SitemapGenerator\Provider\ProviderInterface;
use SitemapGenerator\Sitemap\Sitemap;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManager;

class Article implements ProviderInterface
{
    public function __construct(RouterInterface $router, EntityManager $em)
    {
        $this->router = $router;
        $this->em = $em;
    }

    public function populate(Sitemap $sitemap)
    {
        $articles = $this->em->getRepository('PurethinkCMSBundle:Article')
            ->getPublicArticles();
        foreach ($articles as $article) {
            $routeParams = [
                'locale' => strtolower($article->getLanguage()->getAlias()),
                'slug'   => $article->getSlug()
            ];

            $this->addUrl($sitemap, 'article', $routeParams);
        }

    }

    protected function addUrl(Sitemap $sitemap, $route, array $routeParams)
    {
        $url = new Url();
        $url->setLoc($this->getLocation($route, $routeParams));
        $sitemap->add($url);
    }

    private function getLocation($route, array $params)
    {
        return $this->router->generate($route, $params);
    }
}