<?php
namespace App\Console\Commands\NewService\Templates;

class ServiceTemplate
{
    public function getTemplateService($service, $method)
    {
        $methodMinus = lcfirst($method);
        $serviceMinus = lcfirst($service);
        $code = '<?php

namespace App\Services\\' . $service . ';

use App\Repositories\\' . $service . 'Repository;
use App\Validations\\' . $service . '\\' . $method . 'Validation;
use App\Services\Service;

class ' . $method . 'Service extends Service
{
    public $outData=[];

    public function __invoke($inputData) {

        $' . $serviceMinus . 'Repository  = new ' . $service . 'Repository();
        $this->outData     = $' . $serviceMinus . 'Repository->metodoDemo();
        return true;
        
    }

}
';
        return $code;
    }
}