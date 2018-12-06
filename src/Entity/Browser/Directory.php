<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi\Entity\Browser;

use whotrades\BitbucketApi\Entity\Base;

class Directory extends Base
{
    const CHILD_TYPE_FILE = 'FILE';
    const CHILD_TYPE_DIRECTORY = 'DIRECTORY';

    protected $path;
    protected $children;

    /**
     * {@inheritdoc}
     */
    protected function init($data)
    {
        $this->path = new Path($data['path']);
        $this->children = [];
        foreach ($data['children'] as $child) {
            $this->children[$child['type']][] = $child['path']['name'];
        }
    }

    /**
     * @return Path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array[self::CHILD_TYPE_FILE => [...], self::CHILD_TYPE_DIRECTORY => [...]]
     */
    public function getChildren()
    {
        return $this->children;
    }
}
