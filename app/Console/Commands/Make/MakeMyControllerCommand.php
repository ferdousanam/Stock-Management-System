<?php

namespace App\Console\Commands\Make;

use Illuminate\Routing\Console\ControllerMakeCommand;

class MakeMyControllerCommand extends ControllerMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:mycon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom controller class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/controller.my.stub');
    }
}
