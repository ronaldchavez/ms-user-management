<?php

    namespace App\Validations\Example;
    
    use App\Validations\Validation;
    use Illuminate\Http\Request;
    class ListValidation extends Validation
    {
        public function __invoke(Request $request) {

            return $this->validate($request,$this->rules());
            
        }
        private function rules(){
            return [
                //RULES 
            ];
        }
    
    }