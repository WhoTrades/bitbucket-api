<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\PullRequest;

use \whotrades\BitbucketApi\Entity;

class Activity extends Entity\Base
{
    const ACTION_NEED_WORK = 'REVIEWED';
    const ACTION_APPROVED = 'APPROVED';
    const ACTION_RESCOPED = 'RESCOPED';

    protected $id;
    /**
     * @var int
     */
    protected $createdDate;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var Entity\User
     */
    protected $user;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->id = $data['id'];
        $this->createdDate = (int) $data['createdDate'];
        $this->action = $data['action'];
        $this->user = new Entity\User($data['user']);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param bool $milliseconds
     *
     * @return int // seconds or milliseconds
     */
    public function getCreatedDate($milliseconds = null)
    {
        if ($milliseconds) {
            return $this->createdDate;
        }

        return (int) round($this->createdDate/1000);
    }

    /**
     * @return Entity\User
     */
    public function getUser(): Entity\User
    {
        return $this->user;
    }
}
