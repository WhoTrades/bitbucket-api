<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
declare(strict_types=1);

namespace whotrades\BitbucketApi\Entity\PullRequest;

use whotrades\BitbucketApi\Entity;
use whotrades\BitbucketApi\Entity\Traits;
use whotrades\BitbucketApi\Entity\User;
use \DateTime;

class Comment extends Entity\Base
{
    use Traits\WithDateTimeTrait;

    /** @var int */
    protected $id;
    /** @var DateTime */
    protected $createdDate;
    /** @var DateTime */
    protected $updatedDate;
    /** @var string */
    protected $text;
    /** @var User */
    protected $author;
    /** @var Comment[] */
    protected $comments;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->id = $data['id'];
        $this->createdDate = $this->createDateTimeByMillisecond($data['createdDate']);
        $this->updatedDate = $this->createDateTimeByMillisecond($data['updatedDate']);
        $this->text = $data['text'];
        $this->author = new User($data['author']);
        $this->comments = array_map(
            function ($item) {
                return new self($item);
            },
            $data['comments']
        );;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDate(): DateTime
    {
        return $this->createdDate;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedDate(): DateTime
    {
        return $this->updatedDate;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @return Comment[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }
}
