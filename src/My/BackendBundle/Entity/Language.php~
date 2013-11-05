<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Language
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
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=3)
     */
    private $alias;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean")
     */
    private $isPublic;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_default", type="boolean")
     */
    private $isDefault;

    /**
     * @ORM\OneToMany(targetEntity="Translate", mappedBy="language")
     */
    protected $translates;

    /**
     * @ORM\OneToMany(targetEntity="UserSetting", mappedBy="language")
     */
    protected $userSettings;


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
     * @return Language
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
     * Set alias
     *
     * @param string $alias
     * @return Language
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Language
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
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return Language
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
        $this->translates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add translates
     *
     * @param \My\BackendBundle\Entity\Translate $translates
     * @return Language
     */
    public function addTranslate(\My\BackendBundle\Entity\Translate $translates)
    {
        $this->translates[] = $translates;

        return $this;
    }

    /**
     * Remove translates
     *
     * @param \My\BackendBundle\Entity\Translate $translates
     */
    public function removeTranslate(\My\BackendBundle\Entity\Translate $translates)
    {
        $this->translates->removeElement($translates);
    }

    /**
     * Get translates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslates()
    {
        return $this->translates;
    }

    /**
     * Add userSettings
     *
     * @param \My\BackendBundle\Entity\UserSetting $userSettings
     * @return Language
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
}