<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class ComponentHasText extends ComponentHasValue
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;


    public function setContent($content)
    {
        $this->setText($content);

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getText();
    }

    public function getStringContent()
    {
        return $this->getContent();
    }

    /**
     * Set text
     *
     * @param string $text
     * @return ComponentHasText
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }
}
