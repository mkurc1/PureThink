<?php

namespace My\CMSBundle\Entity;

use My\CoreBundle\Entity\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class Script extends File
{
    /**
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="scripts")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $template;


    protected function getUploadDir()
    {
        $template = $this->getTemplate();
        $templateDir = $template->getUploadDir().'/'.$template->getSlug();

        return $templateDir.'/'.$template->getScriptsUploadDir();
    }

    /**
     * Set template
     *
     * @param \My\CMSBundle\Entity\Template $template
     * @return Script
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
