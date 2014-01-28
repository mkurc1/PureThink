<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * My\BackendBundle\Entity\Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="My\BackendBundle\Repository\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var integer
     *
     * @ORM\Column(name="sequence", type="integer")
     */
    private $sequence;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menus")
     */
    protected $menu;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="menu")
     */
    protected $menus;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="menus")
     */
    protected $module;

    /**
     * @ORM\OneToMany(targetEntity="Series", mappedBy="menu")
     */
    protected $series;


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
     * @param \My\BackendBundle\Entity\Menu $menus
     * @return Menu
     */
    public function addMenu(\My\BackendBundle\Entity\Menu $menus)
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus
     *
     * @param \My\BackendBundle\Entity\Menu $menus
     */
    public function removeMenu(\My\BackendBundle\Entity\Menu $menus)
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
     * @param \My\BackendBundle\Entity\Menu $menu
     * @return Menu
     */
    public function setMenu(\My\BackendBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \My\BackendBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set module
     *
     * @param \My\BackendBundle\Entity\Module $module
     * @return Menu
     */
    public function setModule(\My\BackendBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \My\BackendBundle\Entity\Module
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

    /**
     * Add series
     *
     * @param \My\BackendBundle\Entity\Series $series
     * @return Menu
     */
    public function addSerie(\My\BackendBundle\Entity\Series $series)
    {
        $this->series[] = $series;

        return $this;
    }

    /**
     * Remove series
     *
     * @param \My\BackendBundle\Entity\Series $series
     */
    public function removeSerie(\My\BackendBundle\Entity\Series $series)
    {
        $this->series->removeElement($series);
    }

    /**
     * Get series
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Add series
     *
     * @param \My\BackendBundle\Entity\Series $series
     * @return Menu
     */
    public function addSeries(\My\BackendBundle\Entity\Series $series)
    {
        $this->series[] = $series;

        return $this;
    }

    /**
     * Remove series
     *
     * @param \My\BackendBundle\Entity\Series $series
     */
    public function removeSeries(\My\BackendBundle\Entity\Series $series)
    {
        $this->series->removeElement($series);
    }
}
