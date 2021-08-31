<?php

namespace App\Commands;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use LaravelZero\Framework\Commands\Command;
use LaravelZero\Framework\Exceptions\ConsoleException;

class ConfigGenerateCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'config:generate
                            {source : The template source dir}
                            {destination : The template destination dir}
                            {--configFile= : The default configuration file (Yaml)}
                            {--mergeFile= : Comma separated list of configuration files (merged with the default configuration) (Yaml)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Generate configuration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $source = $this->argument('source');
        $destination = $this->argument('destination');

        if (!file_exists($source)) {
            throw new ConsoleException(1, "Source directory does not exist.");
        }

        if (!file_exists($destination)) {
            throw new ConsoleException(2, "Destination directory does not exist.");
        }

        $config = $mergeConfig = [];
        $configFile = $this->option('configFile');
        $mergeFiles = explode(',', $this->option('mergeFile'));

        if ($configFile && file_exists($configFile)) {
            $config = Yaml::parseFile($configFile);
            Log::info("Loading default configuration from $configFile");
        }

        foreach ($mergeFiles as $mergeFile) {
            if ($mergeFile && file_exists($mergeFile)) {
                $mergeConfig = Yaml::parseFile($mergeFile);
                $config = $this->mergeConfig($config, $mergeConfig);
                Log::info("Loading app configuration from $mergeFile");
            }
        }

        Log::info("Loading templates from $source");
        $files = File::allFiles($source);

        Log::info("Generating config to $destination");
        foreach ($files as $file) {
            if (strpos($file, 'includes/') === false) {
                Config::set('view.paths', [$source]);
                $content = View::file($file, $config);
                $destFile = $destination . str_replace([".blade.php", $source], "", $file);
                if (!file_exists(File::dirname($destFile))) {
                    File::makeDirectory(File::dirname($destFile), 0755, true);
                }
                File::put($destFile, $content);
            }
        }
    }

    /**
     * Merge array recursively.
     *
     * @param array $array1
     * @param array $array2
     * @return void
     */
    function mergeConfig(array &$array1, array &$array2)
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (
                is_array($value) &&
                isset($merged[$key]) && is_array($merged[$key]) &&
                count(array_filter(array_keys($value), 'is_string')) > 0
            ) {
                $merged[$key] = $this->mergeConfig($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }
}
