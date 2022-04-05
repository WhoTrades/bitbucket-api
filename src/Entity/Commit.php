<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity;

use whotrades\BitbucketApi\Entity\Commit\Committer;
use whotrades\BitbucketApi\Entity\Commit\Base as CommitBase;
use DateTime;

class Commit extends CommitBase
{
    use Traits\WithDateTimeTrait;

    /**
     * @var Committer
     */
    protected $author;

    /**
     * @var DateTime
     */
    protected $authorDateTime;

    /**
     * @var Committer
     */
    protected $committer;

    /**
     * @var DateTime
     */
    protected $committerDateTime;
    protected $message;

    /**
     * @var CommitBase[]
     */
    protected $parents;
    protected $properties;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        parent::init($data);
        $this->author = new Committer($data['author']);
        $this->authorDateTime = $this->createDateTimeByMillisecond($data['authorTimestamp']);
        $this->committer = new Committer($data['committer']);
        $this->committerDateTime = $this->createDateTimeByMillisecond($data['committerTimestamp']);
        $this->message = $data['message'];
        $this->parents = array_map(
            function ($item) {
                return new CommitBase($item);
            },
            $data['parents']
        );
        $this->properties = $data['properties'];
    }

    /**
     * @return Committer
     */
    public function getAuthor(): Committer
    {
        return $this->author;
    }

    /**
     * @return DateTime
     */
    public function getAuthorDateTime()
    {
        return $this->authorDateTime;
    }

    /**
     * @return Committer
     */
    public function getCommitter(): Committer
    {
        return $this->committer;
    }

    /**
     * @return DateTime
     */
    public function getCommitterDateTime()
    {
        return $this->committerDateTime;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return CommitBase[]
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param string $commitId
     *
     * @return bool
     */
    public function isParentId(string $commitId): bool
    {
        $parentIdList = array_map(
            function (CommitBase $commit) {
                return $commit->getId();
            },
            $this->getParents()
        );

        return in_array($commitId, $parentIdList);
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return string | null
     */
    public function getJiraKey()
    {
        return $this->properties['jira-key'][0] ?? null;
    }
}
