<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\Commit;

use whotrades\BitbucketApi\Entity;

class Committer extends Entity\Base
{
    protected $name;
    protected $emailAddress;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->name = $data['name'];
        $this->emailAddress = $data['emailAddress'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
}
