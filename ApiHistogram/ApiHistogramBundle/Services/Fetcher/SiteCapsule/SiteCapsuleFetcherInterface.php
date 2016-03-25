<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Fetcher\SiteCapsule;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Services\Fetcher\FetcherInterface;

/**
 * Interface SiteCapsuleFetcherInterface
 * @package ApiHistogram\ApiHistogramBundle\Services\Fetcher
 */
interface SiteCapsuleFetcherInterface extends FetcherInterface
{
    /**
     * @param SiteCapsuleInterface $siteCapsuleInterface
     * @return SiteCapsuleFetcherInterface
     */
    public function setSiteCapsule(SiteCapsuleInterface $siteCapsuleInterface);

    /**
     * @return SiteCapsuleInterface
     */
    public function getSiteCapsule();

}