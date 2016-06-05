<?php

namespace Purple\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use Purple\Command\PurpleCommand;
use Purple\Exceptions\InvalidStorageException;
use Purple\PurpleHook;
use Purple\Request\Request;


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
        // 合并配置文件
        $this->mergeConfigFrom(__DIR__ . '/../../config/purple.php', 'purple');

        // 加载渲染视图模板
        $this->loadViewsFrom(__DIR__ . '/../Resources', 'purple');

        // 发布资源文件
        $this->publishAssetsFiles();

        // 注册路由
        $this->registerRouter();

        // 注册命令行
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

    /**
     * 获取文件存储方式
     * 
     * @param $type
     * @return \Purple\Storage\StorageInterface
     * @exception InvalidStorageException
     */
    protected function getStorage($type)
    {
        $className = '\Purple\Storage\\' . ucwords($type) . 'Storage';
        
        if (class_exists($className)) {
            return new $className;
        } else {
            throw new InvalidStorageException;
        }
    }
}
