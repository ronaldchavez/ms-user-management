<?php

    namespace App\Http\Controllers\Example;
    
    use App\Http\Controllers\Controller;
    use App\Services\Example\ListService;
    use App\Validations\Example\ListValidation;
    use Illuminate\Http\Request;
    
    class ListController extends Controller
    {

        public function __invoke(Request $request, ListValidation $listValidation, ListService $listService)
        {
            if($listValidation($request)){
                return $this->responseJson($listService($listValidation), $listService->outData);
            }
            return $this->responseJson(false,$listValidation->data);
        }
    
    }