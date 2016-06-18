<?php

/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 16:24
 * Email: jhasheng@hotmail.com
 */
namespace Purple\Storage;

use Illuminate\Foundation\Application;
use Purple\Request\Request;

interface StorageInterface
{
    /**
     * 存储当前运行实例
     * 
     * @param Application $application
     * @return void
     */
    public function setApplication(Application $application);
    
    /**
     * 获取指定数据
     * 
     * @param $token
     * @return array
     */
    public function retrieve($token);

    /**
     * 保存收集到的数据
     * 
     * @param Request $request
     * @return void
     */
    public function store(Request $request);

    /**
     * 清空数据
     * 
     * @return void
     */
    public function purge();

    /**
     * 获取所有数据，可分页
     * 
     * @param $pageNow
     * @return array
     */
    public function fetch($pageNow);
}