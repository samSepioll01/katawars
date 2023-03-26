<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class TraitMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'make:trait {traitName}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new trait.';

    /**
     * The type of the command generated.
     * @var string
     */
    protected $type = 'Trait';

    /**
     * Get the name passed as parameter for the trait.
     */
    protected function getNameInput(): string
    {
        return trim($this->argument('traitName'));
    }

    /**
     * Determines the name of the route for the trait.
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Traits';
    }

    /**
     * Determines the name of the trait's stub file.
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/trait.stub';
    }

    /**
     * Show screen success message.
     */
    protected function showMessage(): void
    {
        $this->info("Trait created succesfully. \n\n");
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
