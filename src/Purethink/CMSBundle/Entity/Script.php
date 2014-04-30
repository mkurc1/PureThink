<?php

namespace Purethink\CMSBundle\Entity;

use Purethink\CoreBundle\Entity\File;
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


    protected function generateFileName()
    {
        return $this->getFile()->getClientOriginalName();
    }

    public function __construct(Template $template = null)
    {
        if (null != $template) {
            $this->setTemplate($template);
        }
    }

    protected function getUploadDir()
    {
        $template = $this->getTemplate();
        $templateDir = $template->getUploadDir().'/'.$template->getSlug();

        return $templateDir.'/'.$template->getScriptsUploadDir();
    }

    /**
     * Set template
     *
     * @param \Purethink\CMSBundle\Entity\Template $template
     * @return Script
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
