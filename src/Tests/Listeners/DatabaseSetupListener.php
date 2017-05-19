<?php
namespace LaravelRocket\Foundation\Tests\Listeners;

use Illuminate\Contracts\Console\Kernel;

class DatabaseSetupListener extends \PHPUnit_Framework_BaseTestListener
{
    protected $suites = ['Application Test Suite'];

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        if (in_array($suite->getName(), $this->suites)) {
            $this->initialize($suite);
        }
    }

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        if (in_array($suite->getName(), $this->suites)) {
            $this->terminate($suite);
        }
    }

    protected function initialize(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->createDatabase();
        exec('php artisan migrate');
    }

    protected function terminate(\PHPUnit_Framework_TestSuite $suite)
    {
        exec('php artisan migrate:reset');
        $this->dropDatabase();
    }

    protected function createApplication()
    {
        if (file_exists(__DIR__.'/../../vendor/laravel/laravel/bootstrap/app.php')) {
            $app = require __DIR__.'/../../vendor/laravel/laravel/bootstrap/app.php';
        } else {
            $app = require __DIR__.'/../../../../../../bootstrap/app.php';
        }
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function getDatabaseConnection()
    {
        $setting = config('database.default');

        $driver   = config('database.connections.'.$setting.'.driver');
        $host     = config('database.connections.'.$setting.'.host');
        $port     = config('database.connections.'.$setting.'.port');
        $username = config('database.connections.'.$setting.'.username');
        $password = config('database.connections.'.$setting.'.password');

        $connection = new \PDO("{$driver}:host={$host};port={$port}", $username, $password);

        return $connection;
    }

    protected function getDatabaseName()
    {
        $setting  = config('database.default');
        $database = config('database.connections.'.$setting.'.database');

        return $database;
    }

    protected function createDatabase()
    {
        $this->createApplication();
        $connection = $this->getDatabaseConnection();
        $database   = $this->getDatabaseName();
        $connection->query('DROP DATABASE IF EXISTS '.$database);
        $connection->query('CREATE DATABASE '.$database);
    }

    protected function dropDatabase()
    {
        $this->createApplication();
        $connection = $this->getDatabaseConnection();
        $database   = $this->getDatabaseName();
        $connection->query('DROP DATABASE '.$database);
    }
}
