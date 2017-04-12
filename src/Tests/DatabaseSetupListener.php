<?php
namespace Tests\Listeners;

class DatabaseSetupListener extends \PHPUnit_Framework_BaseTestListener
{
    protected $suites = ['Application Test Suite'];

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        if (in_array($suite->getName(), $this->suites)) {
            print 'RESET'.PHP_EOL;
            exec('php artisan migrate');
        }
    }

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        if (in_array($suite->getName(), $this->suites)) {
            print 'END'.PHP_EOL;
            exec('php artisan migrate:rollback');
        }
    }
}
