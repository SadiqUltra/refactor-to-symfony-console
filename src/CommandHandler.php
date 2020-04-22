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
        $output->writeln('Hello World');

        return 0;
    }
}