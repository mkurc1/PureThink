<?php

namespace Purethink\CMSArticleBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleRepositoryFunctionalTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    public function testSearchArticlesByLocaleAndName()
    {
        $existArticles = $this->getArticlesByLocaleAndName('pl', 'Lorem Ipsum Dolor');
        $this->assertCount(16, $existArticles);

        $noExitArticles = $this->getArticlesByLocaleAndName('pl', 'abc');
        $this->assertCount(0, $noExitArticles);
    }

    public function testSearchArticleBySlug()
    {
        $existArticle = $this->getArticleBySlug('lorem-ipsum-dolor-sit-amet-consectetur');
        $this->assertNotEmpty($existArticle);

        $noExitArticle = $this->getArticleBySlug('abc');
        $this->assertEmpty($noExitArticle);

    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }

    private function getArticlesByLocaleAndName($locale, $name)
    {
        return $this->em
            ->getRepository('PurethinkCMSBundle:Article')
            ->search($locale, $name)
        ;
    }

    private function getArticleBySlug($slug)
    {
        return $this->em
            ->getRepository('PurethinkCMSBundle:Article')
            ->getArticleBySlug($slug)
        ;
    }
}