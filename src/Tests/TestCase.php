<?php

namespace LaravelRocket\Foundation\Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Events\Dispatcher;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use WithoutMiddleware;
    
    public $baseUrl = 'http://localhost';

    /** @var bool */
    protected $useDatabase = false;

    /**
     * Setup DB before each test.
     */
    public function setUp()
    {
        parent::setUp();
        $this->app->boot();
        if ($this->useDatabase) {
            \DB::disableQueryLog();
            $this->artisan('migrate');
            $this->artisan('db:seed');
        }
    }

    public function tearDown()
    {
        if ($this->useDatabase) {
            $this->artisan('migrate:reset');
            \DB::disconnect();
        }

        parent::tearDown();
    }

    /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /** @var $app \Illuminate\Foundation\Application */
        if ( file_exists(__DIR__.'/../../vendor/laravel/laravel/bootstrap/app.php')) {
            $app = require __DIR__.'/../../vendor/laravel/laravel/bootstrap/app.php';
        } else {
            $app = require __DIR__.'/../../../../../bootstrap/app.php';
        }
        $this->setUpHttpKernel($app);
        $app->register(\Illuminate\Database\DatabaseServiceProvider::class);
        $app->register(\LaravelRocket\Foundation\Providers\ServiceProvider::class);

        return $app;
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    private function setUpHttpKernel($app)
    {
        $app->instance('request', (new \Illuminate\Http\Request())->instance());
        $app->make('Illuminate\Foundation\Http\Kernel', [$app, $this->getRouter()])->bootstrap();
    }

    /**
     * @return Router
     */
    protected function getRouter()
    {
        $router = new Router(new Dispatcher());

        return $router;
    }
}
