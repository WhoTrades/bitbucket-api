<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\Browser;

use \whotrades\BitbucketApi\Entity;

class Path extends Entity\Base
{
    protected $name;
    protected $parent;
    protected $extension;
    protected $toString;
    protected $components;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->name = $data['name'];
        $this->parent = $data['parent'];
        $this->extension = $data['extension'];
        $this->toString = $data['toString'];
        $this->components = $data['components'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Full path string
     *
     * @return string
     */
    public function toString()
    {
        return $this->toString;
    }

    /**
     * components = explode('/', toString)
     *
     * @return array
     */
    public function getComponents()
    {
        return $this->components;
    }
}
