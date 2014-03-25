<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CMSComponentOnPageHasElement
 *
 * @ORM\Table(name="cms_component_on_page_has_element")
 * @ORM\Entity
 */
class CMSComponentOnPageHasElement
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
     * @ORM\ManyToOne(targetEntity="CMSComponentOnPage")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $componentOnPage;

    /**
     * @ORM\OneToMany(targetEntity="CMSComponentOnPageHasValue", mappedBy="cmsComponentOnPageHasElement", cascade={"persist"})
     */
    private $componentOnPageHasValues;


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
     * @return CMSComponentOnPageHasElement
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
     * @return CMSComponentOnPageHasElement
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
     * Set componentOnPage
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPage $componentOnPage
     * @return CMSComponentOnPageHasElement
     */
    public function setComponentOnPage(\My\CMSBundle\Entity\CMSComponentOnPage $componentOnPage)
    {
        $this->componentOnPage = $componentOnPage;

        return $this;
    }

    /**
     * Get componentOnPage
     *
     * @return \My\CMSBundle\Entity\CMSComponentOnPage
     */
    public function getComponentOnPage()
    {
        return $this->componentOnPage;
    }

    /**
     * Add componentOnPageHasValues
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPageHasValue $componentOnPageHasValues
     * @return CMSComponentOnPageHasElement
     */
    public function addComponentOnPageHasValue(\My\CMSBundle\Entity\CMSComponentOnPageHasValue $componentOnPageHasValues)
    {
        $this->componentOnPageHasValues[] = $componentOnPageHasValues;

        return $this;
    }

    /**
     * Remove componentOnPageHasValues
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPageHasValue $componentOnPageHasValues
     */
    public function removeComponentOnPageHasValue(\My\CMSBundle\Entity\CMSComponentOnPageHasValue $componentOnPageHasValues)
    {
        $this->componentOnPageHasValues->removeElement($componentOnPageHasValues);
    }

    /**
     * Get componentOnPageHasValues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComponentOnPageHasValues()
    {
        return $this->componentOnPageHasValues;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->componentOnPageHasValues = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set isEnable
     *
     * @param boolean $isEnable
     * @return CMSComponentOnPageHasElement
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
}
