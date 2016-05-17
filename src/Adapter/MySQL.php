<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 17:23
 * Email: jhasheng@hotmail.com
 */

namespace Jhasheng\Purple\Adapter;


use Illuminate\Database\Eloquent\Model;
use Jhasheng\Purple\Storage\StorageInterface;

class MySQL extends Model implements AdapterInterface
{

    public function store(StorageInterface $storage)
    {
        // TODO: Implement store() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }
}