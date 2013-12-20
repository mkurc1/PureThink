<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RowsOnPage
 *
 * @ORM\Table(name="rows_on_page")
 * @ORM\Entity
 */
class RowsOnPage
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
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_default", type="boolean")
     */
    private $isDefault;

    /**
     * @ORM\OneToMany(targetEntity="UserSetting", mappedBy="rowsOnPage")
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
     * Set amount
     *
     * @param integer $amount
     * @return RowsOnPage
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return RowsOnPage
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
        $this->userSettings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add userSettings
     *
     * @param \My\BackendBundle\Entity\UserSetting $userSettings
     * @return RowsOnPage
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