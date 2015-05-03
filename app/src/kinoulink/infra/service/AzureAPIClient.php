<?php

namespace kinoulink\infra\service;


use GuzzleHttp\Client;

class AzureAPIClient
{
    private $hosts;

    public function __construct($hosts)
    {
        $this->hosts = $hosts;
    }

    public function call($service)
    {
        $transport = new Client();

        $r = $transport->get('https://management.core.windows.net//' . $service, [
            'cert' => ROOT . '/../cert/azure.pem'
        ]);

        var_dump($r);
    }


    /**
     * @param $host
     * @param $command
     * @return string
     * @throws \Exception
     */
    public function exec($host, $command)
    {
        $host  = $this->hosts[$host];

        $sshSession = ssh2_connect($host['uri'], $host['port']);

        ssh2_auth_pubkey_file($sshSession, 'tom', '~/.ssh/azure-public.key', '~/.ssh/azure-private.key');

        $outStream = ssh2_exec($sshSession, $command);
        $errorStream = ssh2_fetch_stream($outStream, SSH2_STREAM_STDERR);

        stream_set_blocking($errorStream, true);
        stream_set_blocking($outStream, true);

        $outputOut = stream_get_contents($outStream);
        $outputError = stream_get_contents($errorStream);

        fclose($errorStream);
        fclose($outStream);

        if (!empty($outputError))
        {
            throw new \Exception($outputError);
        }

        return $outputOut;
    }
}