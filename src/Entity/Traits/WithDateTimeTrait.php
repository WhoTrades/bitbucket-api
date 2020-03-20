<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */

namespace whotrades\BitbucketApi\Entity\Traits;

use \DateTime;

trait WithDateTimeTrait
{

    /**
     * @param int $timestampWithMilliseconds
     *
     * @return DateTime|false
     */
    protected function createDateTimeByMillisecond($timestampWithMilliseconds)
    {
        return DateTime::createFromFormat('U.u', sprintf("%01.3f", $timestampWithMilliseconds/1000));
    }
}