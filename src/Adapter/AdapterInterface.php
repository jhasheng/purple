<?php

/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 17:20
 * Email: jhasheng@hotmail.com
 */
namespace Purple\Adapter;

use Purple\Request\Request;

interface AdapterInterface
{
    public function store(Request $storage);
    
    public function retrieve($id);
    
    public function clear();
}