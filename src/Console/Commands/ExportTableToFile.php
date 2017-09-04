<?php
namespace LaravelRocket\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Maatwebsite\Excel\Excel;

class ExportTableToFile extends Command
{
    protected $name        = 'rocket:export:file {--format=} {--include_id} {--columns=} {table} {output_path}';

    protected $description = 'Export Database to CSV/TSV/Excel';

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

        $columnNames       = [];
        $columnInformation = \DB::select('show columns from '.$tableName);
        if ($includeId) {
            $columnNames[] = 'id';
        }
        foreach ($columnInformation as $entity) {
            if ($entity->Field !== 'id') {
                $columnNames[] = $entity->Field;
            }
        }
        $data = [$columnNames];

        $count  = \DB::table($tableName)->count();
        $limit  = 1000;
        $offset = 0;
        while ($offset < $count) {
            $entities = \DB::table($tableName)->offset($offset)->limit($limit)->orderBy('id', 'asc')->get();
            foreach ($entities as $entity) {
                $row = [];
                foreach ($columnNames as $columnName) {
                    $row[] = $entity->$columnName;
                }
                $data[] = $row;
            }
            $offset += $limit;
        }

        /** @var Excel $excel */
        $excel = app()->make(Excel::class);
        $excel->create($outputPath, function ($excel) use ($data, $tableName) {
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
        })->export($format);

        return true;
    }
}
