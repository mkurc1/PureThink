<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class ComponentHasArticle extends ComponentHasValue
{
    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="componentHasArticle", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $article;


    public function setContent($content)
    {
        $this->setArticle($content);

        return $this;
    }

    public function getContent()
    {
        return $this->getArticle();
    }

    public function getStringContent()
    {
        return $this->getContent()->getSlug();
    }

    /**
     * Set article
     *
     * @param \Purethink\CMSBundle\Entity\Article $article
     * @return ComponentHasArticle
     */
    public function setArticle(\Purethink\CMSBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Purethink\CMSBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
