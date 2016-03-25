<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Persist;

use ApiHistogram\ApiHistogramBundle\Cleaners\CleanerInterface;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Exception\ApiHistogramException;
use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use ApiHistogram\ApiHistogramBundle\Repository\Dynamic\DynamicRepository;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Persist
 * @package ApiHistogram\ApiHistogramBundle\Services\Persist
 */
class Persist extends BasePersistent implements PersistInterface
{
    /**
     * Persist constructor.
     * @param DynamicRepository $repository
     */
    public function __construct(DynamicRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param SiteCapsuleInterface $capsule
     * @param $response
     * @param null $io
     * @throws ApiHistogramException
     * @return void
     */
    public function persist(SiteCapsuleInterface $capsule, $response, $io = NULL)
    {
        /** @var CleanerInterface $cleaner */
        $cleaner = $capsule->getCleaner();

        /** @var SymfonyStyle $io */

        if (!is_null($cleaner))
        {
            $cleanedResponse = $cleaner->clean($response);

            $toSave = $cleaner->structure($cleanedResponse);

            if (!is_null($io))
            {
                $io->note("Will persist data fetched for {$capsule->getName()}");
            }

            try
            {
                $this->save($capsule, $toSave, $io);

                if (!is_null($io))
                {
                    $io->success("{$capsule->getName()} data persisted");
                }
            }
            catch (ApiHistogramException $e)
            {
                if (!is_null($io))
                {
                    $io->error("Error while persisting {$capsule->getName()}");
                    $io->error($e->getMessage());
                }
            }

            return;
        }

        if (!is_null($io))
        {
            $io->error(ExceptionParameters::CLEANER_IS_NOT_VALID_MESSAGE);
        }

        throw new ApiHistogramException(
            ExceptionParameters::CLEANER_IS_NULL_MESSAGE,
            ExceptionParameters::CLEANER_IS_NULL_CODE
        );
    }

}