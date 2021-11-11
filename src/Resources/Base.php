<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources;

use whotrades\BitbucketApi\ClientInterface;
use \whotrades\BitbucketApi\Response\ResponsePaged;
use \whotrades\BitbucketApi\Exception;
use \whotrades\BitbucketApi\Entity;

abstract class Base
{
    protected static $resourceBaseUrl = '';

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var string | null
     */
    protected $resourceId;

    /**
     * @var Base | null
     */
    protected $parentResource;

    /**
     * @param ClientInterface $client
     * @param string | null $resourceId
     * @param Base | null $parentResource
     */
    public function __construct(ClientInterface $client, $resourceId = null, Base $parentResource = null)
    {
        $this->client = $client;
        $this->resourceId = $resourceId;
        $this->parentResource = $parentResource;
    }

    /**
     * @return string | null
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @param string | null $resourceId
     *
     * @return Entity\Base
     *
     * @throws Exception\JsonInvalidException
     * @throws Exception\ResourceIdRequiredException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEntity($resourceId = null)
    {
        $url = $this->getPath($resourceId);
        $parameters = [];

        $response = $this->sendRequest($url, 'GET', $parameters);

        $entityClass = $this->getEntityClass();

        return new $entityClass($response);
    }

    /**
     * @param array | null $parameters
     *
     * @return Entity\Base[]
     *
     * @throws Exception\JsonInvalidException
     * @throws Exception\ResourceIdRequiredException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList($parameters = null)
    {
        $getAllPages = isset($parameters['limit']) ? false : true;

        $entityClass = $this->getEntityClass();

        $url = $this->getPath(null, $useResourceId = false);
        $parameters = $parameters ?? [];

        $result = [];
        do {
            $response = new ResponsePaged($this->sendRequest($url, 'GET', $parameters));

            foreach ($response->getValues() as $value) {
                $result[] = new $entityClass($value);
            }
            $parameters['start'] = $response->getNextPageStart();
        } while (!$response->isLastPage() && $getAllPages);

        return $result;
    }

    /**
     * @param array | null $parameters
     *
     * @return int
     *
     * @throws Exception\JsonInvalidException
     * @throws Exception\ResourceIdRequiredException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCount(array $parameters = null)
    {
        $url = $this->getPath(null, $useResourceId = false);
        $parameters = $parameters ?? [];

        $count = 0;
        do {
            $response = new ResponsePaged($this->sendRequest($url, 'GET', $parameters));
            $count += $response->getSize();
            $parameters['start'] = $response->getNextPageStart();
        } while (!$response->isLastPage() && $count < $parameters['limit']);

        return $count;
    }

    /**
     * @param string | null $resourceId
     * @param bool | null $useResourceId
     *
     * @return string
     *
     * @throws Exception\ResourceIdRequiredException
     */
    protected function getPath($resourceId = null, $useResourceId = null)
    {
        $useResourceId = $useResourceId ?? true;

        $resourceId = $resourceId ?? $this->resourceId;

        if ($useResourceId === true && $resourceId === null) {
            throw new Exception\ResourceIdRequiredException(static::class);
        }

        if ($useResourceId === false || $resourceId === null) {
            $resourcePath = static::$resourceBaseUrl;
        } else {
            $resourcePath = implode('/', [static::$resourceBaseUrl, $resourceId]);
        }

        if ($this->parentResource) {
            $resourcePath = implode('/', [$this->parentResource->getPath(), $resourcePath]);
        }

        return $resourcePath;
    }

    /**
     * @return string
     */
    abstract protected function getEntityClass();

    /**
     * @param string $url
     * @param string $method
     * @param array $parameters
     *
     * @return array | string
     *
     * @throws Exception\JsonInvalidException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequest($url, $method, array $parameters)
    {
        return $this->client->sendRequest($url, $method, $parameters);
    }
}
