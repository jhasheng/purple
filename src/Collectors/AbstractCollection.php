<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 13:38
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Collectors;


use Illuminate\Foundation\Application;

abstract class AbstractCollection implements CollectionInterface
{
    /**
     * 收集到的数据
     * @var array
     */
    protected $data;

    /**
     * 收集器名称
     * @var string
     */
    protected $name;

    /**
     * 当前应用实例
     * @var Application
     */
    protected $app;

    /**
     * 模板名称
     * @var string
     */
    protected $template;

    /**
     * 结束收集的标记
     * @var bool
     */
    protected $live = false;

    /**
     * 收集数量
     * @var int
     */
    protected $badge = 0;

    /**
     * 公共信息
     * @var array
     */
    protected $global = [];

    /**
     * icon名称
     * @var string
     */
    protected $icon;
    
    protected $url;
    /**
     * 注册收集器
     * @param Application $app
     */
    public function register(Application $app)
    {
        $this->app = $app;
    }

    /**
     * 结束收集
     */
    public function live()
    {
        $this->live = true;
    }

    /**
     * 初始化收集器
     * @param Application $application
     */
    public function before(Application $application)
    {
        $this->data[$this->template] = [];
    }

    /**
     * 获取收集数据
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
    
    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function getGlobal()
    {
        return $this->global;
    }

    public function setGlobal($global)
    {
        $this->global = $global;
    }
    
    public function getBadge()
    {
        return $this->badge;
    }
    
    public function setBadge($badge)
    {
        $this->badge = $badge;
    }
    /**
     * 获取收集器名称
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function getTemplate()
    {
        return $this->template;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * 获取收集器收集到的信息数量
     * @return int
     */
    public function calcBadge()
    {
        $this->badge = count($this->data[$this->template]);
    }

    public function getMenu()
    {
        /**
         * @var $current \Illuminate\Routing\Route
         */
        $current = $this->app['router']->current();
        return [
            'name' => $this->getName(),
            'icon' => $this->getIcon(),
            'badge' => $this->getBadge(),
            'url' => route('purple.index', ['id' => $current->getParameter('id'), 'key' => $this->getName()])
        ];
    }

    public function formatData()
    {
        return [
            'data'   => $this->data,
            'badge'  => $this->badge,
            'global' => $this->global
        ];
    }
}
