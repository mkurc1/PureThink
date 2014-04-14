<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\ComponentHasTextRepository")
 */
class ComponentHasText extends ComponentHasValue
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;


    /**
     * Set content
     *
     * @param string $content
     * @return ComponentHasText
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function getStringContent()
    {
        return $this->getContent();
    }
}
