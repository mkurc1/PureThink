<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class TemplateScript extends TemplateFile
{
    /**
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="scripts", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $template;

    /**
     * Set template
     *
     * @param Template $template
     * @return TemplateScript
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
