<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity;

use whotrades\BitbucketApi\Entity;

class Diff extends Entity\Base
{
    protected $source;
    protected $destination;
    protected $hunks;
    protected $fileComments;
    protected $lineComments;
    protected $truncated;
    private $addedLinesCount;
    private $removedLinesCount;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->source = new Entity\Browser\Path($data['source']);
        $this->destination = new Entity\Browser\Path($data['destination']);
        $this->hunks = array_map(
            function ($item) {
                return new Diff\Hunk($item);
            },
            $data['hunks'] ?? []
        );
        $this->fileComments = $data['fileComments'];
        $this->lineComments = $data['lineComments'];
        $this->truncated = $data['truncated'];
    }

    /**
     * @return Entity\Browser\Path
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return Entity\Browser\Path
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return Diff\Hunk[]
     */
    public function getHunks()
    {
        return $this->hunks;
    }

    /**
     * @return mixed
     */
    public function getTruncated()
    {
        return $this->truncated;
    }

    /**
     * @return mixed
     */
    public function getFileComments()
    {
        return $this->fileComments;
    }

    /**
     * @return mixed
     */
    public function getLineComments()
    {
        return $this->lineComments;
    }

    /**
     * @return int
     */
    public function countAddedLines(): int
    {
        if ($this->addedLinesCount === null) {
            $this->addedLinesCount = $this->countLinesByType(Diff\Segment::TYPE_ADDED);
        }

        return $this->addedLinesCount;
    }

    /**
     * @return int
     */
    public function countRemovedLines(): int
    {
        if ($this->removedLinesCount === null) {
            $this->removedLinesCount = $this->countLinesByType(Diff\Segment::TYPE_REMOVED);
        }

        return $this->removedLinesCount;
    }

    /**
     * @return int
     */
    public function countAffectedLines(): int
    {
        return $this->countAddedLines() + $this->countRemovedLines();
    }

    /**
     * @param string $type
     *
     * @return int
     */
    private function countLinesByType(string $type): int
    {
        $count = 0;
        foreach ($this->getHunks() as $hunk) {
            foreach ($hunk->getSegments() as $segment) {
                if ($segment->getType() === $type) {
                    $count += count($segment->getLines());
                }
            }
        }

        return $count;
    }
}
