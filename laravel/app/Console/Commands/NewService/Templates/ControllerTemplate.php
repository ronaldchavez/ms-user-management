<?php
namespace App\Console\Commands\NewService\Templates;

class ControllerTemplate
{
    public function getTemplateController($service, $method)
    {
        $methodMinus = lcfirst($method);
        $serviceMinus = lcfirst($service);
        $code = '<?php

namespace App\Http\Controllers\\' . $service . ';

use App\Http\Controllers\Controller;
use App\Services\\' . $service . '\\' . $method . 'Service;
use App\Validations\\' . $service . '\\' . $method . 'Validation;
use Illuminate\Http\Request;

class ' . $method . 'Controller extends Controller
{

    public function __invoke(Request $request, ' . $method . 'Validation $' . $methodMinus . 'Validation, ' . $method . 'Service $' . $methodMinus . 'Service)
    {
        if($' . $methodMinus . 'Validation($request)){
            return $this->responseJson($' . $methodMinus . 'Service($' . $methodMinus . 'Validation), $' . $methodMinus . 'Service->outData);
        }
        return $this->responseJson(false,$' . $methodMinus . 'Validation->data);
    }

}';
        return $code;
    }
}