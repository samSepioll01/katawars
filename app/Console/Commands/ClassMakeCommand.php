<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class ClassMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'make:class {className}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new Custom Class.';

    /**
     * The type of the command generated.
     * @var string
     */
    protected $type = 'Class';

    /**
     * Get the name passed as parameter for the trait.
     */
    protected function getNameInput(): string
    {
        return trim($this->argument('className'));
    }

    /**
     * Determines the name of the route for the trait.
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\CustomClasses';
    }

    /**
     * Determines the name of the trait's stub file.
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/class.stub';
    }

    /**
     * Show screen success message.
     */
    protected function showMessage(): void
    {
        $this->info("Class created succesfully. \n\n");
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        parent::handle();
        $this->showMessage();
        return Command::SUCCESS;
    }
}
