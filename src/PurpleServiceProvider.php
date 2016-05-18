<?php

namespace Jhasheng\Purple;

use Illuminate\Support\ServiceProvider;
use Jhasheng\Purple\Adapter\MySQL;
use Jhasheng\Purple\Storage\Storage;

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

        $app->singleton('purple.storage', function($app) {
            return new Storage($app['purple.adapter']);
        });
        $app->singleton('purple.hook', PurpleHook::class);
        /**
         * @var $purple \Jhasheng\Purple\PurpleHook
         */
        $purple = $app->make('purple.hook');
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
        $router->get('/{id}/{key}', ['prefix' => $prefix, 'uses' => 'Jhasheng\Purple\Controller\PurpleController@index']);
    }

    /**
     * 发布配置文件及资源文件
     */
    protected function publishAssetsFiles()
    {
        $this->publishes([
            __DIR__ . '/../config/purple.php' => config_path('purple.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('purple')
        ]);
    }
}