<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD (Controller, Model, Migration, Views)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name');
        $pluralName = strtolower(Str::plural($name));
        $timestamp = date('Y_m_d_His');

        $this->generateFile("app/Models/$name.php", 'model', ['{{ class }}' => $name]);
        $this->generateFile("database/migrations/{$timestamp}_create_{$pluralName}_table.php", 'migration', ['{{ table }}' => $pluralName]);
        $this->generateFile("app/Http/Controllers/Admin/{$name}Controller.php", 'admin/controller', [
            '{{ class }}' => "{$name}Controller",
            '{{ model }}' => $name,
            '{{ route }}' => $pluralName,
        ]);
        $this->generateFile("app/Policies/{$name}Policy.php", 'policy', ['{{ class }}' => $name]);

        $viewsPath = resource_path("views/admin/$pluralName");
        File::ensureDirectoryExists($viewsPath, 0755);

        foreach (['index', 'create'] as $template) {
            $this->generateFile("resources/views/admin/$pluralName/$template.blade.php", "views/admin/$template", [
                '{{ name }}' => $name,
                '{{ route }}' => $pluralName,
            ]);
        }

        $this->addRoute($pluralName, $name);

        $this->info('CRUD generation completed successfully!');
        return 0;
    }

    /**
     * Generate a file from a stub.
     */
    private function generateFile(string $path, string $stubName, array $replacements): void
    {
        $stubPath = base_path("stubs/$stubName.stub");

        if (!File::exists($stubPath)) {
            $this->error("Stub not found: $stubPath");
            return;
        }

        $content = str_replace(array_keys($replacements), array_values($replacements), File::get($stubPath));
        File::put(base_path($path), $content);
        $this->info("File created: $path");
    }

    /**
     * Add resource route to the routes file.
     */
    private function addRoute(string $pluralName, string $name): void
    {
        $routeFilePath = base_path('routes/web.php');

        if (!File::exists($routeFilePath)) {
            $this->error('Routes file not found.');
            return;
        }

        $routeDefinition = "Route::resource('/admin/{$pluralName}', \App\Http\Controllers\Admin\{$name}Controller::class);\n";
        File::append($routeFilePath, $routeDefinition);
        $this->info("Route added: $routeDefinition");
    }
}
