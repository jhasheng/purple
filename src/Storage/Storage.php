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
        return $this->adapter->find($id);
    }

    public function store(Request $request)
    {
        $this->adapter->store($request);
    }
}