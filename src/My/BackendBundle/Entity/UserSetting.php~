<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSetting
 *
 * @ORM\Table(name="user_setting")
 * @ORM\Entity
 */
class UserSetting
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
     * @ORM\ManyToOne(targetEntity="RowsOnPage", inversedBy="userSettings")
     */
    protected $rowsOnPage;

    /**
     * @ORM\OneToOne(targetEntity="My\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="userSettings")
     */
    protected $language;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="userSettings")
     */
    protected $module;


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
     * Set rowsOnPage
     *
     * @param \My\BackendBundle\Entity\RowsOnPage $rowsOnPage
     * @return UserSetting
     */
    public function setRowsOnPage(\My\BackendBundle\Entity\RowsOnPage $rowsOnPage = null)
    {
        $this->rowsOnPage = $rowsOnPage;

        return $this;
    }

    /**
     * Get rowsOnPage
     *
     * @return \My\BackendBundle\Entity\RowsOnPage
     */
    public function getRowsOnPage()
    {
        return $this->rowsOnPage;
    }

    /**
     * Set user
     *
     * @param \My\UserBundle\Entity\User $user
     * @return UserSetting
     */
    public function setUser(\My\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \My\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set language
     *
     * @param \My\BackendBundle\Entity\Language $language
     * @return UserSetting
     */
    public function setLanguage(\My\BackendBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \My\BackendBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set module
     *
     * @param \My\BackendBundle\Entity\Module $module
     * @return UserSetting
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
}
