<?php

namespace My\CMSArticleBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CMSArticleRepositoryFunctionalTest extends WebTestCase
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

    public function testSearchArticleByLocaleAndName()
    {
        $existArticles = $this->getArticleByLocaleAndName('pl', 'Lorem Ipsum Dolor');
        $this->assertCount(80, $existArticles);

        $noExitArticles = $this->getArticleByLocaleAndName('pl', 'abc');
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

    private function getArticleByLocaleAndName($locale, $name)
    {
        return $this->em
            ->getRepository('MyCMSBundle:CMSArticle')
            ->search($locale, $name)
        ;
    }

    private function getArticleBySlug($slug)
    {
        return $this->em
            ->getRepository('MyCMSBundle:CMSArticle')
            ->getArticleBySlug($slug)
        ;
    }
}