<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="cms_component_has_element")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComponentHasElementRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class ComponentHasElement
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

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
     * Set created
     *
     * @param \DateTime $created
     * @return ComponentHasElement
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

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return ComponentHasElement
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
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

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
}
