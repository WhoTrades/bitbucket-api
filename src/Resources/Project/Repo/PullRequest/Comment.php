<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
declare(strict_types=1);

namespace whotrades\BitbucketApi\Resources\Project\Repo\PullRequest;

use whotrades\BitbucketApi\Resources\Base;
use whotrades\BitbucketApi\Exception\JsonInvalidException;
use whotrades\BitbucketApi\Exception\ResourceIdRequiredException;
use whotrades\BitbucketApi\Entity\PullRequest\Activity as EntityActivity;
use whotrades\BitbucketApi\Entity\PullRequest\Comment as EntityComment;
use GuzzleHttp\Exception\GuzzleException;

class Comment extends Base
{
    protected static $resourceBaseUrl = 'comments';

    /**
     * {@inheritDoc}
     *
     * @return EntityComment[]
     */
    public function getList($parameters = null): array
    {
        if ($parameters === null) {
            $commentList = [];
            /** @var EntityActivity $activity */
            foreach ($this->parentResource->getActivity()->getList() as $activity) {
                if ($activity->getAction() === EntityActivity::ACTION_COMMENTED) {
                    $commentList[] = $activity->getComment();
                }
            }

            return $commentList;
        }

        return parent::getList($parameters);
    }

    /**
     * @param string $comment
     * @param int $parentId
     *
     * @throws JsonInvalidException
     * @throws ResourceIdRequiredException
     * @throws GuzzleException
     */
    public function addComment(string $comment, int $parentId = null): void
    {
        $parameters = ['text' => $comment];
        if ($parentId) {
            $parameters['parent']['id'] = $parentId;
        }
        $this->sendRequest($this->getPath(null, false), 'POST', $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass(): string
    {
        return EntityComment::class;
    }
}
