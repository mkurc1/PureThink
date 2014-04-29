<?php

namespace My\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * My\AdminBundle\Entity\Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="My\AdminBundle\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequence;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menus")
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="menu")
     */
    private $menus;

    /**
     * @ORM\ManyToOne(targetEntity="Module")
     */
    private $module;


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
     * Set link
     *
     * @param string $link
     * @return Menu
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
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
     * Add menus
     *
     * @param \My\AdminBundle\Entity\Menu $menus
     * @return Menu
     */
    public function addMenu(\My\AdminBundle\Entity\Menu $menus)
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus
     *
     * @param \My\AdminBundle\Entity\Menu $menus
     */
    public function removeMenu(\My\AdminBundle\Entity\Menu $menus)
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
     * Set menu
     *
     * @param \My\AdminBundle\Entity\Menu $menu
     * @return Menu
     */
    public function setMenu(\My\AdminBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \My\AdminBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set module
     *
     * @param \My\AdminBundle\Entity\Module $module
     * @return Menu
     */
    public function setModule(\My\AdminBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \My\AdminBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
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
}