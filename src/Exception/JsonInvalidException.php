<?php
namespace whotrades\BitbucketApi\Exception;

class JsonInvalidException extends \Exception
{
    public $context;

    /**
     * JsonInvalidException constructor.
     *
     * @param array $context
     * @param string | null $message
     * @param int | null $code
     * @param \Throwable | null $previous
     */
    public function __construct($context, $message = null, $code = null, \Throwable $previous = null)
    {
        $this->context = $context;

        parent::__construct($message ?? 'Invalid json', $code ?? 0, $previous);
    }
}
