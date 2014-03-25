<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="cms_template")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\TemplateRepository")
 */
class Template
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isEnable = false;

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
     * @ORM\OneToMany(targetEntity="Layout", mappedBy="Template")
     */
    private $cmsLayouts;


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
     * @return Template
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
     * @return Template
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
     * @return Template
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
        $this->cmsLayouts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Template
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
     * @return Template
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
     * Add cmsLayouts
     *
     * @param \My\CMSBundle\Entity\Layout $cmsLayouts
     * @return Template
     */
    public function addCmsLayout(\My\CMSBundle\Entity\Layout $cmsLayouts)
    {
        $this->cmsLayouts[] = $cmsLayouts;

        return $this;
    }

    /**
     * Remove cmsLayouts
     *
     * @param \My\CMSBundle\Entity\Layout $cmsLayouts
     */
    public function removeCmsLayout(\My\CMSBundle\Entity\Layout $cmsLayouts)
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
     * @return Template
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
