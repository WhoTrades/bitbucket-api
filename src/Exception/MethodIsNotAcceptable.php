<?php
namespace whotrades\BitbucketApi\Exception;

class MethodIsNotAcceptable extends \Exception
{
    public $context;

    /**
     * JsonInvalidException constructor.
     *
     * @param string $method
     * @param int | null $code
     * @param \Throwable | null $previous
     */
    public function __construct($method, $code = null, \Throwable $previous = null)
    {
        parent::__construct("Method {$method} is not acceptable", $code ?? 0, $previous);
    }
}
