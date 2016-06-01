<?php

namespace Purple;

use Illuminate\Foundation\Application;
use Purple\Collections\CollectionInterface;
use Purple\Collections\Dashboard;
use Purple\Collections\Database;
use Purple\Collections\Event;
use Purple\Collections\Info;
use Purple\Collections\Request;
use Purple\Collections\Route;
use Purple\Exceptions\InvalidCollectionException;
use Symfony\Component\HttpFoundation\Response;

class PurpleHook
{
    /**
     * 当前应用实例
     * @var Application
     */
    protected $app;
    /**
     * 是否启用分析器
     * @var bool
     */
    protected $enable = true;
    /**
     * 路由前缀
     * @var string
     */
    protected $prefix = '_purple';

    /**
     * 可用分析器
     * @var array
     */
    protected $defaultCollections = [
        Dashboard::class,
        Request::class,
        Event::class,
        Database::class,
        Route::class,
        Info::class,
    ];

    /**
     * 可用分析器实例
     * @var array
     */
    protected $collections = [];

    /**
     * 初始化分析器
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        foreach ($this->defaultCollections as $collection) {
//            array_push($this->collections, $app->make($collection));
            $collection                                = $app->make($collection);
            $this->collections[$collection->getName()] = $collection;
        }
    }

    /**
     * 分析器注册
     */
    public function registerHook()
    {
        foreach ($this->collections as $collection) {
            // 所有分析器必需实现 CollectionInterface
            if (!($collection instanceof CollectionInterface)) {
                throw new InvalidCollectionException;
                break;
            }
            $collection->register($this->app);
        }
    }

    public function getCollection($name)
    {
        return $this->collections[$name];
    }

    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * 分析器初始化
     */
    public function beforeHook()
    {
        foreach ($this->collections as $collection) {
            $collection->before($this->app);
        }
    }

    /**
     * 分析器结束
     * @param Response $response
     */
    public function afterHook(Response $response)
    {
        foreach ($this->collections as $collection) {
            $collection->after($this->app, $response);
        }

        $uuid = $this->endHook();

        if (!$this->isAjax()) {
            $content = $response->getContent();

            $button = view('purple::button', compact('uuid'))->render();
            $response->setContent($content . $button);
//            $render = new JavascriptRender($response);
//            $render->renderPurpleButton();
        }
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * 是否启用分析器
     * @return bool
     */
    public function isEnable()
    {
        return $this->enable;
    }

    /**
     * 是否运行在命令行内部
     * @return bool
     */
    public function inConsole()
    {
        return $this->app->runningInConsole();
    }

    /**
     * 是否为内部请求
     * @return bool
     */
    public function isBuiltInRequest()
    {
        return $this->prefix === $this->app['request']->segment(1);
    }


    /**
     * 是否为异步请求
     * @return bool
     */
    protected function isAjax()
    {
        return $this->app['request']->isXmlHttpRequest();
    }

    /**
     * 收集分析数据
     */
    protected function endHook()
    {
        /**
         * @var $collection \Purple\Collections\CollectionInterface
         */
        $request        = $this->app['purple.request'];
        $collectionData = [];
        foreach ($this->collections as $collection) {
            $name                  = $collection->getName();
            $collectionData[$name] = $collection->formatData();
        }
//dd($collectionData);
        $uuid = uniqid();
        $request->setUuid($uuid);
        $request->setTime(microtime(true) - LARAVEL_START);
        $request->setUri($this->getCurrentRequestUri());
        $request->setContent($collectionData);

        /**
         * @var $storage \Purple\Storage\StorageInterface
         */
        $storage = $this->app['purple.storage'];
        $storage->store($request);
        return $uuid;
    }

    protected function getCurrentRequestUri()
    {
        $current = $this->app['router']->current();
        $request = $this->app['request'];

        return "{$request->getMethod()} {$current->getPath()}";
    }

}
