<?php
namespace LaravelRocket\Foundation\Tests;

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Routing\Router;

class TestCase extends BaseTestCase
{
    use WithoutMiddleware;

    protected $baseUrl = 'http://localhost';

    /** @var \Faker\Generator */
    protected $faker;

    /** @var bool */
    protected $useDatabase = false;

    /**
     * Setup DB before each test.
     */
    public function setUp()
    {
        parent::setUp();
        $this->app->boot();

        $databaseName = \DB::connection()->getDatabaseName();
        if ($this->useDatabase) {
            $tables  = \DB::select('SHOW TABLES');
            $keyName = 'Tables_in_'.$databaseName;
            foreach ($tables as $table) {
                if (property_exists($table, $keyName)) {
                    \DB::table($table->$keyName)->truncate();
                }
            }
            \DB::disableQueryLog();
            $this->artisan('db:seed');
        }
    }

    public function tearDown()
    {
        if ($this->useDatabase) {
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
        /* @var $app \Illuminate\Foundation\Application */
        if (file_exists(__DIR__.'/../../vendor/laravel/laravel/bootstrap/app.php')) {
            $app = require __DIR__.'/../../vendor/laravel/laravel/bootstrap/app.php';
        } else {
            $app = require __DIR__.'/../../../../../bootstrap/app.php';
        }
        $this->setUpHttpKernel($app);
        $app->register(\Illuminate\Database\DatabaseServiceProvider::class);
        $app->register(\LaravelRocket\Foundation\Providers\ServiceProvider::class);
        $this->faker = \Faker\Factory::create();

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
