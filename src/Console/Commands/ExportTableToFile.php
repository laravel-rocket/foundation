<?php
namespace LaravelRocket\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Maatwebsite\Excel\Excel;

class ExportTableToFile extends Command
{
    protected $signature   = 'rocket:export:table {--format=} {--include_id} {--columns=} {table} {output_path}';

    protected $name        = 'rocket:export:table';

    protected $description = 'Export Database to CSV/Excel';

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
        $tableName  = $this->argument('table');
        $outputPath = $this->argument('output_path');
        $includeId  = $this->option('include_id');

        $format = strtolower($this->option('format'));
        if (!in_array($format, $this->supportFormats)) {
            $format = 'csv';
        }

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
        $data = [];

        $count  = \DB::table($tableName)->count();
        $limit  = 1000;
        $offset = 0;
        while ($offset < $count) {
            $entities = \DB::table($tableName)->offset($offset)->limit($limit)->orderBy('id', 'asc')->get();
            foreach ($entities as $entity) {
                $row = [];
                foreach ($columnNames as $columnName) {
                    $row[$columnName] = $entity->$columnName;
                }
                $data[] = $row;
            }
            $offset += $limit;
        }

        /** @var Excel $excel */
        $excel  = app()->make(Excel::class);
        $output = $excel->create($outputPath, function ($excel) use ($data, $tableName) {
            $excel->sheet($tableName, function ($sheet) use ($data) {
                $sheet->setStyle([
                    'font' => [
                        'name' => 'Arial',
                        'size' => 12,
                        'bold' => false,
                    ],
                ]);
                if (count($data) > 0) {
                    $sheet->fromArray($data);
                }
            });
        })->string($format);

        $this->files->put($outputPath, $output);

        return true;
    }
}
