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
    protected $signature = 'app:create-crud {name}';

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

        // 0. создать модель
        $modelPath = app_path("Models/$name.php");
        $modelContent = $this->getModelTemplateContent($name);
        File::put($modelPath, $modelContent);
        $this->info("Model created: $modelPath");

        // 1. Создать миграцию
        $migrationPath = base_path("database/migrations/Create{$pluralName}Table.php");
        $migrationContent = $this->getMigrationTemplateContent($pluralName);
        File::put($migrationPath, $migrationContent);
        $this->info("Migration created: $migrationPath");

        // 2. Создать контроллер
        $controllerPath = app_path("Http/Controllers/Admin/{$name}Controller.php");
        $controllerContent = $this->getControllerTemplateContent([
            'class' => "{$name}Controller",
            'model' => $name,
            'route' => $pluralName,
        ]);
        File::put($controllerPath, $controllerContent);
        $this->info("Controller created: $controllerPath");

        // 3. Создать политику
        $policyPath = app_path("Policies/{$name}Policy.php");
        $policyContent = $this->getPolicyTemplateContent($name);
        File::put($policyPath, $policyContent);
        $this->info("Policy created: $policyPath");

        // 3. Создать директорию для представлений
        $viewsPath = resource_path("views/admin/$pluralName");
        if (!File::exists($viewsPath)) {
            File::makeDirectory($viewsPath, 0755, true);
        }

        // 4. Создать файлы представлений
        $viewTemplates = ['index', 'create'];
        foreach ($viewTemplates as $template) {
            $templatePath = "$viewsPath/$template.blade.php";
            $content = $this->getViewTemplateContent($template, $name, $pluralName);
            File::put($templatePath, $content);
            $this->info("View created: $templatePath");
        }

        $this->info('CRUD generation completed successfully!');
        return 0;
    }

    /**
     * Get the template content for views.
     */
    private function getViewTemplateContent(string $template, string $name, string $route): string
    {
        $filePath = base_path("stubs/views/admin/$template.stub");
        $content = File::get($filePath);
        return str_replace(['{{name}}', '{{route}}'], [$name, $route], $content);
    }

    private function getControllerTemplateContent($vars): string
    {
        $filePath = base_path("stubs/controllers/admin/controller.stub");
        $content = File::get($filePath);
        return str_replace(['{{ class }}', '{{ model }}', '{{ route }}'], $vars, $content);
    }

    private function getModelTemplateContent(string $name): string
    {
        $filePath = base_path("stubs/models/model.stub");
        $content = File::get($filePath);
        return str_replace(['{{ class }}'], [$name], $content);
    }

    private function getPolicyTemplateContent(string $name): string
    {
        $filePath = base_path("stubs/policies/policy.stub");
        $content = File::get($filePath);
        return str_replace(['{{ class }}'], [$name], $content);
    }

    private function getMigrationTemplateContent(string $pluralName): string
    {
        $filePath = base_path("stubs/migrations/migration.stub");
        $content = File::get($filePath);
        return str_replace(['{{ table }}'], [$pluralName], $content);
    }
}
