<?php

namespace My\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\OneToOne(targetEntity="UserSetting", cascade={"persist"})
     */
    private $userSetting;


    public function __construct()
    {
        parent::__construct();

        $this->setUserSetting(new UserSetting());
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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }


    /**
     * Set userSetting
     *
     * @param \My\UserBundle\Entity\UserSetting $userSetting
     * @return User
     */
    public function setUserSetting(\My\UserBundle\Entity\UserSetting $userSetting = null)
    {
        $this->userSetting = $userSetting;

        return $this;
    }

    /**
     * Get userSetting
     *
     * @return \My\UserBundle\Entity\UserSetting
     */
    public function getUserSetting()
    {
        return $this->userSetting;
    }
}
