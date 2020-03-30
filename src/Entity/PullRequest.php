<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity;

use \DateTime;

class PullRequest extends Base
{
    use Traits\WithDateTimeTrait;

    const STATUS_NEEDS_WORK = 'NEEDS_WORK';
    const STATUS_APPROVED = 'APPROVED';

    protected $id;
    protected $version;
    protected $title;
    protected $description;
    protected $state;
    protected $open;
    protected $closed;

    /**
     * @var DateTime
     */
    protected $createdDateTime;

    /**
     * @var DateTime
     */
    protected $updatedDateTime;

    /**
     * @var Ref
     */
    protected $fromRef;

    /**
     * @var Ref
     */
    protected $toRef;

    protected $locked;

    /**
     * @var PullRequest\Participant
     */
    protected $author;

    /**
     * @var PullRequest\Participant[]
     */
    protected $reviewers;
    protected $participants;
    protected $properties;
    protected $links;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->id = $data['id'];
        $this->version = $data['version'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->state = $data['state'];
        $this->open = $data['open'];
        $this->closed = $data['closed'];
        $this->createdDateTime = $this->createDateTimeByMillisecond($data['createdDate']);
        $this->updatedDateTime = $this->createDateTimeByMillisecond($data['updatedDate']);
        $this->fromRef = new Ref($data['fromRef']);
        $this->toRef = new Ref($data['toRef']);
        $this->locked = $data['locked'];
        $this->author = new PullRequest\Participant($data['author']);
        $this->reviewers = array_map(
            function ($item) {
                return new PullRequest\Participant($item);
            },
            $data['reviewers']
        );
        $this->participants = $data['participants'];
        $this->properties = $data['properties'];
        $this->links = $data['links'];
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
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * @return mixed
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDateTime()
    {
        return $this->createdDateTime;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedDateTime()
    {
        return $this->updatedDateTime;
    }

    /**
     * @return Ref
     */
    public function getFromRef()
    {
        return $this->fromRef;
    }

    /**
     * @return Ref
     */
    public function getToRef()
    {
        return $this->toRef;
    }

    /**
     * @return mixed
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @return PullRequest\Participant
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return PullRequest\Participant[]
     */
    public function getReviewers()
    {
        return $this->reviewers;
    }

    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return mixed
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @return string | null
     */
    public function getSelfLink()
    {
        if (isset($this->getLinks()['self'][0]['href'])) {
            return $this->getLinks()['self'][0]['href'];
        }

        return null;
    }

    /**
     * @return string | null
     */
    public function getLinkToDiffPage()
    {
        if (!$this->getSelfLink()) {
            return $this->getSelfLink();
        }

        return $this->getSelfLink() . '/diff';
    }

    /**
     * @return User[]
     */
    public function getNeedsWorkUserList()
    {
        $needsWorkUserList = [];
        /** @var PullRequest\Participant $reviewer */
        foreach ($this->getReviewers() as $reviewer) {
            if ($reviewer->getStatus() === self::STATUS_NEEDS_WORK) {
                $needsWorkUserList[$reviewer->getUser()->getId()] = $reviewer->getUser();
            }
        }

        return $needsWorkUserList;
    }
}
