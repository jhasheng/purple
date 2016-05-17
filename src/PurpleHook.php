<?php

namespace Jhasheng\Purple;

use Illuminate\Foundation\Application;
use Jhasheng\Purple\Collections\CollectionInterface;
use Jhasheng\Purple\Collections\Request;
use Jhasheng\Purple\Exceptions\InvalidCollectionException;
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
        Request::class,
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
            array_push($this->collections, $app->make($collection));
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
        
        $this->endHook();
    }


    /**
     * 是否为异步请求
     * @return bool
     */
    public function isAjax()
    {
        return $this->app['request']->isXmlHttpRequest();
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
    public function isInteractRequest()
    {
        return $this->prefix === $this->app['request']->segment(1);
    }

    /**
     * 收集分析数据
     */
    protected function endHook()
    {
        /**
         * @var $collection \Jhasheng\Purple\Collections\CollectionInterface
         */
        
        
        $collectionData = [];
        foreach ($this->collections as $collection) {
            $name = $collection->getName();
            $collectionData[$name] = $collection->formatData();
        }
        dd($collectionData);
    }

}
