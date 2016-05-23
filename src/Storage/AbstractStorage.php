<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 16:32
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Storage;


use Purple\Adapter\AdapterInterface;

abstract class AbstractStorage implements StorageInterface
{
    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
}