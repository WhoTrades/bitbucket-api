<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project;

use \whotrades\BitbucketApi\Resources\Base;

class Repo extends Base
{
    protected static $resourceBaseUrl = 'repos';

    /**
     * @param int | null $pullRequestId
     *
     * @return Repo\PullRequest
     */
    public function getPullRequest($pullRequestId = null)
    {
        return new Repo\PullRequest($this->client, $pullRequestId, $this);
    }

    /**
     * @return Repo\Browser
     */
    public function getBrowser()
    {
        return new Repo\Browser($this->client, null, $this);
    }

    /**
     * @return Repo\Commit
     */
    public function getCommit()
    {
        return new Repo\Commit($this->client, null, $this);
    }

    /**
     * @return Repo\Branch
     */
    public function getBranch()
    {
        return new Repo\Branch($this->client, null, $this);
    }

    /**
     * @return Repo\Diff
     */
    public function getDiff()
    {
        return new Repo\Diff($this->client, null, $this);
    }

    /**
     * @return Repo\Compare\Commit
     */
    public function getCompareCommit()
    {
        return new Repo\Compare\Commit($this->client, null, $this);
    }

    /**
     * @return Repo\Compare\Diff
     */
    public function getCompareDiff()
    {
        return new Repo\Compare\Diff($this->client, null, $this);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return \StdClass::class;
    }
}
