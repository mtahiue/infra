<?php

namespace kinoulink\infra;

use kinoulink\infra\service\AzureAPIClient;
use Symfony\Component\Console\Application as BaseApplication;


class Application extends BaseApplication
{
    private $config;

    private $services;

    public function __construct($config)
    {
        parent::__construct('Kinoulink infra', '1.0');

        $this->config = include(ROOT . '/../config/' . $config . '.php');

        $this->services = [
            'azure.client' => new AzureAPIClient()
        ];
    }

    public function getConfig($name)
    {
        return $this->config[$name];
    }

    public function getService($name)
    {
        return $this->services[$name];
    }
}