<?php
/**
 * Resource for http://example.com/rest/api/1.0/projects/{projectKey}/repos/{repositorySlug}/diff/{path:.*}
 *
 * @see https://docs.atlassian.com/bitbucket-server/rest/5.16.0/bitbucket-rest.html#idm8297783168
 *
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo;

use \whotrades\BitbucketApi\Resources\Base;
use \whotrades\BitbucketApi\Entity;
use \whotrades\BitbucketApi\Exception;
use \whotrades\BitbucketApi\Response\ResponseDiff;
use whotrades\BitbucketApi\Resources\DiffBase;

class Diff extends DiffBase
{
    /**
     * {@inheritdoc}
     */
    public function getList($parameters = null)
    {
        if (empty($parameters['path'])) {
            throw new \DomainException("Parameter 'path' is required.");
        }

        self::$resourceBaseUrl .= '/' . trim($parameters['path'], '/');
        unset($parameters['path']);

        return parent::getList($parameters);
    }
}
