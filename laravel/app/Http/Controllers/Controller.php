<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function responseJson(bool $type, $response)
    {
        return $type ? $this->responseJsonSuccess($response) : $this->responseJsonError();
    }
    public function responseJsonSuccess($data = null, $message = "Success")
    {
        return json_encode([
            'success'  => true,
            'code'     => 200,
            'message'  => $message,
            'data'     => $data,
        ]);
    }

    public function responseJsonError($data = null, $message = "Error")
    {
        return json_encode([
            'success'  => false,
            'code'     => 500,
            'message'  => $message,
            'data'     => $data,
        ]);
    }

    public function responseMessageJson($data = [], $code = 200): JsonResponse
    {
        return new JsonResponse($data, $code);
    }
}