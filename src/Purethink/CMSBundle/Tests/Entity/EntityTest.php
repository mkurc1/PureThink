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
    public function testGetters()
    {
        // Given
        $article = new Article();
        $article->setName('Article name');
        $article->setSlug('article-slug');

        $date = new \DateTime();
        $article->setCreated($date);
        $article->setUpdated($date);

        $article->setPublished(true);

        $article->setContent('Article content');

        $language = new Language('English', 'EN');
        $article->setLanguage($language);

        $user = new User();
        $article->setUser($user);

        $articleView = new ArticleView();
        $article->setView($articleView);

        $metadata = new Metadata();
        $article->setMetadata($metadata);

        $tag1 = new Tag();
        $tag2 = new Tag();
        $article->addTag($tag1);
        $article->addTag($tag2);

        // Then
        $this->assertEquals('Article name', $article->getName(), 'Should return correct article name');
        $this->assertEquals('article-slug', $article->getSlug(), 'Should return correct article slug');
        $this->assertEquals($date, $article->getCreated(), 'Should return correct creation date');
        $this->assertEquals($date, $article->getUpdated(), 'Should return correct modification date');
        $this->assertTrue($article->getPublished(), 'Should return that article is flagged as published');
        $this->assertEquals('Article content', $article->getContent(), 'Should return correct article content');
    }
}