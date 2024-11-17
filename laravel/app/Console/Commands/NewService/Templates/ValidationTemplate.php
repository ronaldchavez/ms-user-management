<?php
namespace App\Console\Commands\NewService\Templates;

class ValidationTemplate
{
    public function getTemplateValidation($service, $method)
    {
        $methodMinus = lcfirst($method);
        $serviceMinus = lcfirst($service);
        $code = '<?php

namespace App\Validations\\' . $service . ';

use App\Validations\Validation;
use Illuminate\Http\Request;
class ' . $method . 'Validation extends Validation
{
    public function __invoke(Request $request) {

        return $this->validate($request,$this->rules());
        
    }
    private function rules(){
        return [
            //RULES 
        ];
    }

}';
        return $code;
    }
}