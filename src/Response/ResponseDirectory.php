<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Response;

class ResponseDirectory
{
    protected $path;
    protected $revision;
    protected $children;
    protected $limit;
    protected $size;
    protected $start;
    protected $isLastPage;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->path = $response['path'];
        $this->revision = $response['revision'];
        $this->children = $response['children']['values'];
        $this->limit = $response['children']['limit'];
        $this->size = $response['children']['size'];
        $this->start = $response['children']['start'];
        $this->isLastPage = $response['children']['isLastPage'];
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return bool
     */
    public function isLastPage()
    {
        return $this->isLastPage;
    }
}
