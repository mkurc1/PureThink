<?php

namespace Purethink\CMSBundle\Tests\Entity;

use Purethink\CMSBundle\Entity\ArticleView;


class ArticleViewTest extends \PHPUnit_Framework_TestCase
{
    public function testGetters()
    {
        // Given
        $articleView = new ArticleView();
        $articleView->setViews(3);

        // Then
        $this->assertEquals(3, $articleView->getViews(), 'Should return correct articleViews count of views');
    }
}