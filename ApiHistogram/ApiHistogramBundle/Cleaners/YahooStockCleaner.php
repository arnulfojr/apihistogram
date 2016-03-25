<?php

namespace ApiHistogram\ApiHistogramBundle\Cleaners;

use ApiHistogram\ApiHistogramBundle\Cleaners\Helper\CleanerHelper;
use GuzzleHttp\Message\Response;

/**
 * Class YahooStockCleaner
 * @package ApiHistogram\ApiHistogramBundle\Cleaners
 */
class YahooStockCleaner extends CleanerHelper implements CleanerInterface
{

    /**
     * This method process the response data to remove all unnecessary fields in the response
     * @param $response
     * @return mixed
     */
    public function clean(Response $response)
    {
        $body = $response->json();
        $resources = $body["list"]["resources"];

        $cleaned = array_pop($resources);

        return $cleaned;
    }

    /**
     * This method processes the cleaned response from the clean($r) method, into a Doctrine
     * friendly format.
     * Consider this doctrine documentation:
     * http://doctrine-orm.readthedocs.org/projects/doctrine-dbal/en/latest/reference/data-retrieval-and-manipulation.html#insert
     * @param $response
     * @return mixed
     */
    public function structure($response)
    {
        $resource = $response["resource"];
        $fields = $resource["fields"];

        $ok = [
            "price"=>floatval($fields["price"]),
            "timestamp"=>floatval($fields["ts"]),
            "volume"=>floatval($fields["volume"])
        ];

        return $ok;
    }
}