<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="cms_menu")
 * @ORM\Entity(repositoryClass="Purethink\CMSBundle\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotNull()
     * @Assert\Length(max="128")
     */
    private $name;

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
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menus")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="menu")
     */
    private $menus;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="MenuType")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Article")
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
     * @return Menu
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
     * @return Menu
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
     * Constructor
     */
    public function __construct()
    {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set menu
     *
     * @param \Purethink\CMSBundle\Entity\Menu $menu
     * @return Menu
     */
    public function setMenu(\Purethink\CMSBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Purethink\CMSBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Add menus
     *
     * @param \Purethink\CMSBundle\Entity\Menu $menus
     * @return Menu
     */
    public function addMenu(\Purethink\CMSBundle\Entity\Menu $menus)
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus
     *
     * @param \Purethink\CMSBundle\Entity\Menu $menus
     */
    public function removeMenu(\Purethink\CMSBundle\Entity\Menu $menus)
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
     * @return Menu
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
        return (string)$this->getName();
    }

    /**
     * Set language
     *
     * @param \Purethink\CMSBundle\Entity\Language $language
     * @return Menu
     */
    public function setLanguage(\Purethink\CMSBundle\Entity\Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Purethink\CMSBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set isNewPage
     *
     * @param boolean $isNewPage
     * @return Menu
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
     * @param \Purethink\CMSBundle\Entity\Article $article
     * @return Menu
     */
    public function setArticle(\Purethink\CMSBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Purethink\CMSBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set type
     *
     * @param \Purethink\CMSBundle\Entity\MenuType $type
     * @return Menu
     */
    public function setType(\Purethink\CMSBundle\Entity\MenuType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Purethink\CMSBundle\Entity\MenuType 
     */
    public function getType()
    {
        return $this->type;
    }
}
