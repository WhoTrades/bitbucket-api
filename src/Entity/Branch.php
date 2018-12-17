<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity;

class Branch extends Base
{
    const SORT_NAME = 'ALPHABETICAL';
    const SORT_UPDATE = 'MODIFICATION';

    protected $id;
    protected $displayId;
    protected $type;
    protected $latestCommit;
    protected $latestChangeset;
    protected $isDefault;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->id = $data['id'];
        $this->displayId = $data['displayId'];
        $this->type = $data['type'];
        $this->latestCommit = $data['latestCommit'];
        $this->latestChangeset = $data['latestChangeset'];
        $this->isDefault = $data['isDefault'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDisplayId()
    {
        return $this->displayId;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getLatestCommit()
    {
        return $this->latestCommit;
    }

    /**
     * @return mixed
     */
    public function getLatestChangeset()
    {
        return $this->latestChangeset;
    }

    /**
     * @return mixed
     */
    public function isDefault()
    {
        return $this->isDefault;
    }
}
