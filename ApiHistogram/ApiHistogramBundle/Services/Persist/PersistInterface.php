<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Persist;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;

/**
 * Interface PersistInterface
 * @package ApiHistogram\ApiHistogramBundle\Services\Persist
 */
interface PersistInterface
{
    /**
     * @param SiteCapsuleInterface $capsule
     * @param $response
     * @param null $io
     * @return array|void
     */
    public function persist(SiteCapsuleInterface $capsule, $response, $io = NULL);
}