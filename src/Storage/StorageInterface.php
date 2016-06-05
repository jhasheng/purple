<?php

/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 16:24
 * Email: jhasheng@hotmail.com
 */
namespace Purple\Storage;

use Purple\Request\Request;

interface StorageInterface
{
    /**
     * 获取指定数据
     * @param $token
     * @return array
     */
    public function retrieve($token);

    /**
     * 保存收集到的数据
     * @param Request $request
     * @return void
     */
    public function store(Request $request);

    /**
     * 清空数据
     * @return void
     */
    public function purge();
}