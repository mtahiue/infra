<?php

namespace kinoulink\infra\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HostExecCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('host:exec')
            ->setDescription('Execute remote command.')
            ->addArgument('host', InputArgument::REQUIRED, 'The Docker host')
            ->addArgument('cmd', InputArgument::REQUIRED, 'The command to execute')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputHost      = $input->getArgument('host');
        $inputCommand   = $input->getArgument('cmd');

        try
        {
            $output->writeln($this->getApplication()->getService('azure.client')->exec($inputHost, $inputCommand));
        }
        catch(\Exception $e)
        {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }


}