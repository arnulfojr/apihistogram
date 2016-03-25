<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Fetcher;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Exception\ApiHistogramException;
use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Message\FutureResponse;
use \GuzzleHttp\Ring\Exception\ConnectException as RingConnectException;

/**
 * Class Fetcher
 * @package ApiHistogram\ApiHistogramBundle\Services\Fetcher
 */
class Fetcher implements FetcherInterface
{
    /** @var null|Client $client */
    protected $client = NULL;

    /**
     * @param SiteCapsuleInterface|NULL $siteCapsule
     * @param array|NULL $args
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     * @throws ApiHistogramException
     */
    public function fetch(SiteCapsuleInterface $siteCapsule = NULL, array $args = NULL)
    {
        $this->setUp();

        try
        {
            $url = $siteCapsule->getURL();

            /** @var FutureResponse $request */
            $request = $this->client->get($url->getAsString(), ['future'=>True]); //async call

//            $request->then(
//                function($response)
//                {
//                    /** @var Response $response */
//                    echo $response->getStatusCode();
//                },
//                function(PHPException $error)
//                {
//                    throw new ApiHistogramException(
//                        "Fetching error",
//                        $error->getCode(),
//                        $error
//                    );
//                });
        }
        catch (RingConnectException $e)
        {
            throw new ApiHistogramException(
                ExceptionParameters::getConnectionError($e->getMessage()),
                ExceptionParameters::CONNECTION_ERROR_CODE,
                $e
            );
        }
        catch (ConnectException $e)
        {
            throw new ApiHistogramException(
                ExceptionParameters::getConnectionError($e->getMessage()),
                ExceptionParameters::CONNECTION_ERROR_CODE,
                $e
            );
        }

        return $request;
    }

    /**
     * @throws ApiHistogramException
     */
    protected function setUp()
    {
        if (is_null($this->client))
        {
            try
            {
                $this->client = new Client();
            }
            catch (ConnectException $e)
            {
                throw new ApiHistogramException(
                    ExceptionParameters::getConnectionError($e->getMessage()),
                    ExceptionParameters::CONNECTION_ERROR_CODE,
                    $e
                );
            }
            catch (RingConnectException $e)
            {
                throw new ApiHistogramException(
                    ExceptionParameters::getConnectionError($e->getMessage()),
                    ExceptionParameters::CONNECTION_ERROR_CODE,
                    $e
                );
            }
        }
    }

}