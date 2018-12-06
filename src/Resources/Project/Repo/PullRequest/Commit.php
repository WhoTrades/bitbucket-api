<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo\PullRequest;

use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity;

class Commit extends Base
{
    protected static $resourceBaseUrl = 'commits';

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Entity\Commit::class;
    }
}
