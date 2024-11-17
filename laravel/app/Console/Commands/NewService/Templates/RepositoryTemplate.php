<?php
namespace App\Console\Commands\NewService\Templates;

class RepositoryTemplate
{
    public function getTemplateRepository($service, $method)
    {
        $methodMinus = lcfirst($method);
        $serviceMinus = lcfirst($service);
        $code = '<?php

namespace App\Repositories;

// use App\Models\Example;

class ' . $service . 'Repository
{

    public function metodoDemo()
    {
        return "PRUEBA EXITOSA DESDE REPOSITORIO";
    }
}';
        return $code;
    }
}