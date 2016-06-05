<?php

namespace Purple\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use Purple\Command\PurpleCommand;
use Purple\PurpleHook;
use Purple\Request\Request;
use Purple\Storage\FileStorage;
use Purple\Storage\MySQLStorage;
use Purple\Storage\RedisStorage;

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
        $this->mergeConfigFrom(__DIR__ . '/../../config/purple.php', 'purple');

        $this->loadViewsFrom(__DIR__ . '/../Resources', 'purple');

        $this->publishAssetsFiles();

        $this->registerRouter();

        $this->registerCommand();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $config = $app['config'];
        /**
         * @var $config \Illuminate\Config\Repository
         */
        $storage = $config->get('purple.storage', 'file');

        $app->singleton('purple.storage', function ($app) use ($storage) {
            $storage = $this->getStorage($storage);
            $storage->setApplication($app);
            return $storage;
        });
        $app->singleton('purple.hook', PurpleHook::class);

        $app->singleton('purple.request', Request::class);
        /** @var $purple \Purple\PurpleHook */
        $purple = $app->make('purple.hook');
        $purple->setPrefix($config->get('purple.prefix', '_purple'));
        $purple->registerHook();

    }

    /**
     * 注册自定义命令
     */
    protected function registerCommand()
    {
        $this->app['command.purple.clear'] = $this->app->share(function(){
            return new PurpleCommand($this->app['purple.storage']);
        });

        $this->commands('command.purple.clear');
    }

    /**
     * 注册自定义路由
     */
    protected function registerRouter()
    {
        /** @var $config \Illuminate\Config\Repository */
        $config = $this->app['config'];
        $prefix = $config->get('purple.prefix', '_purple');

        /** @var $router \Illuminate\Routing\Router */
        $router = $this->app['router'];
        $router->get('/{id}/{key?}', [
            'prefix' => $prefix,
            'as'     => 'purple.index',
            'uses'   => 'Purple\Controller\PurpleController@index'
        ]);
    }

    /**
     * 发布配置文件及资源文件
     */
    protected function publishAssetsFiles()
    {
        $this->publishes([
            __DIR__ . '/../../config/purple.php' => config_path('purple.php')
        ], 'purple.config');

        $this->publishes([
            __DIR__ . '/../../assets' => public_path('purple')
        ], 'purple.assets');

        $this->publishes([
            __DIR__ . '/../../migrations' => database_path('migrations')
        ], 'purple.sql');

    }

    protected function getStorage($type)
    {
        switch ($type) {
            case 'file':
                return new FileStorage();

            case 'redis':
                return new RedisStorage();

            case 'mysql':
                return new MySQLStorage();

            default:
                return new FileStorage();
        }
    }
}
