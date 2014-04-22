<?php

namespace My\CMSBundle\Entity;

use My\CoreBundle\Entity\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class Style extends File
{
    /**
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="styles")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $template;


    protected function getUploadDir()
    {
        $template = $this->getTemplate();
        $templateDir = $template->getUploadDir().'/'.$template->getSlug();

        return $templateDir.'/'.$template->getStylesUploadDir();
    }

    /**
     * Set template
     *
     * @param \My\CMSBundle\Entity\Template $template
     * @return Style
     */
    public function setTemplate(\My\CMSBundle\Entity\Template $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \My\CMSBundle\Entity\Template 
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
