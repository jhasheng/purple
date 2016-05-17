<?php

namespace Jhasheng\Purple;

use Illuminate\Support\ServiceProvider;

class PurpleServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
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
        $app->singleton('purple', PurpleHook::class);
        /**
         * @var $purple \Jhasheng\Purple\PurpleHook
         */
        $purple = $app->make('purple');
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
         * @var $router \Illuminate\Routing\Router
         */
//        $router = $this->app['router'];
    }

    /**
     * 发部配置文件及资源文件
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