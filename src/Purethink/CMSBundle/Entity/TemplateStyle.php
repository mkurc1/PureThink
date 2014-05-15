<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class TemplateStyle extends TemplateFile
{
    const DIRECTORY_NAME = 'css';

    /**
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="styles", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $template;

    /**
     * @ORM\ManyToOne(targetEntity="Layout", inversedBy="styles", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $layout;


    private function getParentPath()
    {
        if ($this->getTemplate()) {
            return $this->getTemplate()->getAssetPath();
        } else {
            return$this->getLayout()->getTemplate()->getAssetPath();
        }
    }

    public function getAllPath()
    {
        return $this->getParentPath() . DIRECTORY_SEPARATOR . self::DIRECTORY_NAME . DIRECTORY_SEPARATOR . $this->getPath();
    }

    /**
     * Set template
     *
     * @param Template $template
     * @return TemplateStyle
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
     * @return TemplateStyle
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
