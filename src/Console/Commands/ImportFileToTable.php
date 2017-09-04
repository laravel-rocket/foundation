<?php
namespace LaravelRocket\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
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

        if (!empty($this->option('columns'))) {
            $columnNames = explode(',', $this->option('columns'));
        } else {
            $columnInformation = \DB::select('show columns from '.$tableName);
            if ($includeId) {
                $columnNames[] = 'id';
            }
            foreach ($columnInformation as $entity) {
                if ($entity->Field !== 'id') {
                    $columnNames[] = $entity->Field;
                }
            }
        }

        $excel = app()->make(Excel::class);
        $excel->filter('chunk')->load($filePath)->chunk(250, function ($results) use ($tableName, $columnNames) {
            foreach ($results as $row) {
                $data = [];
                foreach ($columnNames as $columnName) {
                    if (array_key_exists($columnName, $row)) {
                        $data[$columnName] = $row[$columnName];
                    }
                }
                \DB::table($tableName)->insert($data);
            }
        });

        return true;
    }
}
