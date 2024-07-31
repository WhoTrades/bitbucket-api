<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Response;

class ResponsePaged
{
    protected $values;
    protected $size;
    protected $start;
    protected $limit;
    protected $filter;
    protected $isLastPage;
    protected $nextPageStart;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->values = $response['values'];
        $this->size = $response['size'];
        $this->start = $response['start'];
        $this->limit = $response['limit'];
        $this->filter = $response['filter'] ?? null;
        $this->isLastPage = $response['isLastPage'];
        $this->nextPageStart = $response['nextPageStart'] ?? null;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
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
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return bool
     */
    public function isLastPage()
    {
        return $this->isLastPage;
    }

    /**
     * @return int
     */
    public function getNextPageStart()
    {
        return $this->nextPageStart;
    }
}
