<?php

namespace My\FileBundle\Entity;

use My\CoreBundle\Entity\File as BaseFile;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use My\UserBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="My\FileBundle\Repository\FileRepository")
 * @ORM\HasLifecycleCallbacks
 */
class File extends BaseFile
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mimeType;

    /**
     * @ORM\ManyToOne(targetEntity="My\UserBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="My\BackendBundle\Entity\Series")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $series;

    /**
     * @ORM\OneToMany(targetEntity="My\CMSBundle\Entity\ComponentHasFile", mappedBy="file")
     */
    private $componentHasFile;

    /**
     * @ORM\PreRemove
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        foreach ($this->getComponentHasFile() as $component) {
            $element = $component->getComponentHasElement();

            $om = $args->getObjectManager();
            $om->remove($element);
            $om->flush();
        }
    }

    public function __construct(User $user = null)
    {
        $this->componentHasFile = new \Doctrine\Common\Collections\ArrayCollection();
        if (null != $user) {
            $this->setUser($user);
        }
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
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
     * Set size
     *
     * @param integer $size
     * @return File
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return File
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param \My\UserBundle\Entity\User $user
     * @return File
     */
    public function setUser(\My\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \My\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set series
     *
     * @param \My\BackendBundle\Entity\Series $series
     * @return File
     */
    public function setSeries(\My\BackendBundle\Entity\Series $series)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Get series
     *
     * @return \My\BackendBundle\Entity\Series
     */
    public function getSeries()
    {
        return $this->series;
    }

    protected function getUploadDir()
    {
        return 'uploads';
    }

    /**
     * Get name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Pre upload
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->setPath($filename.'.'.$this->getFile()->guessExtension());
            $this->size = $this->getFile()->getClientSize();
            $this->mimeType = $this->getFile()->getMimeType();
        }
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return File
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Add componentHasFile
     *
     * @param \My\CMSBundle\Entity\ComponentHasFile $componentHasFile
     * @return File
     */
    public function addComponentHasFile(\My\CMSBundle\Entity\ComponentHasFile $componentHasFile)
    {
        $this->componentHasFile[] = $componentHasFile;

        return $this;
    }

    /**
     * Remove componentHasFile
     *
     * @param \My\CMSBundle\Entity\ComponentHasFile $componentHasFile
     */
    public function removeComponentHasFile(\My\CMSBundle\Entity\ComponentHasFile $componentHasFile)
    {
        $this->componentHasFile->removeElement($componentHasFile);
    }

    /**
     * Get componentHasFile
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComponentHasFile()
    {
        return $this->componentHasFile;
    }
}
