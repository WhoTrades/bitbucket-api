<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo;

use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity;

class PullRequest extends Base
{
    const DIRECTION_INCOMING = 'INCOMING';
    const DIRECTION_OUTGOING = 'OUTGOING';

    protected static $resourceBaseUrl = 'pull-requests';

    /**
     * @return Commit
     */
    public function getCommit()
    {
        return new Commit($this->client, null, $this);
    }

    /**
     * @return PullRequest\Activity
     */
    public function getActivity()
    {
        return new PullRequest\Activity($this->client, null, $this);
    }

    /**
     * @return PullRequest\Merge
     */
    public function getMerge()
    {
        return new PullRequest\Merge($this->client, null, $this);
    }

    /**
     * @return PullRequest\Diff
     */
    public function getDiff()
    {
        return new PullRequest\Diff($this->client, null, $this);
    }

    /**
     * @return PullRequest\Participant
     */
    public function getParticipant()
    {
        return new PullRequest\Participant($this->client, null, $this);
    }

    /**
     * @param string $branch
     *
     * @return Entity\Base[]
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \whotrades\BitbucketApi\Exception\JsonInvalidException
     * @throws \whotrades\BitbucketApi\Exception\ResourceIdRequiredException
     */
    public function getListByBranch($branch)
    {
        $parameters = [
            'at' => "refs/heads/{$branch}",
            'direction' => self::DIRECTION_OUTGOING,
        ];

        return $this->getList($parameters);
    }

    /**
     * @param string $branch
     *
     * @return bool
     */
    public function isConflicted($branch)
    {
        $pullRequestList = $this->getListByBranch($branch);

        $conflicted = false;
        /** @var \whotrades\BitbucketApi\Entity\PullRequest $pullRequest */
        foreach ($pullRequestList as $pullRequest) {
            /** @var \whotrades\BitbucketApi\Entity\PullRequest\Merge $mergeEntity */
            $mergeEntity = $this->parentResource->getPullRequest($pullRequest->getId())->getMerge()->getEntity();
            $conflicted = $conflicted || $mergeEntity->isConflicted();
        }

        return $conflicted;
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $fromBranch
     * @param string $toBranch
     * @param array $reviewers // [userNameOne, userNameTwo, ...]
     *
     * @return Entity\PullRequest
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \whotrades\BitbucketApi\Exception\JsonInvalidException
     * @throws \whotrades\BitbucketApi\Exception\ResourceIdRequiredException
     */
    public function create($title, $description, $fromBranch, $toBranch, array $reviewers)
    {
        $repositorySlug = $this->parentResource->resourceId;
        $projectKey = $this->parentResource->parentResource->resourceId;

        $parameters = [
            'title'         => $title,
            'description'   => $description,
            'state'         => 'OPEN',
            'open'          => true,
            'closed'        => false,
            'locked'        => false,
            "fromRef"       => [
                'id' => "refs/heads/$fromBranch",
                'repository' => [
                    'slug' => $repositorySlug,
                    'project' => ['key' => $projectKey],
                ],
            ],
            "toRef"       => [
                'id' => "refs/heads/$toBranch",
                'repository' => [
                    'slug' => $repositorySlug,
                    'project' => ['key' => $projectKey],
                ],
            ],
            'reviewers' => array_map(function ($val) {
                return ['user' => ['name' => $val]];
            }, $reviewers),
        ];

        $url = $this->getPath(null, $useResourceId = false);

        $response = $this->sendRequest($url, 'POST', $parameters);

        $entityClass = $this->getEntityClass();

        return new $entityClass($response);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Entity\PullRequest::class;
    }
}
