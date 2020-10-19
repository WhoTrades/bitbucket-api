<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
declare(strict_types=1);

namespace whotrades\BitbucketApi;

class Api extends Resources\Base
{
    /**
     * @param string $projectKey
     *
     * @return Resources\Project
     */
    public function getProject($projectKey): Resources\Project
    {
        return new Resources\Project($this->client, $projectKey);
    }

    /**
     * @param string|null $userSlug
     *
     * @return Resources\User
     */
    public function getUser($userSlug = null): Resources\User
    {
        return new Resources\User($this->client, $userSlug);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return \StdClass::class;
    }
}
