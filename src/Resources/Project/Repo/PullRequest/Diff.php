<?php
/**
 * Resource for http://example.com/rest/api/1.0/projects/{projectKey}/repos/{repositorySlug}/pull-requests/{pullRequestId}/diff/{path:.*}
 *
 * @see https://docs.atlassian.com/bitbucket-server/rest/5.16.0/bitbucket-rest.html#idm8297315424
 *
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources\Project\Repo\PullRequest;

use whotrades\BitbucketApi\Resources\DiffBase;

class Diff extends DiffBase
{
}
