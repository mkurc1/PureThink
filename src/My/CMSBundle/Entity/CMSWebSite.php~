<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMSWebSite
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CMSWebSite
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=255)
     */
    private $keywords;

    /**
     * @ORM\OneToOne(targetEntity="CMSLanguage")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id", nullable=false)
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
     * @return CMSWebSite
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
     * Set description
     *
     * @param string $description
     * @return CMSWebSite
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return CMSWebSite
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set language
     *
     * @param \My\CMSBundle\Entity\CMSLanguage $language
     * @return CMSWebSite
     */
    public function setLanguage(\My\CMSBundle\Entity\CMSLanguage $language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return \My\CMSBundle\Entity\CMSLanguage 
     */
    public function getLanguage()
    {
        return $this->language;
    }
}