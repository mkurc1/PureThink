<?php

namespace Purethink\CMSBundle\Tests\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Purethink\CMSBundle\Entity\Article;
use Purethink\CMSBundle\Entity\Language;
use Purethink\CMSBundle\Entity\Metadata;
use Purethink\CMSBundle\Entity\Tag;
use Purethink\CMSBundle\Entity\ArticleView;

class ArticleTest extends \PHPUnit_Framework_TestCase
{
    /** @var Article */
    private $article;

    public function setUp()
    {
        $this->article = new Article();
    }

    public function testGetters()
    {
        // Given
        $this->article->setName('Article name');
        $this->article->setSlug('article-slug');

        $date = new \DateTime();
        $this->article->setCreated($date);
        $this->article->setUpdated($date);

        $this->article->setPublished(true);

        $this->article->setContent('Article content');

        $language = new Language('Article language', 'EN');
        $this->article->setLanguage($language);

        $user = new User();
        $user->setFirstname('Article owner name');
        $this->article->setUser($user);

        $articleView = new ArticleView();
        $articleView->setViews(3);
        $this->article->setView($articleView);

        $metadata = new Metadata();
        $metadata->setTitle('Article title');
        $this->article->setMetadata($metadata);

        $this->article->addTag(new Tag());
        $this->article->addTag(new Tag());

        // Then
        $this->assertEquals('Article name', $this->article->getName());
        $this->assertEquals('article-slug', $this->article->getSlug());
        $this->assertEquals($date, $this->article->getCreated());
        $this->assertEquals($date, $this->article->getUpdated());
        $this->assertTrue($this->article->getPublished());
        $this->assertEquals('Article content', $this->article->getContent());
        $this->assertEquals('Article language', $this->article->getLanguage()->getName());
        $this->assertEquals('Article owner name', $this->article->getUser()->getFirstname());
        $this->assertEquals(3, $this->article->getViews()->getViews());
        $this->assertEquals('Article title', $this->article->getMetadata()->getTitle());
        $this->assertEquals(2, $this->article->getTags()->count());
    }

    public function testToString()
    {
        $this->article->setName(null);
        $this->assertEquals('', $this->article);

        $this->article->setName('zz');
        $this->assertEquals('zz', $this->article);
    }
}