<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity;

class User extends Base
{
    protected $id;
    protected $name;
    protected $slug;
    protected $emailAddress;
    protected $displayName;
    protected $active;
    protected $type;
    protected $links;
    protected $self;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->slug = $data['slug'];
        $this->emailAddress = $data['emailAddress'];
        $this->displayName = $data['displayName'];
        $this->active = $data['active'];
        $this->type = $data['type'];
        $this->links = $data['links'];
        $this->self = $data['self'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @return mixed
     */
    public function getSelf()
    {
        return $this->self;
    }
}
