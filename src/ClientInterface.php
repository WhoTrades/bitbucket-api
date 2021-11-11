<?php
declare(strict_types=1);

namespace whotrades\BitbucketApi;

interface ClientInterface
{
    /**
     * @param string $url
     * @param string $method
     * @param array $request
     *
     * @return array|string
     */
    public function sendRequest(string $url, string $method, array $request);
}
