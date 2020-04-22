<?php
namespace Sadiq;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandHandler extends Command
{
    protected static $defaultName = 'refactor';

    protected function configure()
    {
        $this->setDescription('refactor');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $readerService = new ReaderService();
        $currencyService = new CurrencyService($readerService);
        echo $currencyService->isBaseCurrency('AT');


        $output->writeln('');
        return 0;
    }
}