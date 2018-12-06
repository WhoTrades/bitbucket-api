<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity;

class PullRequest extends Base
{
    protected $id;
    protected $version;
    protected $title;
    protected $description;
    protected $state;
    protected $open;
    protected $closed;
    protected $createdDate;
    protected $updatedDate;

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
        $this->createdDate = $data['createdDate'];
        $this->updatedDate = $data['updatedDate'];
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
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @return mixed
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
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
}
