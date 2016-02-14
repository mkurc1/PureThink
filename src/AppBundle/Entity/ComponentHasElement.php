<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Table(name="cms_component_has_element")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComponentHasElementRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class ComponentHasElement implements SoftDeleteable
{
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled = false;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Component", inversedBy="elements")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $component;

    /**
     * @ORM\OneToMany(targetEntity="ComponentHasValue", mappedBy="componentHasElement", cascade={"persist"})
     */
    private $componentHasValues;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;


    public function __toString()
    {
        return (string)$this->getTitle();
    }

    public function getTitle()
    {
        /** @var ComponentHasValue $value */
        foreach ($this->getComponentHasValues() as $value) {
            if ($value->getExtensionHasField()->getIsMainField()) {
                return $value;
            }
        }

        return '';
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
     * Add componentHasValues
     *
     * @param ComponentHasValue $componentHasValues
     * @return ComponentHasElement
     */
    public function addComponentHasValue(ComponentHasValue $componentHasValues)
    {
        $componentHasValues->setComponentHasElement($this);

        $this->componentHasValues[] = $componentHasValues;

        return $this;
    }

    /**
     * Remove componentHasValues
     *
     * @param ComponentHasValue $componentHasValues
     */
    public function removeComponentHasValue(ComponentHasValue $componentHasValues)
    {
        $this->componentHasValues->removeElement($componentHasValues);
    }

    /**
     * Get componentHasValues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComponentHasValues()
    {
        return $this->componentHasValues;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->componentHasValues = new ArrayCollection();
    }

    /**
     * Set component
     *
     * @param Component $component
     * @return ComponentHasElement
     */
    public function setComponent(Component $component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return Component
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return ComponentHasElement
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return ComponentHasElement
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
