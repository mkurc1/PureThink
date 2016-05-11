<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;

/**
 * @ORM\Table(name="cms_site")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SiteRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Site implements SoftDeleteable
{
    use Translatable;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="tracking_code", nullable=true)
     */
    protected $trackingCode;

    protected $translations;


    public function __toString()
    {
        if ($this->translations && $this->translations->count()) {
            return (string)$this->getTitle();
        }
        return '';
    }

    public function getTitle()
    {
        return $this->getCurrentTranslation()->getTitle();
    }

    public function getDescription()
    {
        return $this->getCurrentTranslation()->getDescription();
    }

    public function getKeyword()
    {
        return $this->getCurrentTranslation()->getKeyword();
    }

    public function __construct()
    {
        $this->translations = new ArrayCollection();
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
     * @return string
     */
    public function getTrackingCode()
    {
        return $this->trackingCode;
    }

    /**
     * @param string $trackingCode
     */
    public function setTrackingCode($trackingCode)
    {
        $this->trackingCode = $trackingCode;
    }
}
