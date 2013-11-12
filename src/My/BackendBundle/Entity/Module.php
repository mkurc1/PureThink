<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Module
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
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_default", type="boolean")
     */
    private $isDefault;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="module")
     */
    protected $menus;

    /**
     * @ORM\OneToMany(targetEntity="UserSetting", mappedBy="module")
     */
    protected $userSettings;

    /**
     * @ORM\OneToMany(targetEntity="Series", mappedBy="module")
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
     * @return Module
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
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return Module
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->isDefault;
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
     * @return Module
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
     * Get name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add userSettings
     *
     * @param \My\BackendBundle\Entity\UserSetting $userSettings
     * @return Module
     */
    public function addUserSetting(\My\BackendBundle\Entity\UserSetting $userSettings)
    {
        $this->userSettings[] = $userSettings;

        return $this;
    }

    /**
     * Remove userSettings
     *
     * @param \My\BackendBundle\Entity\UserSetting $userSettings
     */
    public function removeUserSetting(\My\BackendBundle\Entity\UserSetting $userSettings)
    {
        $this->userSettings->removeElement($userSettings);
    }

    /**
     * Get userSettings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserSettings()
    {
        return $this->userSettings;
    }

    /**
     * Add series
     *
     * @param \My\BackendBundle\Entity\Series $series
     * @return Module
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
}