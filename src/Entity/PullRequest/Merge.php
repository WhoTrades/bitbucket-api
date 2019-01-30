<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\PullRequest;

use \whotrades\BitbucketApi\Entity;

class Merge extends Entity\Base
{
    /**
     * @var bool
     */
    protected $canMerge;

    /**
     * @var bool
     */
    protected $conflicted;
    protected $outcome;
    protected $vetoes;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->canMerge = (bool) $data['canMerge'];
        $this->conflicted = (bool) $data['conflicted'];
        $this->outcome = $data['outcome'];
        $this->vetoes = $data['vetoes'];
    }

    /**
     * @return bool
     */
    public function canMerge()
    {
        return $this->canMerge;
    }

    /**
     * @return bool
     */
    public function isConflicted()
    {
        return $this->conflicted;
    }

    /**
     * @return string
     */
    public function getOutcome()
    {
        return $this->outcome;
    }

    /**
     * @return mixed
     */
    public function getVetoes()
    {
        return $this->vetoes;
    }
}
