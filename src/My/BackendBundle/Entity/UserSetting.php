<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSetting
 *
 * @ORM\Table()
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
