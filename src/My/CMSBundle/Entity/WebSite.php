<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use My\AdminBundle\Entity\Metadata;
use My\AdminBundle\Entity\MetadataInterface;

/**
 * @ORM\Table(name="cms_website")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\WebSiteRepository")
 */
class WebSite implements MetadataInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $language;

    /**
     * @ORM\OneToOne(targetEntity="My\AdminBundle\Entity\Metadata", cascade={"persist"})
     */
    private $metadata;


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
     * @param \My\CMSBundle\Entity\Language $language
     * @return WebSite
     */
    public function setLanguage(\My\CMSBundle\Entity\Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \My\CMSBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set metadata
     *
     * @param \My\AdminBundle\Entity\Metadata $metadata
     * @return WebSite
     */
    public function setMetadata(\My\AdminBundle\Entity\Metadata $metadata = null)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return \My\AdminBundle\Entity\Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
