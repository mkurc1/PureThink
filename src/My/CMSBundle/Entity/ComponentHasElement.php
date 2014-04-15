<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="cms_component_has_element")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\ComponentHasElementRepository")
 */
class ComponentHasElement
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @ORM\ManyToOne(targetEntity="Component")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $component;

    /**
     * @ORM\OneToMany(targetEntity="ComponentHasValue", mappedBy="componentHasElement", cascade={"persist"})
     */
    private $componentHasValues;


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
     * @param \My\CMSBundle\Entity\ComponentHasValue $componentHasValues
     * @return ComponentHasElement
     */
    public function addComponentHasValue(\My\CMSBundle\Entity\ComponentHasValue $componentHasValues)
    {
        $this->componentHasValues[] = $componentHasValues;

        return $this;
    }

    /**
     * Remove componentHasValues
     *
     * @param \My\CMSBundle\Entity\ComponentHasValue $componentHasValues
     */
    public function removeComponentHasValue(\My\CMSBundle\Entity\ComponentHasValue $componentHasValues)
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
    public function __construct(Component $component = null)
    {
        $this->componentHasValues = new \Doctrine\Common\Collections\ArrayCollection();

        if ($component) {
            $this->setComponent($component);
        }
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
     * @param \My\CMSBundle\Entity\Component $component
     * @return ComponentHasElement
     */
    public function setComponent(\My\CMSBundle\Entity\Component $component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return \My\CMSBundle\Entity\Component 
     */
    public function getComponent()
    {
        return $this->component;
    }
}
