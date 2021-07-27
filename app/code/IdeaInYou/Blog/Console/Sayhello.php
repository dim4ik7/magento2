<?php

namespace IdeaInYou\Blog\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Sayhello extends Command
{
    protected function configure()
    {
        $options = [
            new InputOption(
                'message',
                null,
                InputOption::VALUE_OPTIONAL,
                'Name'
            )
        ];

        $this->setName('ideainyou:hello')
            ->setDescription('IdeaInYou command line')
            ->setDefinition($options);

        parent::configure();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($name = $input->getOption('message')) {
            $output->writeln("Hello " . $name);
        } else {
            $output->writeln("Hello World");
        }
        return $this;
    }
}
