<?php

namespace LaravelRocket\Foundation\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelRocket\Foundation\Auth\EloquentUserProvider;
use LaravelRocket\Foundation\Console\Commands\ExportTableToFile;
use LaravelRocket\Foundation\Console\Commands\ImportFileToTable;
use LaravelRocket\Foundation\Console\Commands\SetAppName;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* Auth */
        \Auth::provider('rocket-eloquent', function ($app, array $config) {
            return new EloquentUserProvider($app['hash'], $config['model']);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        /* Services */
        $this->app->singleton(
            \LaravelRocket\Foundation\Services\MailServiceInterface::class,
            \LaravelRocket\Foundation\Services\Production\MailService::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Services\ImageServiceInterface::class,
            \LaravelRocket\Foundation\Services\Production\ImageService::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Services\LanguageServiceInterface::class,
            \LaravelRocket\Foundation\Services\Production\LanguageService::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Services\SlackServiceInterface::class,
            \LaravelRocket\Foundation\Services\Production\SlackService::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Services\FileUploadServiceInterface::class,
            \LaravelRocket\Foundation\Services\Production\FileUploadService::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Services\FileUploadS3ServiceInterface::class,
            \LaravelRocket\Foundation\Services\Production\FileUploadS3Service::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Services\FileUploadLocalServiceInterface::class,
            \LaravelRocket\Foundation\Services\Production\FileUploadLocalService::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Services\ExportServiceInterface::class,
            \LaravelRocket\Foundation\Services\Production\ExportService::class
        );

        /* Helpers */
        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\DateTimeHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\DateTimeHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\LocaleHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\LocaleHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\URLHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\URLHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\CollectionHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\CollectionHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\StringHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\StringHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\PaginationHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\PaginationHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\TypeHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\TypeHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\RedirectHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\RedirectHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\DataHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\DataHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\FileHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\FileHelper::class
        );

        $this->app->singleton(
            \LaravelRocket\Foundation\Helpers\ArrayHelperInterface::class,
            \LaravelRocket\Foundation\Helpers\Production\ArrayHelper::class
        );

        //Commands
        $this->app->singleton('command.rocket.export.table', function ($app) {
            return new ExportTableToFile($app['files']);
        });

        $this->app->singleton('command.rocket.import.file', function ($app) {
            return new ImportFileToTable($app['files']);
        });

        $this->app->singleton('command.rocket.set.name', function ($app) {
            return new SetAppName($app['files']);
        });

        $this->commands('command.rocket.export.table', 'command.rocket.import.file', 'command.rocket.set.name');
    }
}
