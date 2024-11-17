<?php

    it("/api/example/list", function () {
        $response=$this->get("/api/example/list")->assertStatus(200);
        $responseData = json_decode($response->getContent(), true);
    
        $expectedOutput = [
            "success" => true,
            "code" => 200,
            "message" => "Success",
            "data" => "PRUEBA EXITOSA DESDE REPOSITORIO",
        ];
        expect($responseData)->toBe($expectedOutput);
    });
        