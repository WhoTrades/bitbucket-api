<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo;

use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity;

class Commit extends Base
{
    protected static $resourceBaseUrl = 'commits';

    /**
     * Get commits of branch without commits of merged branches
     *
     * @param string $branch
     * @param array | null $parameters
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \whotrades\BitbucketApi\Exception\JsonInvalidException
     * @throws \whotrades\BitbucketApi\Exception\ResourceIdRequiredException
     *
     * @return Entity\Commit[]
     */
    public function getListByBranch($branch, $parameters = null)
    {
        $parameters = $parameters ?? [];

        // ag: Use parameters 'start' and 'limit' for final filtering
        $limit = $parameters['limit'] ?? 10;
        $start = $parameters['start'] ?? 0;

        // ag: Set parameters 'start' and 'limit' for request
        $parameters['limit'] = 100;
        $parameters['start'] = 0;

        $parameters = array_merge($parameters, [
            'until' => "refs/heads/{$branch}",
        ]);

        $result = [];
        $lastCommitParentIdList = [];
        $lastCommitJiraKey = null;
        do {
            $commitList = $this->getList($parameters);

            /** @var \whotrades\BitbucketApi\Entity\Commit $commit */
            foreach ($commitList as $commit) {
                switch (true) {
                    // ag: Add the head of branch
                    case $lastCommitParentIdList === []:
                    // ag: Find only parent
                    case count($lastCommitParentIdList) === 1 && in_array($commit->getId(), $lastCommitParentIdList):
                    // ag: Last commit was merged. Skip commit from merged branch
                    case in_array($commit->getId(), $lastCommitParentIdList) && $commit->getJiraKey() !== $lastCommitJiraKey:
                        $result[] = $commit;
                        $lastCommitParentIdList = array_map(
                            function (\whotrades\BitbucketApi\Entity\Commit\Base $item) {
                                return $item->getId();
                            },
                            $commit->getParents()
                        );
                        $lastCommitJiraKey = $commit->getJiraKey();
                }
            }
            $parameters['start'] += $parameters['limit'];
        } while (count($result) < ($start + $limit) && count($commitList) > 0);

        return array_slice($result, $start, $limit);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Entity\Commit::class;
    }
}
