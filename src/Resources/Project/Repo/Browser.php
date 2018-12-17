<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo;

use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity;
use \whotrades\BitbucketApi\Exception;
use \whotrades\BitbucketApi\Response\ResponseFile;
use \whotrades\BitbucketApi\Response\ResponseDirectory;

class Browser extends Base
{
    protected static $resourceBaseUrl = 'browse';

    /**
     * @param string $path
     * @param array | null $parameters
     *
     * @return string
     *
     * @throws Exception\JsonInvalidException
     * @throws Exception\ResourceIdRequiredException
     * @throws Exception\WrongPathTypeException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFile($path, $parameters = null)
    {
        $url = $this->getPath($path);
        $parameters = $parameters ?? [];

        $content = [];
        do {
            $response = $this->sendRequest($url, 'GET', $parameters);

            if (!isset($response['lines'])) {
                throw new Exception\WrongPathTypeException('FILE', $path);
            }

            $response = new ResponseFile($response);

            $content = array_merge($content, array_map(
                function ($item) {
                    return $item['text'];
                },
                $response->getLines()
            ));
            $parameters['start'] = $response->getStart() + $response->getSize();
        } while (!$response->isLastPage());

        return implode("\n", $content);
    }

    /**
     * @param string $path
     * @param array | null $parameters
     *
     * @return Entity\Browser\Directory
     *
     * @throws Exception\JsonInvalidException
     * @throws Exception\ResourceIdRequiredException
     * @throws Exception\WrongPathTypeException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDirectory($path, $parameters = null)
    {
        $url = $this->getPath($path);
        $parameters = $parameters ?? [];

        $children = [];
        do {
            $response = $this->sendRequest($url, 'GET', $parameters);

            if (!isset($response['children']['values'])) {
                throw new Exception\WrongPathTypeException('DIRECTORY', $path);
            }

            $response = new ResponseDirectory($response);
            $children = array_merge($children, $response->getChildren());

            $parameters['start'] = $response->getStart() + $response->getSize();
        } while (!$response->isLastPage());

        return new Entity\Browser\Directory(['path' => $response->getPath(), 'children' => $children]);
    }

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
     *
     * @throws Exception\MethodIsNotAcceptable
     */
    public function getList($parameters = null)
    {
        throw new Exception\MethodIsNotAcceptable(__METHOD__);
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception\MethodIsNotAcceptable
     */
    public function getCount(array $parameters = null)
    {
        throw new Exception\MethodIsNotAcceptable(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return \StdClass::class;
    }
}
