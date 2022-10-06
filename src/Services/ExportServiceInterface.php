<?php
namespace LaravelRocket\Foundation\Services;

interface ExportServiceInterface extends BaseServiceInterface
{
    /**
     * @param string $modelName
     *
     * @return \LaravelRocket\Foundation\Models\Base|null
     */
    public function getModel(string $modelName): ?\LaravelRocket\Foundation\Models\Base;

    /**
     * @param string $modelName
     *
     * @return \LaravelRocket\Foundation\Repositories\Eloquent\SingleKeyModelRepository|null
     */
    public function getRepository(string $modelName): ?\LaravelRocket\Foundation\Repositories\Eloquent\SingleKeyModelRepository;

    /**
     * @param \LaravelRocket\Foundation\Models\Base $model
     *
     * @return array
     */
    public function selectColumns(\Illuminate\Database\Eloquent\Model $model): array;

    /**
     * @param string $modelName
     *
     * @return bool
     */
    public function checkModelExportable(string $modelName): bool;
}
