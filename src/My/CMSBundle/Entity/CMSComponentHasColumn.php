<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMSComponentHasColumn
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CMSComponentHasColumn
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
     * @ORM\Column(name="column_label", type="string", length=255)
     */
    private $columnLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255)
     */
    private $class;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_required", type="boolean")
     */
    private $isRequired;


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
     * @return CMSComponentHasColumn
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
     * Set columnLabel
     *
     * @param string $columnLabel
     * @return CMSComponentHasColumn
     */
    public function setColumnLabel($columnLabel)
    {
        $this->columnLabel = $columnLabel;
    
        return $this;
    }

    /**
     * Get columnLabel
     *
     * @return string 
     */
    public function getColumnLabel()
    {
        return $this->columnLabel;
    }

    /**
     * Set class
     *
     * @param string $class
     * @return CMSComponentHasColumn
     */
    public function setClass($class)
    {
        $this->class = $class;
    
        return $this;
    }

    /**
     * Get class
     *
     * @return string 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set isRequired
     *
     * @param boolean $isRequired
     * @return CMSComponentHasColumn
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;
    
        return $this;
    }

    /**
     * Get isRequired
     *
     * @return boolean 
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }
}
