<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Fetcher\Response;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use GuzzleHttp\Message\FutureResponse;

/**
 * Interface HandlerInterface
 * @package ApiHistogram\ApiHistogramBundle\Services\Fetcher\Response
 */
interface HandlerInterface
{
    /**
     * @param FutureResponse $response
     * @param SiteCapsuleInterface $capsule
     * @return mixed
     */
    public function handle(FutureResponse $response, SiteCapsuleInterface $capsule);

    /**
     * @param $mixed
     * @return HandlerInterface
     */
    public function setIO($mixed);

}