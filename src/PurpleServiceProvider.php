<?php

namespace Purple;

use Illuminate\Support\ServiceProvider;
use Purple\Adapter\MySQL;
use Purple\Request\Request;
use Purple\Storage\Storage;

class PurpleServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/purple.php', 'purple');

        $this->loadViewsFrom(__DIR__ . '/Resources', 'purple');

        $this->publishAssetsFiles();

        $this->registerRouter();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $app->singleton('purple.adapter', MySQL::class);

        $app->singleton('purple.storage', function ($app) {
            return new Storage($app['purple.adapter']);
        });
        $app->singleton('purple.hook', PurpleHook::class);
        
        $app->singleton('purple.request', Request::class);
        /**
         * @var $purple \Purple\PurpleHook
         */
        $purple = $app->make('purple.hook');
        $purple->setPrefix($app['config']->get('purple.prefix', '_purple'));
        $purple->registerHook();
    }

    /**
     * 注册自定义命令
     */
    protected function registerCommand()
    {

    }

    /**
     * 注册自定义路由
     */
    protected function registerRouter()
    {
        /**
         * @var $config \Illuminate\Config\Repository
         */
        $config = $this->app['config'];
        $prefix = $config->get('purple.prefix', '_purple');

        /**
         * @var $router \Illuminate\Routing\Router
         */
        $router = $this->app['router'];
        $router->get('/{id}/{key}', ['prefix' => $prefix, 'as' => 'purple.index', 'uses' => 'Purple\Controller\PurpleController@index']);
    }

    /**
     * 发布配置文件及资源文件
     */
    protected function publishAssetsFiles()
    {
        $this->publishes([
            __DIR__ . '/../config/purple.php' => config_path('purple.php')
        ], 'purple.config');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('purple')
        ], 'purple.assets');

        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations')
        ], 'purple.sql');

        $this->publishes([
            __DIR__ . '/Resources' => resource_path('views/purple')
        ], 'purple.view');

    }

}