<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class ComponentHasArticle extends ComponentHasValue
{
    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(onDelete="CASCADE")
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

    /**
     * Set article
     *
     * @param \My\CMSBundle\Entity\Article $article
     * @return ComponentHasArticle
     */
    public function setArticle(\My\CMSBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \My\CMSBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }
}
