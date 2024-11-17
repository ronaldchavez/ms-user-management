<?php

        namespace App\Services\Example;
        
        use App\Repositories\ExampleRepository;
        use App\Validations\Example\ListValidation;
        use App\Services\Service;
        
        class ListService extends Service
        {
            public $outData=[];

            public function __invoke($inputData) {

                $exampleRepository  = new ExampleRepository();
                $this->outData     = $exampleRepository->metodoDemo();
                return true;
                
            }
        
        }
        