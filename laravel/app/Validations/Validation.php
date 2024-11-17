<?php

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Validation
{
    public $data;
    public function validate(Request $request,$rules)
    {
        $this->data = $request->all();
        $validator  = Validator::make($this->data, $rules);

        if ($validator->fails()) {
            $this->data=$validator->errors()->all();
            
            return false;
            
        }
        return true;
        
    }
}