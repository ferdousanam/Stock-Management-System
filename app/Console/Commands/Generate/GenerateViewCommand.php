<?php

namespace App\Console\Commands\Generate;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:view {view} {--title=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate View Command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $resourcePath = $this->argument('view');
        $structDir = in_array('admin', explode('.', $resourcePath)) ? 'admin' : 'web';
        $resource = ['index', 'create', 'edit', 'form', 'show'];
        foreach ($resource as $chunk) {
            $file = resource_path('/views/' . $structDir . '/snippets/' . $chunk . '.blade.php');
            $viewPath = $resourcePath . '.' . $chunk;
            $path = $this->viewPath($viewPath);
            $this->createDir($path);
            $data = [
                'pageTitle' => $this->option('title') ?? ucfirst($chunk),
                'pageResource' => $resourcePath,
            ];

            $output = '';
            $output .= $this->template($file, $data);

            File::put($path, $output);
            $this->info("File {$path} created");
        }
        return 0;
    }

    /**
     * Get the view full path.
     *
     * @param string $view
     *
     * @return string
     */
    public function viewPath($view)
    {
        $view = str_replace('.', '/', $view) . '.blade.php';

        $path = "resources/views/{$view}";

        return $path;
    }

    /**
     * Create view directory if not exists.
     *
     * @param $path
     */
    public function createDir($path)
    {
        $dir = dirname($path);

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    public function template($file, $args)
    {
        // ensure the file exists
        if (!file_exists($file)) {
            return '';
        }

        // Make values in the associative array easier to access by extracting them
        if (is_array($args)) {
            extract($args);
        }

        // buffer the output (including the file is "output")
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
