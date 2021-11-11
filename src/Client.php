<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
namespace whotrades\BitbucketApi;

use \Psr\Log\LoggerInterface;
use \Psr\Http\Message\ResponseInterface;
use \GuzzleHttp\Client as HttpClient;
use \GuzzleHttp\Exception\RequestException;
use \whotrades\BitbucketApi\Exception;

class Client implements ClientInterface
{
    const HTTP_TIMEOUT = 90;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    protected $httpClient;

    protected $timeout = self::HTTP_TIMEOUT;

    /**
     * Client constructor.
     *
     * @param string $url
     * @param string $user
     * @param string $password
     * @param LoggerInterface | null $logger
     */
    public function __construct($url, $user, $password, LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? new \Psr\Log\NullLogger();

        $config = [
            'base_uri' => "{$url}/rest/api/1.0/",
            'timeout' => $this->timeout,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'allow_redirects' => true,
            'auth' => [$user, $password],
        ];
        $this->httpClient = new HttpClient($config);
    }

    /**
     * @param float $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $request
     *
     * @return array | string
     *
     * @throws Exception\JsonInvalidException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest(string $url, string $method, array $request)
    {
        try {
            $options = [\GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => $this->timeout];
            if (strtoupper($method) === 'GET') {
                $this->logger->debug("Sending GET request to $url, query=" . json_encode($request));
                /** @var ResponseInterface $response */
                $response = $this->httpClient->request('GET', $url, array_merge($options, ['query' => $request]));
            } else {
                $this->logger->debug("Sending $method request to $url, body=" . json_encode($request));
                $response = $this->httpClient->request($method, $url, array_merge($options, ['body' => json_encode($request)]));
            }
        } catch (RequestException $e) {
            //bitbucket error: it can't send more then 1mb of json data. So just skip suck pull requests or files
            $this->logger->debug("Request finished with error: " . $e->getMessage());
            if ($e->getMessage() === 'cURL error 56: Problem (3) in the Chunked-Encoded data') {
                throw new Exception\JsonFailureException($e->getMessage(), $e->getRequest(), $e->getResponse(), $e);
            }

            throw $e;
        }

        $this->logger->debug("Request finished");

        $responseContent = $response->getBody()->getContents();

        // an: пустой ответ - значит все хорошо
        if (empty($responseContent)) {
            return true;
        }

        $data = json_decode($responseContent, true);

        if ($data === null && $data !== 'null') {
            $context = [
                'url' => $url,
                'method' => $method,
                'request' => $request,
                'response' => $response,
                'response_content' => $responseContent,
            ];
            $this->logger->error("Invalid json received", $context);
            throw new Exception\JsonInvalidException($context);
        }

        return $data;
    }
}
