<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity;

abstract class Base
{
    /**
     * @var array
     */
    protected $dataRaw;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        $this->dataRaw = $data;
        $this->init($data);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    abstract protected function init(array $data);
}
