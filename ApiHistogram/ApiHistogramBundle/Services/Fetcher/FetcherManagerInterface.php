<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Fetcher;

/**
 * Interface FetcherManagerInterface
 * @package ApiHistogram\ApiHistogramBundle\Services\Fetcher
 */
interface FetcherManagerInterface
{
    /**
     * @param array $siteCapsules
     * @return FetcherManagerInterface
     */
    public function setSiteCapsules(array $siteCapsules);

    /**
     * @return array
     */
    public function getSiteCapsules();

    /**
     * @param array|NULL $siteCapsules
     * @return mixed
     */
    public function fetch(array $siteCapsules = NULL);

}