<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Update;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;

/**
 * Interface UpdaterInterface
 * @package ApiHistogram\ApiHistogramBundle\Services\Persist
 */
interface UpdaterInterface
{
    /**
     * @param SiteCapsuleInterface $siteCapsuleInterface
     * @return mixed
     */
    public function update(SiteCapsuleInterface $siteCapsuleInterface);
}