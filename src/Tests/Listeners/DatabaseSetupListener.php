<?php
namespace LaravelRocket\Foundation\Tests\Listeners;

use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\TestSuite;

class DatabaseSetupListener extends BaseTestListener
{
    protected $suites = ['Application Test Suite'];

    public function startTestSuite(TestSuite $suite)
    {
        if (in_array($suite->getName(), $this->suites)) {
            exec('php artisan migrate --database testing');
        }
    }

    public function endTestSuite(TestSuite $suite)
    {
        if (in_array($suite->getName(), $this->suites)) {
            exec('php artisan migrate:rollback --database testing');
        }
    }
}
