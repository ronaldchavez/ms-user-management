<?php 
namespace App\Console\Commands\NewService;
use App\Console\Commands\NewService\Templates\ControllerTemplate;
use App\Console\Commands\NewService\Templates\ValidationTemplate;
use App\Console\Commands\NewService\Templates\RepositoryTemplate;
use App\Console\Commands\NewService\Templates\TestUnitTemplate;
use App\Console\Commands\NewService\Templates\ServiceTemplate;

class Generator
{
    public function generate(string $serviceMethod)
    {   
        try{
            [$service, $method] = explode('/', $serviceMethod);
        }catch(\Exception $e){
            exit('Formato de Servicio/Metodo incorrecto');
        }
        
        $service=ucfirst($service);
        $method=ucfirst($method);

        $this->createDirectory("app/Validations/$service");
        $validationTemplate=new ValidationTemplate();
        $this->createFile("app/Validations/$service/$method"."Validation.php", $validationTemplate->getTemplateValidation($service,$method));

        $baseDirectory="app/Http/Controllers/$service";
        $this->createDirectory($baseDirectory);
        $controllerTemplate=new ControllerTemplate();
        $this->createFile("$baseDirectory/$method"."Controller.php", $controllerTemplate->getTemplateController($service,$method));
        
        $baseDirectory="tests/Feature/$service";
        $this->createDirectory($baseDirectory);
        $testUnitTemplate=new TestUnitTemplate();
        $this->createFile("$baseDirectory/$service$method"."Test.php", $testUnitTemplate->getTestUnitTemplate($service,$method));
        
        $baseDirectory="app/Services/$service";
        $this->createDirectory($baseDirectory);
        $serviceTemplate=new ServiceTemplate();
        $this->createFile("$baseDirectory/$method"."Service.php", $serviceTemplate->getTemplateService($service,$method));

        $repositoryTemplate=new RepositoryTemplate();
        $this->createFile("app/Repositories/$service"."Repository.php", $repositoryTemplate->getTemplateRepository($service,$method));
        $this->addRoute($service,$method);
    }

    private function createDirectory(string $path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }
    }

    private function createFile(string $path, string $content): void
    {
        if (!file_exists($path)) {
            file_put_contents($path, $content);
        }
    }
    

    private function addRoute($service,$method){ 
        $methodMinus=lcfirst($method);
        $serviceMinus=lcfirst($service);
        
        $route ='
Route::get("/'.$serviceMinus.'/'.$methodMinus.'", "'.$service.'\\'.$method.'Controller");';
        
        $archive="routes/api.php";

        file_put_contents($archive, $route . PHP_EOL, FILE_APPEND);
    }
}