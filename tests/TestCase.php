<?php

declare(strict_types=1);

/**
 * Contains the TestCase class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-09
 *
 */

namespace Vanilo\Admin\Tests;

use Cviebrock\EloquentSluggable\ServiceProvider as SluggableServiceProvider;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\ServiceProvider as BreadcrumbsServiceProvider;
use Konekt\AppShell\Providers\ModuleServiceProvider as AppShellModule;
use Konekt\Concord\ConcordServiceProvider;
use Konekt\Gears\Providers\GearsServiceProvider;
use Konekt\LaravelMigrationCompatibility\LaravelMigrationCompatibilityProvider;
use Konekt\Menu\Facades\Menu;
use Konekt\Menu\MenuServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Vanilo\Admin\Providers\ModuleServiceProvider as VaniloAdminModule;
use Vanilo\Framework\Providers\ModuleServiceProvider as VaniloFrameworkModule;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(realpath(__DIR__ . '/factories'));
        $this->setUpDatabase($this->app);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ConcordServiceProvider::class,
            MediaLibraryServiceProvider::class,
            GearsServiceProvider::class,
            LaravelMigrationCompatibilityProvider::class,
            BreadcrumbsServiceProvider::class,
            MenuServiceProvider::class,
            SluggableServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Breadcrumbs' => Breadcrumbs::class,
            'Menu' => Menu::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $engine = env('TEST_DB_ENGINE', 'sqlite');
        $app['path.lang'] = __DIR__ . '/lang';
        $app['config']->set('database.default', $engine);
        $app['config']->set('database.connections.' . $engine, [
            'driver' => $engine,
            'database' => 'sqlite' == $engine ? ':memory:' : 'vanilo_test',
            'prefix' => '',
            'host' => env('TEST_DB_HOST', '127.0.0.1'),
            'username' => env('TEST_DB_USERNAME', 'pgsql' === $engine ? 'postgres' : 'root'),
            'password' => env('TEST_DB_PASSWORD', ''),
            'port' => env('TEST_DB_PORT'),
        ]);

        if ('pgsql' === $engine) {
            $app['config']->set("database.connections.{$engine}.charset", 'utf8');
        }
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $this->loadLaravelMigrations();
        $this->artisan('migrate', ['--force' => true]);
    }

    /**
     * @inheritdoc
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);
        $app['config']->set('concord.modules', [
            AppShellModule::class,
            VaniloFrameworkModule::class,
            VaniloAdminModule::class,
        ]);
    }
}
