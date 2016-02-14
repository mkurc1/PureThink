<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="cms_site")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SiteRepository")
 */
class Site implements MetadataInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $language;

    /**
     * @ORM\OneToOne(targetEntity="Metadata", cascade={"persist"})
     */
    private $metadata;


    public function __toString()
    {
        return (string)$this->getSEOData()->getTitle();
    }

    public function __construct()
    {
        $this->setMetadata(new Metadata());
    }

    public function getSEOData()
    {
        return $this->getMetadata();
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
     * @param Language $language
     * @return Site
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set metadata
     *
     * @param Metadata $metadata
     * @return Site
     */
    public function setMetadata(Metadata $metadata = null)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
