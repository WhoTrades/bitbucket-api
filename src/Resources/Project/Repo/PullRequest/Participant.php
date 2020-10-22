<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo\PullRequest;

use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity\PullRequest\Participant as EntityParticipant;
use \whotrades\BitbucketApi\Exception;

class Participant extends Base
{
    protected static $resourceBaseUrl = 'participants';

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
     * @throws Exception\JsonInvalidException
     * @throws Exception\ResourceIdRequiredException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setNeedsWork()
    {
        $parameters = ['status' => EntityParticipant::STATUS_NEEDS_WORK];
        $this->sendRequest($this->getPath(), 'PUT', $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return EntityParticipant::class;
    }
}
