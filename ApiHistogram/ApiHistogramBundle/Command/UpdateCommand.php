<?php

namespace ApiHistogram\ApiHistogramBundle\Command;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Exception\ApiHistogramException;
use ApiHistogram\ApiHistogramBundle\Exception\Command\CommandException;
use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use ApiHistogram\ApiHistogramBundle\Services\SiteManager\SiteManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class UpdateCommand
 * @package ApiHistogram\ApiHistogramBundle\Command
 */
class UpdateCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('api-histogram:update')
            ->setDescription("Updates the API' s")
            ->addOption(
                'debug',
                'd',
                InputOption::VALUE_OPTIONAL,
                'Activate debug mode'
            )
            ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        try
        {
            $siteManager = $this->getContainer()->get('api_histogram.site_manager');
            $siteManager->setUp();

            $siteCapsules = $this->loadCapsules($siteManager, $io);

            // Load the data for each
            $this->processSiteCapsules($siteCapsules, $io);

        }
        catch (CommandException $e)
        {
            $io->error($e->getMessage());

            return 1;
        }

        return 0;
    }

    /**
     * @param SiteManager $siteManager
     * @param SymfonyStyle $io
     * @return array
     * @throws CommandException
     */
    protected function loadCapsules(SiteManager $siteManager, SymfonyStyle $io)
    {
        try
        {
            $io->note("Loading sites configuration...");
            $capsules = $siteManager->getSites();
            $count = count($capsules);
            $io->note("Got {$count} sites.");

            return $capsules;
        }
        catch (ApiHistogramException $e)
        {
            throw new CommandException(
                ExceptionParameters::getCommandLoadingSitesMessage($e->getMessage()),
                ExceptionParameters::COMMAND_LOADING_SITES_CODE,
                $e
            );
        }
    }

    /**
     * @param array $siteCapsules
     * @param SymfonyStyle $io
     * @throws CommandException
     */
    protected function processSiteCapsules(array $siteCapsules, SymfonyStyle $io)
    {
        try
        {
            $count = count($siteCapsules);
            $io->note("Will fetch the data from {$count} site(s)...");

            /**
             * Load the sites data and save it
             * @var mixed $key
             * @var SiteCapsuleInterface $capsule
             */
            foreach ($siteCapsules as $key=>$capsule)
            {
                $io->text("Calling the updater...");
                $updater = $this->getContainer()->get('api_histogram.updater');

                $io->note("Will update: '{$key}''");
                $className = get_class($capsule->getCleaner());
                $io->text("Using cleaner: {$className}");
                $updater->setIO($io);
                $updater->update($capsule);
            }

            $io->note("Done calling API's");
        }
        catch (\Exception $e)
        {
            throw new CommandException(
                "{$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

}