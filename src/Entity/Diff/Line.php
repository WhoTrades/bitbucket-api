<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\Diff;

use \whotrades\BitbucketApi\Entity;

class Line extends Entity\Base
{
    protected $source;
    protected $destination;
    protected $line;
    protected $conflictMarker;
    protected $truncated;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->source = $data['source'];
        $this->destination = $data['destination'];
        $this->line = $data['line'];
        $this->conflictMarker = $data['conflictMarker'] ?? null;
        $this->truncated = $data['truncated'];
    }

    /**
     * Source line number
     *
     * @return int
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Destination line number
     *
     * @return int
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @return mixed
     */
    public function getConflictMarker()
    {
        return $this->conflictMarker;
    }

    /**
     * @return mixed
     */
    public function getTruncated()
    {
        return $this->truncated;
    }
}
