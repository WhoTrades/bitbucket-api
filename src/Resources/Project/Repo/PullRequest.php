<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo;

use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity;
use \whotrades\BitbucketApi\Exception;

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
     * @param string | null $userSlug
     *
     * @return PullRequest\Participant
     */
    public function getParticipant($userSlug = null)
    {
        return new PullRequest\Participant($this->client, $userSlug, $this);
    }

    /**
     * @param string | null $commentId
     *
     * @return PullRequest\Comment
     */
    public function getComment($commentId = null)
    {
        return new PullRequest\Comment($this->client, $commentId, $this);
    }

    /**
     * @param string $branch
     *
     * @return Entity\PullRequest[]
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \whotrades\BitbucketApi\Exception\JsonInvalidException
     * @throws \whotrades\BitbucketApi\Exception\ResourceIdRequiredException
     */
    public function getListBySourceBranch($branch)
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
     * @return Entity\PullRequest[]
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \whotrades\BitbucketApi\Exception\JsonInvalidException
     * @throws \whotrades\BitbucketApi\Exception\ResourceIdRequiredException
     */
    public function getListByDestinationBranch($branch)
    {
        $parameters = [
            'at' => "refs/heads/{$branch}",
            'direction' => self::DIRECTION_INCOMING,
        ];

        return $this->getList($parameters);
    }

    /**
     * @return bool
     */
    public function isConflicted(): bool
    {
        if ($this->resourceId === null) {
            throw new Exception\ResourceIdRequiredException(static::class);
        }

        /** @var \whotrades\BitbucketApi\Entity\PullRequest\Merge $mergeEntity */
        $mergeEntity = $this->parentResource->getPullRequest($this->resourceId)->getMerge()->getEntity();

        return $mergeEntity->isConflicted();
    }

    /**
     * @param string $branch
     *
     * @return bool
     */
    public function isConflictedByBranch($branch)
    {
        $pullRequestList = $this->getListBySourceBranch($branch);

        $conflicted = false;
        /** @var \whotrades\BitbucketApi\Entity\PullRequest $pullRequest */
        foreach ($pullRequestList as $pullRequest) {
            $conflicted = $conflicted || $this->parentResource->getPullRequest($pullRequest->getId())->isConflicted();
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
     * @param $version
     *
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \whotrades\BitbucketApi\Exception\JsonInvalidException
     * @throws \whotrades\BitbucketApi\Exception\ResourceIdRequiredException
     */
    public function delete($version)
    {
        $parameters = ['version' => $version];

        $url = $this->getPath();

        $this->sendRequest($url, 'DELETE', $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Entity\PullRequest::class;
    }
}
