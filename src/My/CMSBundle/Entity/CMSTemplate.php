<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CMSTemplate
 *
 * @ORM\Table(name="cms_template")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSTemplateRepository")
 */
class CMSTemplate
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
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_enable", type="boolean")
     */
    private $isEnable;

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
     * @ORM\OneToMany(targetEntity="CMSCSS", mappedBy="cmsTemplate")
     */
    protected $cmsCSSs;

    /**
     * @ORM\OneToMany(targetEntity="CMSJS", mappedBy="cmsTemplate")
     */
    protected $cmsJSs;

    /**
     * @ORM\OneToMany(targetEntity="CMSLayout", mappedBy="cmsTemplate")
     */
    protected $cmsLayouts;


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
     * @return CMSTemplate
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
     * Set author
     *
     * @param string $author
     * @return CMSTemplate
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set isEnable
     *
     * @param boolean $isEnable
     * @return CMSTemplate
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
     * Get name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cmsCSSs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cmsJSs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cmsLayouts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isEnable = false;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CMSTemplate
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
     * @return CMSTemplate
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
     * Add cmsCSSs
     *
     * @param \My\CMSBundle\Entity\CMSCSS $cmsCSSs
     * @return CMSTemplate
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
     * @return CMSTemplate
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

    /**
     * Add cmsLayouts
     *
     * @param \My\CMSBundle\Entity\CMSLayout $cmsLayouts
     * @return CMSTemplate
     */
    public function addCmsLayout(\My\CMSBundle\Entity\CMSLayout $cmsLayouts)
    {
        $this->cmsLayouts[] = $cmsLayouts;

        return $this;
    }

    /**
     * Remove cmsLayouts
     *
     * @param \My\CMSBundle\Entity\CMSLayout $cmsLayouts
     */
    public function removeCmsLayout(\My\CMSBundle\Entity\CMSLayout $cmsLayouts)
    {
        $this->cmsLayouts->removeElement($cmsLayouts);
    }

    /**
     * Get cmsLayouts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsLayouts()
    {
        return $this->cmsLayouts;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return CMSTemplate
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
}