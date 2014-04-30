<?php

namespace Purethink\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSetting
 *
 * @ORM\Table(name="user_setting")
 * @ORM\Entity
 */
class UserSetting
{
    private static $avilableCountRowsOnPage = [
                                              1 => 10,
                                              2 => 20,
                                              3 => 50,
                                              4 => 100
                                             ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rowsOnPage;

    /**
     * @ORM\ManyToOne(targetEntity="Purethink\AdminBundle\Entity\Language")
     * @ORM\JoinColumn(nullable=true)
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="Purethink\AdminBundle\Entity\Module")
     * @ORM\JoinColumn(nullable=true)
     */
    private $module;


    public static function getAvilableCountRowsOnPage()
    {
        return self::$avilableCountRowsOnPage;
    }

    public function setRowsOnPageByValue($value)
    {
        foreach (self::getAvilableCountRowsOnPage() as $key => $row) {
            if ($value == $row) {
                return $this->setRowsOnPage($key);
            }
        }
    }

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
     * Set language
     *
     * @param \Purethink\AdminBundle\Entity\Language $language
     * @return UserSetting
     */
    public function setLanguage(\Purethink\AdminBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Purethink\AdminBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set module
     *
     * @param \Purethink\AdminBundle\Entity\Module $module
     * @return UserSetting
     */
    public function setModule(\Purethink\AdminBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \Purethink\AdminBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set rowsOnPage
     *
     * @param integer $rowsOnPage
     * @return UserSetting
     */
    public function setRowsOnPage($rowsOnPage)
    {
        $this->rowsOnPage = $rowsOnPage;

        return $this;
    }

    /**
     * Get rowsOnPage
     *
     * @return integer
     */
    public function getRowsOnPage()
    {
        return $this->rowsOnPage;
    }
}
