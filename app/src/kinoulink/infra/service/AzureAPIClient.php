<?php

namespace kinoulink\infra\service;


use GuzzleHttp\Client;

class AzureAPIClient
{
    public function call($service)
    {
        $transport = new Client();

        $r = $transport->get('https://management.core.windows.net//' . $service, [
            'cert' => ROOT . '/../cert/azure.pem'
        ]);

        var_dump($r);
    }
}