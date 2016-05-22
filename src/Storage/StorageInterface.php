<?php

/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 5/21/2016
 * Time: 2:06 PM
 */

namespace Purple\Storage;

use Purple\Request\Request;

interface StorageInterface
{
    /**
     * 存储数据
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);

    /**
     * 获取数据
     * @param $id
     * @return mixed
     */
    public function retrieve($id);

    /**
     * 清空数据
     * @return mixed
     */
    public function clear();
}