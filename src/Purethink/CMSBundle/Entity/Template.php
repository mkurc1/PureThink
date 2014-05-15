<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="cms_template")
 * @ORM\Entity(repositoryClass="Purethink\CMSBundle\Repository\TemplateRepository")
 */
class Template
{
    const BUNDLE_NAME = 'PurethinkCMSBundle';
    const ASSET_DIRECTOR_NAME = 'template';
    const SCRIPT_DIRECTOR_NAME = 'Template';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $icon;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled = false;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\OneToMany(targetEntity="TemplateScript", mappedBy="template", cascade={"persist"}, orphanRemoval=true)
     */
    private $scripts;

    /**
     * @ORM\OneToMany(targetEntity="TemplateStyle", mappedBy="template", cascade={"persist"}, orphanRemoval=true)
     */
    private $styles;


    public function getScriptPath()
    {
        return self::BUNDLE_NAME . ':' . self::SCRIPT_DIRECTOR_NAME . DIRECTORY_SEPARATOR . $this->getSlug();
    }

    public function getAssetPath()
    {
        return self::ASSET_DIRECTOR_NAME . DIRECTORY_SEPARATOR . $this->getSlug();
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
     * Set name
     *
     * @param string $name
     * @return Template
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Template
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getName();
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Template
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
     * @return Template
     */
    public function addScript(TemplateScript $scripts)
    {
        $scripts->setTemplate($this);
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
     * @return Template
     */
    public function addStyle(TemplateStyle $styles)
    {
        $styles->setTemplate($this);
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

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Template
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return Template
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Template
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
}
