<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Translate
 *
 * @ORM\Table(name="translate")
 * @ORM\Entity
 */
class Translate
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="translate_name", type="string", length=255)
     */
    private $translateName;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $language;


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
     * @return Translate
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
     * Set translateName
     *
     * @param string $translateName
     * @return Translate
     */
    public function setTranslateName($translateName)
    {
        $this->translateName = $translateName;

        return $this;
    }

    /**
     * Get translateName
     *
     * @return string
     */
    public function getTranslateName()
    {
        return $this->translateName;
    }

    /**
     * Set language
     *
     * @param \My\BackendBundle\Entity\Language $language
     * @return Translate
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
}
