<?php

namespace App\Console\Commands\NewService;

use Illuminate\Console\Command;

class NewServiceCommand extends Command
{
    /**
     * The name and signature of the command.
     *
     * @var string
     */
    protected $signature = 'new:service {name}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Crea un nuevo servicio';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $generator = new Generator();
        $generator->generate($name);

        $this->info('Servicio creado exitosamente');

        return 0;
    }
}


