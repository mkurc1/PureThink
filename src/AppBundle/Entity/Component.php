<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="cms_component")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Component implements SoftDeleteable
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled = false;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="Extension")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $extension;

    /**
     * @ORM\OneToMany(targetEntity="ComponentHasElement", mappedBy="component", cascade={"persist"}, orphanRemoval=true)
     */
    private $elements;


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
     * @return Component
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
     * @return Component
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
     * Set language
     *
     * @param Language $language
     * @return Component
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set extension
     *
     * @param Extension $extension
     * @return Component
     */
    public function setExtension(Extension $extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return Extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elements = new ArrayCollection();
    }

    /**
     * Add elements
     *
     * @param ComponentHasElement $elements
     * @return Component
     */
    public function addElement(ComponentHasElement $elements)
    {
        $elements->setComponent($this);

        $this->elements[] = $elements;

        return $this;
    }

    /**
     * Remove elements
     *
     * @param ComponentHasElement $elements
     */
    public function removeElement(ComponentHasElement $elements)
    {
        $this->elements->removeElement($elements);
    }

    /**
     * Get elements
     *
     * @return Collection
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Component
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
}
