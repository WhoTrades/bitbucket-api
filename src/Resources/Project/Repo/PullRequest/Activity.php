<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo\PullRequest;

use \whotrades\BitbucketApi\Exception;
use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity\PullRequest\Activity as EntityActivity;

class Activity extends Base
{
    protected static $resourceBaseUrl = 'activities';

    /**
     * {@inheritdoc}
     *
     * @throws Exception\MethodIsNotAcceptable
     */
    public function getEntity($resourceId = null)
    {
        throw new Exception\MethodIsNotAcceptable(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return EntityActivity::class;
    }
}
