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
    public function retrieve($id);

    public function store(Request $request);

    public function purge();
}