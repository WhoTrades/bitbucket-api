<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo\PullRequest;

use \whotrades\BitbucketApi\Resources\Project\Repo\Commit as CommitBase;
use \whotrades\BitbucketApi\Exception;

class Commit extends CommitBase
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception\MethodIsNotAcceptable
     */
    public function getListByBranch(string $branch, array $parameters = null): array
    {
        throw new Exception\MethodIsNotAcceptable(__METHOD__);
    }
}
