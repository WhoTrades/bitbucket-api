<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
declare(strict_types=1);

namespace whotrades\BitbucketApi\Entity\PullRequest;

use \whotrades\BitbucketApi\Entity;
use \DateTime;

class Activity extends Entity\Base
{
    use Entity\Traits\WithDateTimeTrait;

    const ACTION_NEED_WORK = 'REVIEWED';
    const ACTION_APPROVED = 'APPROVED';
    const ACTION_RESCOPED = 'RESCOPED';
    const ACTION_COMMENTED = 'COMMENTED';

    /** @var int */
    protected $id;
    /** @var DateTime */
    protected $createdDateTime;
    /** @var string */
    protected $action;
    /** @var Entity\User */
    protected $user;
    /** @var Comment|null */
    protected $comment;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->id = $data['id'];
        $this->createdDateTime = $this->createDateTimeByMillisecond($data['createdDate']);
        $this->action = $data['action'];
        $this->user = new Entity\User($data['user']);
        if ($this->action === self::ACTION_COMMENTED) {
            $this->comment = new Comment($data['comment']);
        }
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
     * @return DateTime
     */
    public function getCreatedDateTime(): DateTime
    {
        return $this->createdDateTime;
    }

    /**
     * @return Entity\User
     */
    public function getUser(): Entity\User
    {
        return $this->user;
    }

    /**
     * @return Comment|null
     */
    public function getComment(): ?Comment
    {
        return $this->comment;
    }
}
