<?php
namespace LaravelRocket\Foundation\Tests\Listeners;

class DatabaseSetupListener extends \PHPUnit_Framework_BaseTestListener
{
    protected $suites = ['Application Test Suite'];

    public function startTestSuite($suite)
    {
        if (in_array($suite->getName(), $this->suites)) {
            exec('php artisan migrate');
        }
    }

    public function endTestSuite($suite)
    {
        if (in_array($suite->getName(), $this->suites)) {
            exec('php artisan migrate:rollback');
        }
    }
}
