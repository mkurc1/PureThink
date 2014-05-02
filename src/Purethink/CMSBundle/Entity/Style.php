<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class Style extends File
{
    /**
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="styles", cascade={"persist"})
     */
    private $template;

    /**
     * Set template
     *
     * @param \Purethink\CMSBundle\Entity\Template $template
     * @return Style
     */
    public function setTemplate(\Purethink\CMSBundle\Entity\Template $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \Purethink\CMSBundle\Entity\Template 
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
