<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 13:38
 * Email: jhasheng@hotmail.com
 */

namespace Jhasheng\Purple\Collections;


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
        $this->data[$this->name] = [];
    }

    /**
     * 获取收集数据
     * @return mixed
     */
    public function getData()
    {
        return $this->data[$this->name];
    }

    /**
     * 获取收集器名称
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 获取收集器收集到的信息数量
     * @return int
     */
    public function getBadge()
    {
        return count($this->data[$this->name]);
    }

    public function formatData()
    {
        return [
            'data'   => $this->data[$this->name],
            'badge'  => $this->badge,
            'global' => $this->global
        ];
    }
}
