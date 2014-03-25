<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CMSComponentOnPage
 *
 * @ORM\Table(name="cms_component_on_page")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSComponentOnPageRepository")
 */
class CMSComponentOnPage
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

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
     * @ORM\ManyToOne(targetEntity="CMSLanguage")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="My\BackendBundle\Entity\Series")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $series;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponent")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $component;


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

}
