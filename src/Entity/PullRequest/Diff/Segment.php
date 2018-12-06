<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\PullRequest\Diff;

use \whotrades\BitbucketApi\Entity;

class Segment extends Entity\Base
{
    const TYPE_CONTEXT = 'CONTEXT';
    const TYPE_ADDED = 'ADDED';
    const TYPE_REMOVED = 'REMOVED';

    protected $type;
    protected $lines;
    protected $truncated;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->type = $data['type'];
        $this->lines = array_map(
            function ($item) {
                return new Line($item);
            },
            $data['lines']
        );
        $this->truncated = $data['truncated'];
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return mixed
     */
    public function getTruncated()
    {
        return $this->truncated;
    }
}
