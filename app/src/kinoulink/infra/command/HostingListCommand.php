<?php

namespace kinoulink\infra\command;


use kinoulink\infra\service\AzureAPIClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HostingListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('host:list')
            ->setDescription('List available hosts.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach($this->getApplication()->getConfig('hosts') as $host => $data)
        {
            $output->writeln($host . ' => ' . $data['uri'] . ':' . $data['port']);
        }
    }


}