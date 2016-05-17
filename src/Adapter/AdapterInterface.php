<?php

/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 17:20
 * Email: jhasheng@hotmail.com
 */
namespace Jhasheng\Purple\Adapter;

use Jhasheng\Purple\Storage\StorageInterface;

interface AdapterInterface
{
    public function store(StorageInterface $storage);
    
    public function find($id);
    
    public function clear();
}