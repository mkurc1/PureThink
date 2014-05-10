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
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $template;

    /**
     * @ORM\ManyToOne(targetEntity="Layout", inversedBy="scripts", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $layout;

    /**
     * Set template
     *
     * @param Template $template
     * @return TemplateScript
     */
    public function setTemplate(Template $template = null)
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

    /**
     * Set layout
     *
     * @param Layout $layout
     * @return TemplateScript
     */
    public function setLayout(Layout $layout = null)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get layout
     *
     * @return Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }
}
