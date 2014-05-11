<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="cms_component_has_element")
 * @ORM\Entity(repositoryClass="Purethink\CMSBundle\Repository\ComponentHasElementRepository")
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
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isEnable = false;

    /**
     * @ORM\ManyToOne(targetEntity="Component", inversedBy="elements")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $component;

    /**
     * @ORM\OneToMany(targetEntity="ComponentHasValue", mappedBy="componentHasElement", cascade={"persist"})
     */
    private $componentHasValues;


    public function __toString()
    {
        return (string)$this->getTitle();
    }

    public function getTitle()
    {
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ComponentHasElement
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return ComponentHasElement
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add componentHasValues
     *
     * @param \Purethink\CMSBundle\Entity\ComponentHasValue $componentHasValues
     * @return ComponentHasElement
     */
    public function addComponentHasValue(\Purethink\CMSBundle\Entity\ComponentHasValue $componentHasValues)
    {
        $componentHasValues->setComponentHasElement($this);

        $this->componentHasValues[] = $componentHasValues;

        return $this;
    }

    /**
     * Remove componentHasValues
     *
     * @param \Purethink\CMSBundle\Entity\ComponentHasValue $componentHasValues
     */
    public function removeComponentHasValue(\Purethink\CMSBundle\Entity\ComponentHasValue $componentHasValues)
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
        $this->componentHasValues = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set isEnable
     *
     * @param boolean $isEnable
     * @return ComponentHasElement
     */
    public function setIsEnable($isEnable)
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    /**
     * Get isEnable
     *
     * @return boolean
     */
    public function getIsEnable()
    {
        return $this->isEnable;
    }

    /**
     * Set component
     *
     * @param \Purethink\CMSBundle\Entity\Component $component
     * @return ComponentHasElement
     */
    public function setComponent(\Purethink\CMSBundle\Entity\Component $component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return \Purethink\CMSBundle\Entity\Component
     */
    public function getComponent()
    {
        return $this->component;
    }
}