<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo\PullRequest;

use \whotrades\BitbucketApi\Exception;
use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity\PullRequest\Merge as EntityMerge;

class Merge extends Base
{
    protected static $resourceBaseUrl = 'merge';

    /**
     * {@inheritdoc}
     *
     * @throws Exception\MethodIsNotAcceptable
     */
    public function getEntity($resourceId = null)
    {
        if ($resourceId !== null) {
            throw new Exception\MethodIsNotAcceptable(__METHOD__);
        }

        $url = $this->getPath(null, false);
        $parameters = [];

        $response = $this->sendRequest($url, 'GET', $parameters);

        $entityClass = $this->getEntityClass();

        return new $entityClass($response);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return EntityMerge::class;
    }
}
