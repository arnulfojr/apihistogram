<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Fetcher\Response;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Services\Persist\PersistInterface;
use GuzzleHttp\Message\FutureResponse;
use \Exception as PHPException;
use GuzzleHttp\Message\Response;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Handler
 * @package ApiHistogram\ApiHistogramBundle\Services\Fetcher\Response
 */
class Handler implements HandlerInterface
{
    /** @var PersistInterface $persist */
    private $persist;
    /** @var null|SymfonyStyle $io */
    private $io = NULL;

    /**
     * Handler constructor.
     * @param PersistInterface $persist
     */
    public function __construct(PersistInterface $persist = null)
    {
        $this->persist = $persist;
    }

    /**
     * @param SymfonyStyle $io
     * @return $this
     */
    public function setIO($io)
    {
        $this->io = $io;

        return $this;
    }

    /**
     * @param FutureResponse $response
     * @param SiteCapsuleInterface $capsule
     * @return mixed
     */
    public function handle(FutureResponse $response, SiteCapsuleInterface $capsule)
    {
        $io = $this->io;

        $response
            ->then(
                function (Response $response) use ($capsule, $io)
                {
                    if ($response->getStatusCode() === 200)
                    {
                        if (!is_null($io))
                        {
                            $io->success("{$capsule->getName()} got response, {$response->getStatusCode()}, will persist data");
                        }

                        // persist
                        $this->persist->persist($capsule, $response, $io);

                        return;
                    }

                    // handle server error
                    if (!is_null($io))
                    {
                        $io->error("Response Status code is not valid, {$response->getStatusCode()}");
                    }
                },
                function (PHPException $error) use ($capsule, $io)
                {
                    if (!is_null($io))
                    {
                        $io->error("Error while fetching, {$capsule->getName()}, with description: {$error->getMessage()}");
                    }
                }
            );
    }

    /**
     * @param string $text
     */
    protected function logInConsole($text)
    {
        if (!is_null($this->io))
        {
            $this->io->note($text);
        }
    }

}