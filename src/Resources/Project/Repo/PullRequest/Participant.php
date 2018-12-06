<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo\PullRequest;

use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity;

class Participant extends Base
{
    protected static $resourceBaseUrl = 'participants';

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Entity\PullRequest\Participant::class;
    }
}
