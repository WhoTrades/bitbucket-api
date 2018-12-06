<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Response;

class ResponseDiff
{
    protected $diffs;
    protected $fromHash;
    protected $toHash;
    protected $contextLines;
    protected $whitespace;


    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->diffs = $response['diffs'];
        $this->fromHash = $response['fromHash'];
        $this->toHash = $response['toHash'];
        $this->contextLines = $response['contextLines'];
        $this->whitespace = $response['whitespace'];
    }

    /**
     * @return mixed
     */
    public function getDiffs()
    {
        return $this->diffs;
    }

    /**
     * @return mixed
     */
    public function getFromHash()
    {
        return $this->fromHash;
    }

    /**
     * @return mixed
     */
    public function getToHash()
    {
        return $this->toHash;
    }

    /**
     * @return mixed
     */
    public function getContextLines()
    {
        return $this->contextLines;
    }

    /**
     * @return mixed
     */
    public function getWhitespace()
    {
        return $this->whitespace;
    }
}
