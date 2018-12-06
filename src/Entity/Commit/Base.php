<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\Commit;

use whotrades\BitbucketApi\Entity\Base as EntityBase;

class Base extends EntityBase
{
    protected $id;
    protected $displayId;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->id = $data['id'];
        $this->displayId = $data['displayId'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDisplayId()
    {
        return $this->displayId;
    }
}
