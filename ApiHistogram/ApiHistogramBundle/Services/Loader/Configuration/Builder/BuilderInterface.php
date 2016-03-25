<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder;

/**
 * Interface BuilderInterface
 * @package ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder
 */
interface BuilderInterface
{
    /**
     * @param array $options
     * @return mixed
     */
    public function build($options = NULL);
}