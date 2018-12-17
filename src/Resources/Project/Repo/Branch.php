<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo;

use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity;
use \whotrades\BitbucketApi\Exception;

class Branch extends Base
{
    const RESOURCE_ID_DEFAULT = 'default';

    protected static $resourceBaseUrl = 'branches';

    /**
     * {@inheritdoc}
     *
     * @throws \whotrades\BitbucketApi\Exception\MethodIsNotAcceptable
     */
    public function getEntity($resourceId = null)
    {
        if ($resourceId !== self::RESOURCE_ID_DEFAULT) {
            throw new Exception\MethodIsNotAcceptable(__METHOD__);
        }

        return parent::getEntity($resourceId);
    }

    /**
     * @return Entity\Branch
     *
     * @throws Exception\JsonInvalidException
     * @throws Exception\MethodIsNotAcceptable
     * @throws Exception\ResourceIdRequiredException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gedDefault()
    {
        return $this->getEntity(self::RESOURCE_ID_DEFAULT);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Entity\Branch::class;
    }
}
