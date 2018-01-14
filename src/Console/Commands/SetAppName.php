<?php
namespace LaravelRocket\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class SetAppName extends Command
{
    protected $signature   = 'rocket:set:name {name}';

    protected $name        = 'rocket:set:name';

    protected $description = 'Set Application Name';

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;

    /**
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(
        Filesystem $files
    ) {
        $this->files = $files;
        parent::__construct();
    }

    /**
     * @return bool
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $name    = $this->argument('name');
        $path    = config_path('site.php');
        $content = $this->files->get($path);

        $content = str_replace('%%NAME%%', $name, $content);
        $this->files->put($path, $content);

        return true;
    }
}
