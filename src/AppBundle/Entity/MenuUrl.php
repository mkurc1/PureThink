<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MenuUrlRepository")
 * @ORM\Table
 */
class MenuUrl extends Menu
{
    /**
     * @var string
     *
     * @Assert\Url()
     * @ORM\Column(type="string")
     */
    protected $url;


    public function getTypeOf()
    {
        return self::TYPE_OF_URL;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return MenuUrl
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}