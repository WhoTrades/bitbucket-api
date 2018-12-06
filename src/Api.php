<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi;

class Api extends Resources\Base
{
    /**
     * @param string $projectKey
     *
     * @return Resources\Project
     */
    public function getProject($projectKey)
    {
        return new Resources\Project($this->client, $projectKey);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return \StdClass::class;
    }
}
