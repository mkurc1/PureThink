<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cms_article_view")
 * @ORM\Entity(repositoryClass="Purethink\CMSBundle\Repository\ArticleViewRepository")
 */
class ArticleView implements ArticleViewInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $views = 0;


    public function __toString()
    {
        return (string)$this->getViews();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return ArticleView
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }
}
