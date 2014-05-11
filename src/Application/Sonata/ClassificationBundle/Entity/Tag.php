<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\ClassificationBundle\Entity;

use Sonata\ClassificationBundle\Entity\BaseTag as BaseTag;

/**
 * This file has been generated by the Sonata EasyExtends bundle ( http://sonata-project.org/bundles/easy-extends )
 *
 * References :
 *   working with object : http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 *
 * @author <yourname> <youremail>
 */
class Tag extends BaseTag
{
    const COLOR_GRAY = 'default';
    const COLOR_BLUE = 'primary';
    const COLOR_GREEN = 'success';
    const COLOR_SKY = 'info';
    const COLOR_ORANGE = 'warning';
    const COLOR_RED = 'danger';

    public static $colors = [
        self::COLOR_GRAY   => 'gray',
        self::COLOR_BLUE   => 'blue',
        self::COLOR_GREEN  => 'green',
        self::COLOR_SKY    => 'sky',
        self::COLOR_ORANGE => 'orange',
        self::COLOR_RED    => 'red'
    ];

    /**
     * @var integer $id
     */
    protected $id;


    public function getColorString()
    {
        return self::$colors[$this->getColor()];
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var integer
     */
    private $color;


    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }
}