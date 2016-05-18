<?php

/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 17:20
 * Email: jhasheng@hotmail.com
 */
namespace Jhasheng\Purple\Adapter;

use Jhasheng\Purple\Request\Request;

interface AdapterInterface
{
    public function store(Request $storage);
    
    public function find($id);
    
    public function clear();
}