<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Update;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Services\Fetcher\FetcherInterface;
use ApiHistogram\ApiHistogramBundle\Services\Fetcher\Response\HandlerInterface;
use GuzzleHttp\Message\FutureResponse;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ApiUpdater
 * @package ApiHistogram\ApiHistogramBundle\Services\Persist
 */
class ApiUpdater implements UpdaterInterface
{
    /** @var FetcherInterface $fetcher */
    private $fetcher;
    /** @var HandlerInterface $handler */
    private $handler;
    /** @var SymfonyStyle $io */
    protected $io;

    /**
     * ApiUpdater constructor.
     * @param FetcherInterface $fetcher
     * @param HandlerInterface $handler
     */
    public function __construct(FetcherInterface $fetcher, HandlerInterface $handler)
    {
        $this->fetcher = $fetcher;
        $this->handler = $handler;
    }

    /**
     * @param SymfonyStyle $io
     */
    public function setIO(SymfonyStyle $io)
    {
        $this->io = $io;
    }

    /**
     * @param SiteCapsuleInterface $capsule
     * @return mixed|void
     */
    public function update(SiteCapsuleInterface $capsule)
    {
        /** @var FutureResponse $request */
        $request = $this->fetcher->fetch($capsule);

        if (!is_null($this->io))
        {
            $this->handler->setIO($this->io);
            $this->io->text("Will handle '{$capsule->getName()}''");
        }

        $this->handler->handle($request, $capsule);
    }

}