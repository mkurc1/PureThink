<?php

namespace Purethink\CMSBundle\Entity;

use Purethink\CoreBundle\Entity\File;
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

        return $templateDir.'/'.$template->getStylesUploadDir();
    }

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
