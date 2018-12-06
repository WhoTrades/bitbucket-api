<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Response;

class ResponseFile
{
    protected $lines;
    protected $size;
    protected $start;
    protected $isLastPage;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->lines = $response['lines'];
        $this->size = $response['size'];
        $this->start = $response['start'];
        $this->isLastPage = $response['isLastPage'];
    }

    /**
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
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
