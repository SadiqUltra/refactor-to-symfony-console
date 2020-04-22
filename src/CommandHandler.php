<?php
namespace Sadiq;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CommandHandler extends Command
{
    protected static $defaultName = 'refactor';

    private $readerService;
    private $currencyService;
    private $commissionService;

    protected function configure()
    {
        $this
            ->setDescription('refactor')
            ->addArgument('fileName', InputArgument::REQUIRED, 'input file name')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $readerService = new ReaderService();
        $commissionService = new CommissionsService($readerService);

        $inputFileName = $input->getArgument('fileName');


        foreach ($readerService->readInputFile($inputFileName) as $row) {
            if (empty($row)) break;
            echo $commissionService->getCommission($row) . PHP_EOL;
        }

        return 0;
    }
}