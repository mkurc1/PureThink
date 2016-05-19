<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class ComponentHasArticle extends ComponentHasValue
{
    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="componentHasArticle", cascade={"persist"}, fetch="EAGER")
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
        if ($this->getContent()) {
            return $this->getContent()->getSlug();
        } else {
            return '';
        }
    }

    /**
     * Set article
     *
     * @param Article $article
     * @return ComponentHasArticle
     */
    public function setArticle(Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
