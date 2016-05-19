<?php

namespace AppBundle\Entity;

use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
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
    use Translatable;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @Gedmo\Slug(fields={"id"})
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $enabled = false;

    /**
     * @ORM\ManyToOne(targetEntity="Extension")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    protected $extension;

    /**
     * @ORM\OneToMany(targetEntity="ComponentHasElement", mappedBy="component", cascade={"persist"}, orphanRemoval=true)
     */
    protected $elements;

    protected $translations;

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        if ($this->getCurrentTranslation()) {
            return $this->getCurrentTranslation()->getName();
        }

        return null;
    }

    public function __toString()
    {
        if ($this->translations && $this->translations->count()) {
            return (string)$this->getName();
        }
        return '';
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
        $this->translations = new ArrayCollection();
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
