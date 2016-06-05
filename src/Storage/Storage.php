<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 16:40
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Storage;


use Purple\Request\Request;

class Storage extends AbstractStorage
{

    public function retrieve($id)
    {
        $result = $this->adapter->retrieve($id);
        return unserialize($result->content);
    }

    public function store(Request $request)
    {
        $this->adapter->store($request);
    }
}