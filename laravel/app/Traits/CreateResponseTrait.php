<?php

namespace App\Traits;
  
trait CreateResponseTrait {

    public function createResponse(
        $success,
        $message,
        $data = []
    ) {

        return [
            'success' => $success,
            'message' => $message,
            'data' => $data
        ];
    }

}
