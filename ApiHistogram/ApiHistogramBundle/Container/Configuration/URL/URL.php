<?php


namespace ApiHistogram\ApiHistogramBundle\Container\Configuration\URL;

/**
 * Class URL
 * @package ApiHistogram\ApiHistogramBundle\Container\Configuration\URL
 */
class URL implements URLContainerInterface
{
    /** @var string $url */
    private $url;

    /**
     * @param $url
     * @return URLContainerInterface
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getAsString()
    {
        return $this->url;
    }
}