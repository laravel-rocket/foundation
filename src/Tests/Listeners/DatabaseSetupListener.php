<?php
namespace LaravelRocket\Foundation\Tests\Listeners;

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
        exec('php artisan migrate');
    }

    protected function terminate(\PHPUnit_Framework_TestSuite $suite)
    {
        exec('php artisan migrate:reset');
    }

}
