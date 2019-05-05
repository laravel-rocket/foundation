<?php
namespace LaravelRocket\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;

class ImportFileToTable extends Command
{
    protected $signature   = 'rocket:import:file {--include_id} {--columns=} {table} {file_path}';

    protected $name        = 'rocket:import:file';

    protected $description = 'Import Database to CSV/TSV/Excel';

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;

    protected $supportFormats = ['csv', 'xlsx'];

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
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $tableName = $this->argument('table');
        $filePath  = $this->argument('file_path');

        $includeId = $this->option('include_id');

        $columnNames = [];

        $columnInformation = \DB::select('show columns from '.$tableName);
        if (!empty($this->option('columns'))) {
            $columnNames = explode(',', $this->option('columns'));
        } else {
            if ($includeId) {
                $columnNames[] = 'id';
            }
            foreach ($columnInformation as $entity) {
                if ($entity->Field !== 'id') {
                    $columnNames[] = $entity->Field;
                }
            }
        }
        $defaultValues = [];
        foreach ($columnInformation as $entity) {
            if ($entity->null === 'NO') {
                $type = $entity->Type;
                if (Str::startsWith($type, 'varchar') || Str::startsWith($type, 'char') || Str::startsWith($type, 'text')) {
                    $defaultValues[$entity->Field] = '';
                } else {
                    $defaultValues[$entity->Field] = 0;
                }
            }
        }

        $excel = app()->make(Excel::class);
        $excel->filter('chunk')->load($filePath)->chunk(250, function($results) use ($tableName, $columnNames, $defaultValues) {
            foreach ($results as $row) {
                $data = [];
                foreach ($columnNames as $columnName) {
                    if ($row->has($columnName) && !empty($row->get($columnName))) {
                        $data[$columnName] = $row->get($columnName);
                    } elseif (array_key_exists($columnName, $defaultValues)) {
                        $data[$columnName] = $defaultValues[$columnName];
                    }
                }
                \DB::table($tableName)->insert($data);
            }
        });

        return true;
    }
}
