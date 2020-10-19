<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
declare(strict_types=1);

namespace whotrades\BitbucketApi\Resources;

use whotrades\BitbucketApi\Entity;

class User extends Base
{
    protected static $resourceBaseUrl = 'users';

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass(): string
    {
        return Entity\User::class;
    }
}
