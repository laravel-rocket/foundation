<?php

namespace LaravelRocket\Foundation\Services;

interface ExportServiceInterface extends BaseServiceInterface
{
    public function getModel(string $modelName): ?\LaravelRocket\Foundation\Models\Base;

    public function getRepository(string $modelName): ?\LaravelRocket\Foundation\Repositories\Eloquent\SingleKeyModelRepository;

    /**
     * @param  \LaravelRocket\Foundation\Models\Base  $model
     */
    public function selectColumns(\Illuminate\Database\Eloquent\Model $model): array;

    public function checkModelExportable(string $modelName): bool;
}
