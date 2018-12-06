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
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return \StdClass::class;
    }
}
