<?php

namespace Sadiq;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CommandHandler
 * @package Sadiq
 */
class CommandHandler extends Command
{
    protected static $defaultName = 'refactor';

    protected function configure()
    {
        $this
            ->setDescription('refactor')
            ->addArgument('fileName', InputArgument::REQUIRED, 'input file name');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $readerService = new ReaderService();
        $commissionService = new CommissionsService($readerService);

        $inputFileName = $input->getArgument('fileName');


        // looping over rows from input file
        foreach ($readerService->readInputFile($inputFileName) as $row) {
            if (empty($row)) {
                break;
            }
            echo $commissionService->getCommission($row) . PHP_EOL;
        }

        return 0;
    }
}
