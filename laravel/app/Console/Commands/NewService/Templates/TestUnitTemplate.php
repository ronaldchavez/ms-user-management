<?php
namespace App\Console\Commands\NewService\Templates;

class TestUnitTemplate
{
    public function getTestUnitTemplate($service, $method)
    {
        $methodMinus = lcfirst($method);
        $serviceMinus = lcfirst($service);
        $code = '<?php

it("/api/' . $serviceMinus . '/' . $methodMinus . '", function () {
    $response=$this->get("/api/' . $serviceMinus . '/' . $methodMinus . '")->assertStatus(200);
    $responseData = json_decode($response->getContent(), true);

    $expectedOutput = [
        "success" => true,
        "code" => 200,
        "message" => "Success",
        "data" => "PRUEBA EXITOSA DESDE REPOSITORIO",
    ];
    expect($responseData)->toBe($expectedOutput);
});
    ';
        return $code;
    }
}