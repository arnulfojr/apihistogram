<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Fetcher;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;

/**
 * Interface FetcherInterface
 * @package ApiHistogram\ApiHistogramBundle\Services\Fetcher
 */
interface FetcherInterface
{
    /**
     * @param SiteCapsuleInterface|NULL $siteCapsuleInterface
     * @param array|NULL $args
     * @return mixed
     */
    public function fetch(SiteCapsuleInterface $siteCapsuleInterface = NULL, array $args = NULL);
}