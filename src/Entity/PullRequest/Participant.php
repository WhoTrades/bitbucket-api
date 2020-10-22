<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\PullRequest;

use \whotrades\BitbucketApi\Entity;

class Participant extends Entity\Base
{
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_NEEDS_WORK = 'NEEDS_WORK';
    const STATUS_UNAPPROVED = 'UNAPPROVED';

    /**
     * @var Entity\User
     */
    protected $user;
    protected $role;
    protected $approved;
    protected $status;
    protected $lastReviewedCommit;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->user = new Entity\User($data['user']);
        $this->role = $data['role'];
        $this->approved = $data['approved'];
        $this->status = $data['status'];
        $this->lastReviewedCommit = $data['lastReviewedCommit'];
    }

    /**
     * @return Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getLastReviewedCommit()
    {
        return $this->lastReviewedCommit;
    }
}
