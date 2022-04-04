<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo;

use Generator;
use whotrades\BitbucketApi\Resources\Base;
use whotrades\BitbucketApi\Entity;
use GuzzleHttp\Exception\GuzzleException;
use whotrades\BitbucketApi\Exception\JsonInvalidException;
use whotrades\BitbucketApi\Exception\ResourceIdRequiredException;

class Commit extends Base
{
    const DEFAULT_LIMIT = 100;

    protected static $resourceBaseUrl = 'commits';

    /**
     * @param string $branch
     * @param array | null $parameters
     *
     * @return Entity\Commit[]
     *
     * @throws GuzzleException
     * @throws JsonInvalidException
     * @throws ResourceIdRequiredException
     */
    public function getListByBranch(string $branch, array $parameters = null): array
    {
        $parameters = $parameters ?? [];
        $ref = "refs/heads/{$branch}";

        return $this->getListFromCommitId($ref, $parameters);
    }

    /**
     * @param string $commitId
     * @param array | null $parameters
     *
     * @return Entity\Commit[]
     *
     * @throws GuzzleException
     * @throws JsonInvalidException
     * @throws ResourceIdRequiredException
     */
    public function getListFromCommitId(string $commitId, array $parameters = null): array
    {
        $parameters = $parameters ?? [];
        $parameters['until'] = $commitId;

        return $this->getList($parameters);
    }

    /**
     * @param string $branch
     *
     * @return Generator
     *
     * @throws GuzzleException
     * @throws JsonInvalidException
     * @throws ResourceIdRequiredException
     */
    public function getGeneratorByBranch(string $branch): Generator
    {
        $ref = "refs/heads/{$branch}";

        yield from $this->getGeneratorFromCommitId($ref);
    }

    /**
     * @param string $branch
     *
     * @return Generator
     *
     * @throws GuzzleException
     * @throws JsonInvalidException
     * @throws ResourceIdRequiredException
     */
    public function getGeneratorFromCommitId(string $fromCommitId): Generator
    {
        $parameters['limit'] = self::DEFAULT_LIMIT;

        $commitList = $this->getListFromCommitId($fromCommitId, $parameters);
        if (count($commitList) < self::DEFAULT_LIMIT) {
            yield from $commitList;
        } else {
            $lastCommit = array_pop($commitList);
            yield from $commitList;
            yield from $this->getListFromCommitId($lastCommit->getId(), $parameters);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Entity\Commit::class;
    }
}
