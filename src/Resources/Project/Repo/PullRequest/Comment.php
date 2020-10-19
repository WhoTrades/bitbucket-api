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
        // ag: It is impossible to get all comments of pull request via this resource with empty filter
        // https://community.atlassian.com/t5/Bitbucket-questions/Retrieving-comments-from-Bitbucket-server-via-REST-API/qaq-p/282253
        // Use activity resource for it
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
