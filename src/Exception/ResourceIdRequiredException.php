<?php
namespace whotrades\BitbucketApi\Exception;

class ResourceIdRequiredException extends \Exception
{
    public $context;

    /**
     * ResourceIdRequiredException constructor.
     *
     * @param string $resourceClass
     * @param int | null $code
     * @param \Throwable | null $previous
     */
    public function __construct($resourceClass, $code = null, \Throwable $previous = null)
    {
        parent::__construct("ResourceId required in {$resourceClass}", $code ?? 0, $previous);
    }
}
