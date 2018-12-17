<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity;

use whotrades\BitbucketApi\Entity\Commit\Committer;
use whotrades\BitbucketApi\Entity\Commit\Base as CommitBase;

class Commit extends CommitBase
{
    /**
     * @var Committer
     */
    protected $author;
    protected $authorTimestamp;

    /**
     * @var Committer
     */
    protected $committer;
    protected $committerTimestamp;
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
        $this->authorTimestamp = $data['authorTimestamp'];
        $this->committer = new Committer($data['committer']);
        $this->committerTimestamp = $data['committerTimestamp'];
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
     * @return mixed
     */
    public function getAuthorTimestamp()
    {
        return $this->authorTimestamp;
    }

    /**
     * @return Committer
     */
    public function getCommitter(): Committer
    {
        return $this->committer;
    }

    /**
     * @return mixed
     */
    public function getCommitterTimestamp()
    {
        return $this->committerTimestamp;
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
