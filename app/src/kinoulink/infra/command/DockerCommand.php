<?php

namespace kinoulink\infra\command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DockerCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('docker')
            ->setDescription('Execute remote docker command.')
            ->addArgument('host', InputArgument::REQUIRED, 'The Docker host')
            ->addArgument('cmd', InputArgument::REQUIRED, 'The command to execute')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputHost      = $input->getArgument('host');
        $inputCommand   = $input->getArgument('cmd');

        $hosts = $this->getApplication()->getConfig('hosts');
        $host  = $hosts[$inputHost];

        $sshSession = ssh2_connect($host['uri'], $host['port']);

        ssh2_auth_pubkey_file($sshSession, 'tom', '~/.ssh/azure-public.key', '~/.ssh/azure-private.key');

        $outStream = ssh2_exec($sshSession, 'docker ' . $inputCommand);
        $errorStream = ssh2_fetch_stream($outStream, SSH2_STREAM_STDERR);

        stream_set_blocking($errorStream, true);
        stream_set_blocking($outStream, true);

        $outputOut = stream_get_contents($outStream);
        $outputError = stream_get_contents($errorStream);

        fclose($errorStream);
        fclose($outStream);

        if (!empty($outputError))
        {
            $output->writeln('<error>' . $outputError . '</error>');
        }

        $output->writeln($outputOut);
    }
}