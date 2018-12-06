<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity;

class Ref extends Base
{
    protected $id;
    protected $displayId;
    protected $latestCommit;
    protected $repository;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->id = $data['id'];
        $this->displayId = $data['displayId'];
        $this->latestCommit = $data['latestCommit'];
        $this->repository = $data['repository'];
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
    public function getLatestCommit()
    {
        return $this->latestCommit;
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }
}
