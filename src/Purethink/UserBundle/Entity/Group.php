<?php

namespace Purethink\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct($name = null, $roles = [])
    {
        $this->name = $name;
        $this->roles = $roles;
    }

    public function __toString()
    {
        return (string)$this->getName();
    }
}
