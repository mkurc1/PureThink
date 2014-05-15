<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="cms_layout")
 * @ORM\Entity(repositoryClass="Purethink\CMSBundle\Repository\LayoutRepository")
 */
class Layout
{
    const LAYOUT_MAIN = 1;
    const LAYOUT_ARTICLE = 2;
    const LAYOUT_SEARCH = 3;

    public static $availableType = [
        self::LAYOUT_MAIN    => 'Main',
        self::LAYOUT_ARTICLE => 'Article',
        self::LAYOUT_SEARCH  => 'Search'
    ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="Template")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $template;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="TemplateScript", mappedBy="layout", cascade={"persist"}, orphanRemoval=true)
     */
    private $scripts;

    /**
     * @ORM\OneToMany(targetEntity="TemplateStyle", mappedBy="layout", cascade={"persist"}, orphanRemoval=true)
     */
    private $styles;


    public function getAllPath()
    {
        return $this->getTemplate()->getScriptPath() . ':' . $this->getPath();
    }

    public function __toString()
    {
        return (string)$this->getStringType();
    }

    public function getStringType()
    {
        return self::$availableType[$this->getType()];
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Layout
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set template
     *
     * @param Template $template
     * @return Layout
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

    /**
     * Set type
     *
     * @param integer $type
     * @return Layout
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scripts = new ArrayCollection;
        $this->styles = new ArrayCollection;
    }

    /**
     * Add scripts
     *
     * @param TemplateScript $scripts
     * @return Layout
     */
    public function addScript(TemplateScript $scripts)
    {
        $scripts->setLayout($this);

        $this->scripts[] = $scripts;

        return $this;
    }

    /**
     * Remove scripts
     *
     * @param TemplateScript $scripts
     */
    public function removeScript(TemplateScript $scripts)
    {
        $this->scripts->removeElement($scripts);
    }

    /**
     * Get scripts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * Add styles
     *
     * @param TemplateStyle $styles
     * @return Layout
     */
    public function addStyle(TemplateStyle $styles)
    {
        $styles->setLayout($this);

        $this->styles[] = $styles;

        return $this;
    }

    /**
     * Remove styles
     *
     * @param TemplateStyle $styles
     */
    public function removeStyle(TemplateStyle $styles)
    {
        $this->styles->removeElement($styles);
    }

    /**
     * Get styles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStyles()
    {
        return $this->styles;
    }
}
