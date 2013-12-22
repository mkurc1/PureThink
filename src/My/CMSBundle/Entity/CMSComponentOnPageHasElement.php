<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CMSComponentOnPageHasElement
 *
 * @ORM\Table(name="cms_component_on_page_has_element")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSComponentOnPageHasElementRepository")
 */
class CMSComponentOnPageHasElement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponentOnPage", inversedBy="cmsComponentOnPageHasElements")
     * @ORM\JoinColumn(name="component_on_page_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $componentOnPage;

    /**
     * @ORM\OneToMany(targetEntity="CMSComponentOnPageHasValue", mappedBy="cmsComponentOnPageHasElement", cascade={"all"})
     */
    protected $componentOnPagesHasValues;


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
     * Add componentOnPagesHasValues
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPageHasValue $componentOnPagesHasValues
     * @return CMSComponentOnPageHasElement
     */
    public function addComponentOnPagesHasValue(\My\CMSBundle\Entity\CMSComponentOnPageHasValue $componentOnPagesHasValues)
    {
        $this->componentOnPagesHasValues[] = $componentOnPagesHasValues;

        return $this;
    }

    /**
     * Remove componentOnPagesHasValues
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPageHasValue $componentOnPagesHasValues
     */
    public function removeComponentOnPagesHasValue(\My\CMSBundle\Entity\CMSComponentOnPageHasValue $componentOnPagesHasValues)
    {
        $this->componentOnPagesHasValues->removeElement($componentOnPagesHasValues);
    }

    /**
     * Get componentOnPagesHasValues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComponentOnPagesHasValues()
    {
        return $this->componentOnPagesHasValues;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->componentOnPagesHasValues = new \Doctrine\Common\Collections\ArrayCollection();
    }

}