<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class ComponentHasFile extends ComponentHasValue
{
    /**
     * @ORM\ManyToOne(targetEntity="My\FileBundle\Entity\File", inversedBy="componentHasFile", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $file;


    public function setContent($content)
    {
        $this->setFile($content);

        return $this;
    }

    public function getContent()
    {
        return $this->getFile();
    }

    public function getStringContent()
    {
        return $this->getContent()->getPath();
    }

    /**
     * Set file
     *
     * @param \My\FileBundle\Entity\File $file
     * @return ComponentHasFile
     */
    public function setFile(\My\FileBundle\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \My\FileBundle\Entity\File 
     */
    public function getFile()
    {
        return $this->file;
    }
}
