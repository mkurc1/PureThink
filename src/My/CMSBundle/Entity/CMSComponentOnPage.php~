<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CMSComponentOnPage
 *
 * @ORM\Table(name="cms_component_on_page")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSComponentOnPageRepository")
 */
class CMSComponentOnPage
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

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
     * @var boolean
     *
     * @ORM\Column(name="is_enable", type="boolean", nullable=true)
     */
    private $isEnable;

    /**
     * @ORM\ManyToOne(targetEntity="CMSLanguage", inversedBy="cmsComponentOnPages")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $language;

    /**
     * @ORM\ManyToOne(targetEntity="My\BackendBundle\Entity\Series", inversedBy="cmsComponentOnPages")
     * @ORM\JoinColumn(name="series_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $series;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponent", inversedBy="cmsComponentOnPages")
     * @ORM\JoinColumn(name="component_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $component;

    /**
     * @ORM\OneToMany(targetEntity="CMSComponentOnPageHasElement", mappedBy="cmsComponentOnPages")
     */
    protected $componentOnPagesHasElements;


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
     * @return CMSComponentOnPage
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
        return $this->getName();
    }

    /**
     * Set isEnable
     *
     * @param boolean $isEnable
     * @return CMSComponentOnPage
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
     * Set slug
     *
     * @param string $slug
     * @return CMSComponentOnPage
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CMSComponentOnPage
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
     * @return CMSComponentOnPage
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
     * Set language
     *
     * @param \My\CMSBundle\Entity\CMSLanguage $language
     * @return CMSComponentOnPage
     */
    public function setLanguage(\My\CMSBundle\Entity\CMSLanguage $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \My\CMSBundle\Entity\CMSLanguage
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set series
     *
     * @param \My\BackendBundle\Entity\Series $series
     * @return CMSComponentOnPage
     */
    public function setSeries(\My\BackendBundle\Entity\Series $series)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Get series
     *
     * @return \My\BackendBundle\Entity\Series
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Set component
     *
     * @param \My\CMSBundle\Entity\CMSComponent $component
     * @return CMSComponentOnPage
     */
    public function setComponent(\My\CMSBundle\Entity\CMSComponent $component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return \My\CMSBundle\Entity\CMSComponent
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->componentOnPagesHasElements = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add componentOnPagesHasElements
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPageHasElement $componentOnPagesHasElements
     * @return CMSComponentOnPage
     */
    public function addComponentOnPagesHasElement(\My\CMSBundle\Entity\CMSComponentOnPageHasElement $componentOnPagesHasElements)
    {
        $this->componentOnPagesHasElements[] = $componentOnPagesHasElements;
    
        return $this;
    }

    /**
     * Remove componentOnPagesHasElements
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPageHasElement $componentOnPagesHasElements
     */
    public function removeComponentOnPagesHasElement(\My\CMSBundle\Entity\CMSComponentOnPageHasElement $componentOnPagesHasElements)
    {
        $this->componentOnPagesHasElements->removeElement($componentOnPagesHasElements);
    }

    /**
     * Get componentOnPagesHasElements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComponentOnPagesHasElements()
    {
        return $this->componentOnPagesHasElements;
    }
}