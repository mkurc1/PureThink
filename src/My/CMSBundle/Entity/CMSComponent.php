<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CMSComponent
 *
 * @ORM\Table(name="cms_component")
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
     *
     * @Assert\NotNull()
     * @Assert\Length(max="255")
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
     * @ORM\ManyToOne(targetEntity="My\BackendBundle\Entity\Series")
     * @ORM\JoinColumn(name="series_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $series;

    /**
     * @ORM\OneToMany(targetEntity="CMSComponentHasColumn", mappedBy="cmsComponent")
     */
    private $cmsComponentHasColumns;

    /**
     * @ORM\OneToMany(targetEntity="CMSComponentOnPage", mappedBy="cmsComponent")
     */
    private $cmsComponentOnPages;


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
     * Add cmsComponentHasColumns
     *
     * @param \My\CMSBundle\Entity\CMSComponentHasColumn $cmsComponentHasColumns
     * @return CMSComponent
     */
    public function addCmsComponentHasColumn(\My\CMSBundle\Entity\CMSComponentHasColumn $cmsComponentHasColumns)
    {
        $this->cmsComponentHasColumns[] = $cmsComponentHasColumns;

        return $this;
    }

    /**
     * Remove cmsComponentHasColumns
     *
     * @param \My\CMSBundle\Entity\CMSComponentHasColumn $cmsComponentHasColumns
     */
    public function removeCmsComponentHasColumn(\My\CMSBundle\Entity\CMSComponentHasColumn $cmsComponentHasColumns)
    {
        $this->cmsComponentHasColumns->removeElement($cmsComponentHasColumns);
    }

    /**
     * Get cmsComponentHasColumns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsComponentHasColumns()
    {
        return $this->cmsComponentHasColumns;
    }

    /**
     * Add cmsComponentOnPages
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPage $cmsComponentOnPages
     * @return CMSComponent
     */
    public function addCmsComponentOnPage(\My\CMSBundle\Entity\CMSComponentOnPage $cmsComponentOnPages)
    {
        $this->cmsComponentOnPages[] = $cmsComponentOnPages;

        return $this;
    }

    /**
     * Remove cmsComponentOnPages
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPage $cmsComponentOnPages
     */
    public function removeCmsComponentOnPage(\My\CMSBundle\Entity\CMSComponentOnPage $cmsComponentOnPages)
    {
        $this->cmsComponentOnPages->removeElement($cmsComponentOnPages);
    }

    /**
     * Get cmsComponentOnPages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsComponentOnPages()
    {
        return $this->cmsComponentOnPages;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cmsComponentHasColumns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cmsComponentOnPages = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
