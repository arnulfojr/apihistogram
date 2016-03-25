<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Fetcher\SiteCapsule;


use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Services\Fetcher\Fetcher;
use GuzzleHttp\Message\FutureResponse;

/**
 * Class SiteCapsuleFetcher
 * @package ApiHistogram\ApiHistogramBundle\Services\Fetcher\SiteCapsule
 */
class SiteCapsuleFetcher extends Fetcher implements SiteCapsuleFetcherInterface
{
    /** @var SiteCapsuleInterface $siteCapsule */
    private $siteCapsule;

    /**
     * @param SiteCapsuleInterface $siteCapsule
     * @return SiteCapsuleFetcherInterface
     */
    public function setSiteCapsule(SiteCapsuleInterface $siteCapsule)
    {
        $this->siteCapsule = $siteCapsule;
        return $this;
    }

    /**
     * @return SiteCapsuleInterface
     */
    public function getSiteCapsule()
    {
        return $this->siteCapsule;
    }

    /**
     * @param SiteCapsuleInterface|NULL $siteCapsule
     * @param array|NULL $args
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     * @throws ApiHistogram\\ApiHistogramBundle\Exception\ApiHistogramException
     */
    public function fetch(SiteCapsuleInterface $siteCapsule = NULL, array $args = NULL)
    {
        $siteCapsule = $this->decideSiteCapsule($siteCapsule);
        /** @var FutureResponse $request */
        $request = parent::fetch($siteCapsule, $args);

        return $request;
    }

    /**
     * @param SiteCapsuleInterface $capsule
     * @return SiteCapsuleInterface
     */
    protected function decideSiteCapsule(SiteCapsuleInterface $capsule)
    {
        if (is_null($this->siteCapsule))
        {
            return $capsule;
        }

        return $this->siteCapsule;
    }

}