<?php
/**
 * File RecordCommand.php
 *
 * @category
 * @package
 * @author    Ivanis Kouamé <ivanis.kouame@smile.fr>
 * @copyright 2015 Smile
 */

namespace Hipay\SilexIntegration\Command\Vendor;


use Hipay\MiraklConnector\Vendor\Processor;
use Hipay\SilexIntegration\Command\AbstractCommand;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RecordCommand extends AbstractCommand
{
    const EMAIL = 'email';
    const MIRAKLID = 'miraklId';

    /** @var  Processor */
    protected $processor;

    /**
     * RecordCommand constructor.
     * @param LoggerInterface $logger
     * @param Processor $vendorProcessor
     */
    public function __construct(LoggerInterface $logger, Processor $vendorProcessor)
    {
        parent::__construct($logger);
        $this->vendorProcessor = $vendorProcessor;
    }

    protected function configure()
    {
        $this->setName('vendor:record')
            ->setDescription('Update the vendors data')
            ->addArgument(self::EMAIL, InputArgument::REQUIRED, 'The email of the shop')
            ->addArgument(self::MIRAKLID, InputArgument::REQUIRED, 'The mirakl Shop Id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->processor->recordVendor($input->getArgument(self::EMAIL), $input->getArgument(self::MIRAKLID));
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}