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
    public function getDefault()
    {
        return $this->getEntity(self::RESOURCE_ID_DEFAULT);
    }

    /**
     * @param string $name
     * @param string $fromCommitId
     * @param string $message
     *
     * @return Entity\Branch
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \whotrades\BitbucketApi\Exception\JsonInvalidException
     * @throws \whotrades\BitbucketApi\Exception\ResourceIdRequiredException
     */
    public function create($name, $fromCommitId, $message)
    {
        $parameters = [
            'name' => $name,
            'startPoint' => $fromCommitId,
            'message' => $message,
        ];

        $url = $this->getPath(null, $useResourceId = false);

        $response = $this->sendRequest($url, 'POST', $parameters);

        $entityClass = $this->getEntityClass();

        return new $entityClass($response);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Entity\Branch::class;
    }
}
