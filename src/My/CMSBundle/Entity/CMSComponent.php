<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CMSComponent
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSComponentRepository")
 */
class CMSComponent
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
     * @ORM\ManyToOne(targetEntity="My\BackendBundle\Entity\Series", inversedBy="cmsComponents")
     * @ORM\JoinColumn(name="series_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $series;

    /**
     * @ORM\OneToMany(targetEntity="CMSCSS", mappedBy="cmsComponent")
     */
    protected $cmsCSSs;

    /**
     * @ORM\OneToMany(targetEntity="CMSJS", mappedBy="cmsComponent")
     */
    protected $cmsJSs;


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
     * @return CMSComponent
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CMSComponent
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
     * @return CMSComponent
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
     * Set series
     *
     * @param \My\BackendBundle\Entity\Series $series
     * @return CMSComponent
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
     * Constructor
     */
    public function __construct()
    {
        $this->cmsCSSs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cmsJSs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cmsCSSs
     *
     * @param \My\CMSBundle\Entity\CMSCSS $cmsCSSs
     * @return CMSComponent
     */
    public function addCmsCSS(\My\CMSBundle\Entity\CMSCSS $cmsCSSs)
    {
        $this->cmsCSSs[] = $cmsCSSs;

        return $this;
    }

    /**
     * Remove cmsCSSs
     *
     * @param \My\CMSBundle\Entity\CMSCSS $cmsCSSs
     */
    public function removeCmsCSS(\My\CMSBundle\Entity\CMSCSS $cmsCSSs)
    {
        $this->cmsCSSs->removeElement($cmsCSSs);
    }

    /**
     * Get cmsCSSs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsCSSs()
    {
        return $this->cmsCSSs;
    }

    /**
     * Add cmsJSs
     *
     * @param \My\CMSBundle\Entity\CMSJS $cmsJSs
     * @return CMSComponent
     */
    public function addCmsJS(\My\CMSBundle\Entity\CMSJS $cmsJSs)
    {
        $this->cmsJSs[] = $cmsJSs;

        return $this;
    }

    /**
     * Remove cmsJSs
     *
     * @param \My\CMSBundle\Entity\CMSJS $cmsJSs
     */
    public function removeCmsJS(\My\CMSBundle\Entity\CMSJS $cmsJSs)
    {
        $this->cmsJSs->removeElement($cmsJSs);
    }

    /**
     * Get cmsJSs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsJSs()
    {
        return $this->cmsJSs;
    }
}