<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 5/21/2016
 * Time: 2:10 PM
 */

namespace Purple\Storage;


use Purple\Request\Request;

class Storage implements StorageInterface
{

    /**
     * 存储数据
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // TODO: Implement store() method.
    }

    /**
     * 获取数据
     * @param $id
     * @return mixed
     */
    public function retrieve($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * 清空数据
     * @return mixed
     */
    public function clear()
    {
        // TODO: Implement clear() method.
    }
}