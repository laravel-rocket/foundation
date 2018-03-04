<?php
namespace LaravelRocket\Foundation\Tests\Listeners;

use Illuminate\Contracts\Console\Kernel;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\Warning;
use PHPUnit\Framework\AssertionFailedError;


class DatabaseSetupListener implements TestListener
{
    protected $suites = ['Application Test Suite'];

    public function addError(Test $test, \Throwable $e, float $time) : void
    {
    }

    public function addWarning(Test $test, Warning $e, float $time): void
    {
    }

    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
    }

    public function addIncompleteTest(Test $test, \Throwable $t, float $time): void
    {
    }

    public function addRiskyTest(Test $test, \Throwable $t, float $time): void
    {
    }

    public function addSkippedTest(Test $test, \Throwable $t, float $time): void
    {
    }

    public function startTestSuite(TestSuite $suite): void
    {
        if (in_array($suite->getName(), $this->suites)) {
            $this->initialize($suite);
        }
    }

    public function endTestSuite(TestSuite $suite): void
    {
        if (in_array($suite->getName(), $this->suites)) {
            $this->terminate($suite);
        }
    }

    public function startTest(Test $test): void
    {
    }

    public function endTest(Test $test, float $time): void
    {
    }

    protected function initialize(TestSuite $suite)
    {
        $this->createDatabase();
        exec('php artisan migrate');
    }

    protected function terminate(TestSuite $suite)
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
