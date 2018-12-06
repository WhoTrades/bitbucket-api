<?php
namespace whotrades\BitbucketApi\Exception;

class WrongPathTypeException extends \Exception
{
    public $context;

    /**
     * WrongPathTypeException constructor.
     *
     * @param string $requiredType
     * @param string $path
     * @param int | null $code
     * @param \Throwable | null $previous
     */
    public function __construct($requiredType, $path, $code = null, \Throwable $previous = null)
    {
        parent::__construct("Path is not a {$requiredType}; {$path}", $code ?? 0, $previous);
    }
}
