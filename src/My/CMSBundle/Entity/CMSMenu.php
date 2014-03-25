<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CMSMenu
 *
 * @ORM\Table(name="cms_menu")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSMenuRepository")
 */
class CMSMenu
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotNull()
     * @Assert\Length(max="128")
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sequence;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPublic = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isNewPage = false;

    /**
     * @ORM\ManyToOne(targetEntity="CMSMenu", inversedBy="menus")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity="CMSMenu", mappedBy="menu")
     */
    private $menus;

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
     * @ORM\ManyToOne(targetEntity="CMSArticle")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $article;


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
     * @return CMSMenu
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
     * Set sequence
     *
     * @param integer $sequence
     * @return CMSMenu
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return integer
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return CMSMenu
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
     * Constructor
     */
    public function __construct()
    {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set menu
     *
     * @param \My\CMSBundle\Entity\CMSMenu $menu
     * @return CMSMenu
     */
    public function setMenu(\My\CMSBundle\Entity\CMSMenu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \My\CMSBundle\Entity\CMSMenu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Add menus
     *
     * @param \My\CMSBundle\Entity\CMSMenu $menus
     * @return CMSMenu
     */
    public function addMenu(\My\CMSBundle\Entity\CMSMenu $menus)
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus
     *
     * @param \My\CMSBundle\Entity\CMSMenu $menus
     */
    public function removeMenu(\My\CMSBundle\Entity\CMSMenu $menus)
    {
        $this->menus->removeElement($menus);
    }

    /**
     * Get menus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return CMSMenu
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
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
     * Set language
     *
     * @param \My\CMSBundle\Entity\CMSLanguage $language
     * @return CMSMenu
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
     * @return CMSMenu
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
     * Set isNewPage
     *
     * @param boolean $isNewPage
     * @return CMSMenu
     */
    public function setIsNewPage($isNewPage)
    {
        $this->isNewPage = $isNewPage;

        return $this;
    }

    /**
     * Get isNewPage
     *
     * @return boolean
     */
    public function getIsNewPage()
    {
        return $this->isNewPage;
    }

    /**
     * Set article
     *
     * @param \My\CMSBundle\Entity\CMSArticle $article
     * @return CMSMenu
     */
    public function setArticle(\My\CMSBundle\Entity\CMSArticle $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \My\CMSBundle\Entity\CMSArticle
     */
    public function getArticle()
    {
        return $this->article;
    }
}
