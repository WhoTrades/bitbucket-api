<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\Diff;

use whotrades\BitbucketApi\Entity;

class Hunk extends Entity\Base
{
    protected $context;
    protected $sourceLine;
    protected $sourceSpan;
    protected $destinationLine;
    protected $destinationSpan;
    protected $segments;
    protected $truncated;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->context = $data['context'];
        $this->sourceLine = $data['sourceLine'];
        $this->sourceSpan = $data['sourceSpan'];
        $this->destinationLine = $data['destinationLine'];
        $this->destinationSpan = $data['destinationSpan'];
        $this->segments = array_map(
            function ($item) {
                return new Segment($item);
            },
            $data['segments']
        );
        $this->truncated = $data['truncated'];
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return mixed
     */
    public function getSourceLine()
    {
        return $this->sourceLine;
    }

    /**
     * @return mixed
     */
    public function getSourceSpan()
    {
        return $this->sourceSpan;
    }

    /**
     * @return mixed
     */
    public function getDestinationLine()
    {
        return $this->destinationLine;
    }

    /**
     * @return mixed
     */
    public function getDestinationSpan()
    {
        return $this->destinationSpan;
    }

    /**
     * @return mixed
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     * @return mixed
     */
    public function getTruncated()
    {
        return $this->truncated;
    }
}
