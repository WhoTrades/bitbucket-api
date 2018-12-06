<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Resources;

class Project extends Base
{
    protected static $resourceBaseUrl = 'projects';

    /**
     * @param string $repositorySlug
     *
     * @return Project\Repo
     */
    public function getRepo($repositorySlug)
    {
        return new Project\Repo($this->client, $repositorySlug, $this);
    }


    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return \StdClass::class;
    }
}
